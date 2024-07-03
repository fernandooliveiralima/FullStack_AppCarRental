<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{

    public function __construct(protected Car $modelCarInstance)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $elementCar = array();

        if ($request->has('car_attributes')) {
            $car_attributes = $request->car_attributes;
            $elementCar = $this->modelCarInstance->with('modelCarRelation:id,' . $car_attributes);
        } else {
            $elementCar = $this->modelCarInstance->with('modelCarRelation');
        }

        if ($request->has('filter_attributes')) {
            /* Like Operator: model_name:like:%Ford% */
            $multipleFilters = explode(';', $request->filter_attributes);

            foreach ($multipleFilters as $key => $condition) {

                $conditionsFilter = explode(':', $condition);
                $elementCar = $elementCar->where($conditionsFilter[0], $conditionsFilter[1], $conditionsFilter[2]);
            }
        }

        if ($request->has('single_attributes')) {
            $single_attributes = $request->single_attributes;
            $elementCar = $elementCar->selectRaw($single_attributes)->get();
        } else {
            $elementCar = $elementCar->get();
        }

        return response()->json($elementCar, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->modelCarInstance->rules());

        $carStored = $this->modelCarInstance->create([
            "model_cars_id" => $request->model_cars_id,
            "plate" => $request->plate,
            "available" => $request->available,
            "km" => $request->km
        ]);
        return response()->json($carStored, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $car = $this->modelCarInstance->with('modelCarRelation')->find($id);

        if (!$car) {
            return response()->json(['errorMessage' => 'Searched resource does not exist!'], 404);
        }

        return response()->json($car, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {

        $carId = $this->modelCarInstance->find($id);
        if (!$carId) {
            return response()->json(['errorMessage' => 'Error On Update, The Record Does Not Exist!'], 404);
        }

        if ($request->method() === 'PATCH') {

            $dinamicRules = array();

            foreach ($carId->rules() as $input => $rule) {
                if (array_key_exists($input, $request->all())) {
                    $dinamicRules[$input] = $rule;
                }
            }

            $request->validate($dinamicRules);
        } else {

            $request->validate($carId->rules());
        }

        /* preencher o objeto marca com o payload do request */
        $carId->fill($request->all());;
        $carId->save();

        return response()->json($carId, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $carId = $this->modelCarInstance->find($id);
        if (!$carId) {
            return response()->json(['errorMessage' => 'Error On Remove, The Record Does Not Exist!'], 404);
        }

        $carId->delete($carId);
        return response()->json(['SuccessMessage' => 'Car removed successfully!'], 200);
    }
}
