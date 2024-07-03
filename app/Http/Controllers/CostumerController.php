<?php

namespace App\Http\Controllers;

use App\Models\Costumer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CostumerController extends Controller
{

    public function __construct(protected Costumer $costumerCarInstance)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $costumerCar = array();

        if ($request->has('costumer_attributes')) {
            $costumer_attributes = $request->costumer_attributes;
            $costumerCar = $this->costumerCarInstance->$costumer_attributes;
        } else {
            $costumerCar = $this->costumerCarInstance;
        }

        if ($request->has('filter_attributes')) {
            /* Like Operator: model_name:like:%Ford% */
            $multipleFilters = explode(';', $request->filter_attributes);

            foreach ($multipleFilters as $key => $condition) {

                $conditionsFilter = explode(':', $condition);
                $costumerCar = $costumerCar->where($conditionsFilter[0], $conditionsFilter[1], $conditionsFilter[2]);
            }
        }

        if ($request->has('single_attributes')) {
            $single_attributes = $request->single_attributes;
            $costumerCar = $costumerCar->selectRaw($single_attributes)->get();
        } else {
            $costumerCar = $costumerCar->get();
        }

        return response()->json($costumerCar, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->costumerCarInstance->rules());

        $carStored = $this->costumerCarInstance->create([
            "costumer_name" => $request->costumer_name
        ]);
        return response()->json($carStored, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $car = $this->costumerCarInstance->find($id);

        if (!$car) {
            return response()->json(['errorMessage' => 'Searched costumer does not exist!'], 404);
        }

        return response()->json($car, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {

        $carId = $this->costumerCarInstance->find($id);
        if (!$carId) {
            return response()->json(['errorMessage' => 'Error On Update, The Costumer Does Not Exist!'], 404);
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
        $carId = $this->costumerCarInstance->find($id);
        if (!$carId) {
            return response()->json(['errorMessage' => 'Error On Remove, The Costumer Does Not Exist!'], 404);
        }

        $carId->delete($carId);
        return response()->json(['SuccessMessage' => 'Costumer removed successfully!'], 200);
    }

}
