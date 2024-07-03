<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\ModelCar;

class ModelCarController extends Controller
{

    public function __construct(protected ModelCar $modelCarInstance)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $modelsCar = array();

        if ($request->has('brand_attributes')) {
            $brand_attributes = $request->brand_attributes;
            $modelsCar = $this->modelCarInstance->with('brandCarRelation:id,' . $brand_attributes);
        } else {
            $modelsCar = $this->modelCarInstance->with('brandCarRelation');
        }

        if ($request->has('filter_attributes')) {
            /* Like Operator: model_name:like:%Ford% */
            $multipleFilters = explode(';', $request->filter_attributes);
            
            foreach($multipleFilters as $key => $condition){

                $conditionsFilter = explode(':', $condition);
                $modelsCar = $modelsCar->where($conditionsFilter[0], $conditionsFilter[1], $conditionsFilter[2]);
            }

        }

        if ($request->has('single_attributes')) {
            $single_attributes = $request->single_attributes;
            $modelsCar = $modelsCar->selectRaw($single_attributes)->get();
        } else {
            $modelsCar = $modelsCar->get();
        }

        //$getAllModels = $this->modelCarInstance->with('brandCarRelation')->get();
        return response()->json($modelsCar, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->modelCarInstance->rules());

        $imageElement = $request->model_image;
        $image_urn = $imageElement->store('images/modelCars', 'public');

        $modelStored = $this->modelCarInstance->create([
            'brand_id' => $request->brand_id,
            'model_name' => $request->model_name,
            'model_image' => $image_urn,
            'number_doors' => $request->number_doors,
            'places' => $request->places,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs

        ]);
        return response()->json($modelStored, 201);
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        $model = $this->modelCarInstance->with('brandCarRelation')->find($id);

        if (!$model) {
            return response()->json(['errorMessage' => 'Searched resource does not exist!'], 404);
        }

        return response()->json($model, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $modelId = $this->modelCarInstance->find($id);
        if (!$modelId) {
            return response()->json(['errorMessage' => 'Error On Update, The Record Does Not Exist!'], 404);
        }

        if ($request->method() === 'PATCH') {

            $dinamicRules = array();

            foreach ($modelId->rules() as $input => $rule) {
                if (array_key_exists($input, $request->all())) {
                    $dinamicRules[$input] = $rule;
                }
            }

            $request->validate($dinamicRules);
        } else {

            $request->validate($modelId->rules());
        }

        /* remove o arquivo antigo, caso um novo tenha sido enviado no request */
        if ($request->model_image) {
            Storage::disk('public')->delete($modelId->model_image);
        }

        $imageElement = $request->model_image;
        $image_urn = $imageElement->store('images/modelCars', 'public');
        $modelId->fill($request->all());
        $modelId->model_image = $image_urn;
        $modelId->save();
        /* $modelId->update([
            'brand_id' => $request->brand_id,
            'model_name' => $request->model_name,
            'model_image' => $image_urn,
            'number_doors' => $request->number_doors,
            'places' => $request->places,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]); */
        return response()->json($modelId, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $modelId = $this->modelCarInstance->find($id);
        if (!$modelId) {
            return response()->json(['errorMessage' => 'Error On Remove, The Record Does Not Exist!'], 404);
        }

        /* remove o arquivo antigo, caso um novo tenha sido enviado no request */
        if ($modelId) {
            Storage::disk('public')->delete($modelId->model_image);
        }

        $modelId->delete($modelId);
        return response()->json(['SuccessMessage' => 'Brand removed successfully!'], 200);
    }
}
