<?php

namespace App\Http\Controllers\API\V1;

use App\Menu;
use App\Place;
use App\Poi;
use App\Location;
use App\Findable;
use Illuminate\Http\Request;
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;

class PlaceController extends Controller
{
    /**
     * Return a list of items.
     *
     * @param Request $request
     *
     * @return json
     */
    public function index(Request $request)
    {
    	$request->request->add(array('activated' => 1));
        return $this->filteredAndOrdered($request, new Place())->paginate($this->pageSize);
    }

    /**
     * Save a new item.
     *
     * @param Request $request
     *
     * @return json
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'name' => 'required|max:255',
        ]);

        return response(Place::create($request->all()), 201);
    }

    /**
     * Return a findable Location
     *
     * @param Request $request
     * @param int     $id
     *
     * @return json
     */
    public function find(Request $request, $id)
    {
        $response = new \stdClass();
	    $identifier = $request->find_identifier;
	    
	    if ( empty( $identifier ) ) {
	        $response->status = 'Not Found';
	        $response->data = [];
	        
            return response()->json( $response );		    
	    }

	    $findable = Findable::where( 'identifier', $identifier )->first();
	    
	    if ( empty( $findable ) ) {
	        $response->status = 'Not Found';
	        $response->data = [];

            return response()->json( $response );
	    }

        $place = Place::findOrFail($id);

	    if ( empty( $place ) ) {
	        $response->status = 'Not Found';
	        $response->data = [];

            return response()->json( $response );
	    }

		return $this->{'findable' . $identifier}( $place, $findable, $request );
    }

	private function findableIMS ( $place, $findable, Request $request ) {

        $response = new \stdClass();
        
        
        if ( empty( $request->data['Faust'] ) ) {
	        $response->status = 'Not Found';
	        $response->data = [];
	        
            return response()->json( $response );	        
        }
        
        $faust = $request->data['Faust'];

        SoapWrapper::add(function ($service) {
            $service
                ->name('imssecurity')
                ->wsdl('https://ims.lyngsoesystems.com/kkb/ImsWs/soap/Security?wsdl')
                ->trace(true)
                ->cache(WSDL_CACHE_NONE);
        });

        $payload = [
            'Username' => config('services.ims.username'),
            'Password' => config('services.ims.password'),
            'ClientInfo' => config('services.ims.client'),
        ];
        
		$ims_response = '';
        SoapWrapper::service('imssecurity', function ($service) use ($payload, &$ims_response) {
			$ims_response = $service->call('Login', [$payload]);
        });

		$token = $ims_response->Token;
        
        SoapWrapper::add(function ($service) {
            $service
                ->name('imsquery')
                ->wsdl('https://ims.lyngsoesystems.com/kkb/ImsWs/soap/Query?wsdl')
                ->trace(true)
                ->cache(WSDL_CACHE_NONE);
        });        
        
        $request = (object) $request->json()->all();
        $locations = Location::where( 'findable_id', $findable->id )->lists('parameter_one', 'id');
        
		$ims_locations = [];
        foreach( $locations as $id => $parameter_one ) {
			$ims_locations[$id] = $parameter_one;
        }

        $payload = [
            'Token' => $token,
            'BibliographicRecordId' => $faust,
            'IlsStatusKey' => 0,
            'Excluded' => false,
        ];
        
		$ims_response = '';
        SoapWrapper::service('imsquery', function ($service) use ($payload, &$ims_response) {
			$ims_response = $service->call('FindItems', [$payload]);
        });

        if ( empty( $ims_response->Items ) ) {
	        $response->status = 'Not Found';
	        $response->data = [];
	        
            return response()->json( $response );
        }

        $ims_found_location = 0;
		foreach( $ims_response->Items as $item ) {
			if ( ! empty( $item->ShortPlacementText ) && in_array( $item->ShortPlacementText, $ims_locations ) ) {
				$ims_found_location = array_search( $item->ShortPlacementText, $ims_locations );
			}
		}

        if ( empty( $ims_found_location ) ) {
	        $response->status = 'Not Found';
	        $response->data = [];
	        
            return response()->json( $response );
        }
        
        $location = Location::findOrFail( $ims_found_location );

        $response->status = 'Found';
        $response->data = new \stdClass();

        $response->data->floor = new \stdClass();
        $response->data->floor->id = $location->floor_id;

        $response->data->location = new \stdClass();
        $response->data->location->id = $location->id;
        $response->data->location->posX = $location->posX;
        $response->data->location->posY = $location->posY;

        return response()->json( $response );
	}

    /**
     * Return a single item.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return json
     */
    public function show(Request $request, $id)
    {
        $place = Place::findOrFail($id);

		$place = $this->attachResources($request, $place);
		foreach( $place->floors as $floor ) {
			foreach( $floor->locations as $location ) {
				if ( $location->poi_id > 0 ) {
					$poi = Poi::findOrFail( $location->poi_id );
					$location->poi = $poi;
				} else {
					$location->poi = null;
				}
			}
		}

		return $place;
    }

    /**
     * Update a single item.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return json
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
           'name' => 'max:255',
        ]);

        $model = Place::findOrFail($id);
        $model->update($request->all());

        return $model;
    }

    /**
     * Delete a single item.
     *
     * @param int $id
     *
     * @return empty
     */
    public function destroy($id)
    {
        Place::findOrFail($id)->delete();

        return response('', 204);
    }

    /**
     * Return a list of deleted items.
     *
     * @return json
     */
    public function deleted()
    {
        return Place::onlyTrashed()->get();
    }

    /**
     * Get menu items.
     *
     * @param int $id
     *
     * @return json
     */
    public function menu($id)
    {
        return Menu::where('place_id', $id)->orderBy('order')->with('poi')->get();
    }

}
