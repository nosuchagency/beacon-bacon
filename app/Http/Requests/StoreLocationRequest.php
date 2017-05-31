<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $type = $this->get('type');

        $rules['name'] = 'required|max:255';
        $rules['type'] = 'required|max:255';

        if($type == 'findable')  {
            $rules['findable_id'] = 'required|integer|exists:findables,id';
        }

        if($type == 'block') {
            $rules['block_id'] = 'required|integer|exists:blocks,id';
            $rules['findable_id'] = 'integer|exists:findables,id';
        }

        if($type == 'beacon') {
            $rules['beacon_id'] = 'required|integer|exists:beacons,id';
        }

        if($type == 'poi') {
            $rules['poi_id'] = 'required|integer|exists:pois,id';
        }

        return $rules;
    }
}
