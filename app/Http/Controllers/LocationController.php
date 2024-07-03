<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    
    public function __construct(protected Location $locationCarInstance)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $locationCar = array();

        if ($request->has('location_attributes')) {
            $location_attributes = $request->location_attributes;
            $locationCar = $this->locationCarInstance->$location_attributes;
        } else {
            $locationCar = $this->locationCarInstance;
        }

        if ($request->has('filter_attributes')) {
            /* Like Operator: model_name:like:%Ford% */
            $multipleFilters = explode(';', $request->filter_attributes);

            foreach ($multipleFilters as $key => $condition) {

                $conditionsFilter = explode(':', $condition);
                $locationCar = $locationCar->where($conditionsFilter[0], $conditionsFilter[1], $conditionsFilter[2]);
            }
        }

        if ($request->has('single_attributes')) {
            $single_attributes = $request->single_attributes;
            $locationCar = $locationCar->selectRaw($single_attributes)->get();
        } else {
            $locationCar = $locationCar->get();
        }

        return response()->json($locationCar, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->locationCarInstance->rules());

        $locationStored = $this->locationCarInstance->create([
            "costumer_id" => $request->costumer_id,
            "car_id" => $request->car_id,
            "date_start_period" => $request->date_start_period,
            "date_end_period" => $request->date_end_period,
            "end_date_realized_period" => $request->end_date_realized_period,
            "daily_value" => $request->daily_value,
            "km_start" => $request->km_start,
            "km_end" => $request->km_end
        ]);
        return response()->json($locationStored, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $location = $this->locationCarInstance->find($id);

        if (!$location) {
            return response()->json(['errorMessage' => 'Searched location does not exist!'], 404);
        }

        return response()->json($location, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {

        $locationId = $this->locationCarInstance->find($id);
        if (!$locationId) {
            return response()->json(['errorMessage' => 'Error On Update, The Location Does Not Exist!'], 404);
        }

        if ($request->method() === 'PATCH') {

            $dinamicRules = array();

            foreach ($locationId->rules() as $input => $rule) {
                if (array_key_exists($input, $request->all())) {
                    $dinamicRules[$input] = $rule;
                }
            }

            $request->validate($dinamicRules);
        } else {

            $request->validate($locationId->rules());
        }

        /* preencher o objeto marca com o payload do request */
        $locationId->fill($request->all());;
        $locationId->save();

        return response()->json($locationId, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $locationId = $this->locationCarInstance->find($id);
        if (!$locationId) {
            return response()->json(['errorMessage' => 'Error On Remove, The Location Does Not Exist!'], 404);
        }

        $locationId->delete($locationId);
        return response()->json(['SuccessMessage' => 'Location removed successfully!'], 200);
    }

}
