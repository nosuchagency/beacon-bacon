<?php

namespace App\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Image;

class GenerateMap extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $locations;
    protected $floor;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($locations, $floor)
    {
        $this->locations = $locations;
        $this->floor = $floor;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $floorImage = Image::make(storage_path() . '/app/floors/' . $this->floor->id . '/original-' . basename($this->floor->image));

        foreach ($this->locations as $location) {

            if ($location['type'] != 'block' || empty($location['block']['image'])) {
                continue;
            }

            try {
                $blockImage = Image::make(storage_path() . '/app/blocks/' . $location['block']['id'] . '/' .  $location['block']['image']);
                $blockImage->rotate(-$location['rotation']);
                $floorImage->insert($blockImage, 'top-left', round($location['posX'] - ($blockImage->width() / 2)), round($location['posY'] - ($blockImage->height() / 2)));
            } catch (\Exception $e) {
            }
        }

        $floorImage->save(storage_path() . '/app/floors/' . $this->floor->id . '/' . basename($this->floor->image));
    }
}
