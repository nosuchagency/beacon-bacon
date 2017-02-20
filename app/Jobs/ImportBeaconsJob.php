<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class ImportBeaconsJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $service;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $externalBeacons = $this->getBeaconsFromWebservice($this->service);
        foreach ($externalBeacons as $externalBeaconId) {
            $beacon = DB::table('beacons')->where('beacon_uid', $externalBeaconId)->first();

            if (empty($beacon)) {

                $device = $this->getBeaconFromWebservice($externalBeaconId, $this->service);
                try {
                    DB::table('beacons')->insert([
                        'name' => $device->uniqueId,
                        'beacon_uid' => $device->uniqueId,
                        'proximity_uuid' => $device->proximity,
                        'minor' => $device->minor,
                        'major' => $device->major,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString()
                    ]);
                } catch (\Exception $e) {
                    echo $e;
                }

            } else {
                echo "tom!";
            }
        }

    }

    /**
     * Get beacons from Kontakt webservice
     * @return Illuminate\Support\Collection
     */
    protected function getBeaconsFromWebservice($service)
    {
        $data = [];
        switch ($service) {
            case 'kontakt.io':
                $data = $this->getBeaconsFromKontakt();
                break;
            case 'estimote':
                $data = $this->getBeaconsFromEstimote();
                break;
            case 'test':
                $data = $this->getBeaconsFromTest();
                break;
        }
        return $data;
    }

    protected function getBeaconFromWebservice($beaconId, $service)
    {
        $data = [];

        switch ($service) {
            case 'kontakt.io':
                $data = $this->getBeaconFromKontakt($beaconId);
                break;
            case 'estimote':
                $data = $this->getBeaconFromEstimote($beaconId);
                break;
            case 'test':
                $data = $this->getBeaconFromTest($beaconId);
                break;
        }
        return $data;
    }

    protected function getBeaconsFromKontakt()
    {
        $settings = DB::table('settings')->get();

        $client = new Client([
            'base_uri' => 'https://api.kontakt.io/',
            'headers' => [
                'Accept' => 'application/vnd.com.kontakt+json;version=8',
                'Api-Key' => $settings[3]->value,
                'User-Agent' => 'BeaconBacon'
            ]
        ]);

        try {
            $response = $client->request('GET', '/device?maxResult=5');
            $results = json_decode($response->getBody()->getContents());
            $devices = collect();

            foreach ($results->devices as $device) {
                $devices->put($device->uniqueId, $device->uniqueId . ($device->alias ? ' (' . $device->alias . ')' : ''));

            }

            return $devices;
        } catch (\Exception $e) {
            return [];
        }
    }

    protected function getBeaconFromKontakt($beaconId)
    {
        $settings = DB::table('settings')->get();

        $client = new Client([
            'base_uri' => 'https://api.kontakt.io/',
            'headers' => [
                'Accept' => 'application/vnd.com.kontakt+json;version=8',
                'Api-Key' => $settings[3]->value,
                'User-Agent' => 'BeaconBacon'
            ]
        ]);

        try {
            $response = $client->request('GET', '/device/' . $beaconId);
            $results = json_decode($response->getBody()->getContents());
            return $results;
        } catch (\Exception $e) {
            echo $e;
            return null;
        }
    }

    protected function getBeaconsFromEstimote()
    {
        $settings = DB::table('settings')->get();

        $client = new Client([
            'base_uri' => 'https://cloud.estimote.com/v2/',
            'headers' => [
                'Accept' => 'application/json;'
            ]
        ]);

        try {
            $response = $client->request('GET', 'devices', ['auth' => ['user', $settings[3]->value]]);
            $results = json_decode($response->getBody()->getContents());
            $devices = collect();

            foreach ($results->devices as $device) {
                $devices->put($device->uniqueId, $device->uniqueId . ($device->alias ? ' (' . $device->alias . ')' : ''));
            }

            return $devices;
        } catch (\Exception $e) {
            return [];
        }
    }

    protected function getBeaconFromEstimote($beaconId)
    {
        $settings = DB::table('settings')->get();

        $client = new Client([
            'base_uri' => 'https://cloud.estimote.com/v2/',
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        try {
            $response = $client->request('GET', 'devices/' . $beaconId, ['auth' => ['user', $settings[3]->value]]);
            $results = json_decode($response->getBody()->getContents());
            return $results;
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function getBeaconsFromTest()
    {
        $devices = collect();

        $devices->put('uniqueId', 'testeren');
        $devices->put('uniqueId', 'tove2');

        return $devices;
    }

    protected function getBeaconFromTest($beaconId)
    {
        $data = new \stdClass;
        $data->uniqueId = "tove2";
        $data->beacon_uid = "tove2";
        $data->proximity = "testeren";
        $data->minor = "1234";
        $data->major = "4321";

        return $data;
    }
}
