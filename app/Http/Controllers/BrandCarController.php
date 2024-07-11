<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\BrandCar;

class BrandCarController extends Controller
{

    public function __construct(protected BrandCar $brandCarInstance)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $brandsCar = array();

        if ($request->has('model_attributes')) {
            $model_attributes = $request->model_attributes;
            $brandsCar = $this->brandCarInstance->with('modelCarRelation:id,' . $model_attributes);
        } else {
            $brandsCar = $this->brandCarInstance->with('modelCarRelation');
        }

        if ($request->has('filter_attributes')) {
            /* Like Operator: model_name:like:%Ford% */
            $multipleFilters = explode(';', $request->filter_attributes);

            foreach ($multipleFilters as $key => $condition) {

                $conditionsFilter = explode(':', $condition);
                $brandsCar = $brandsCar->where($conditionsFilter[0], $conditionsFilter[1], $conditionsFilter[2]);
            }
        }

        if ($request->has('single_attributes')) {
            $single_attributes = $request->single_attributes;
            $brandsCar = $brandsCar->selectRaw($single_attributes);
        } else {
            $brandsCar = $brandsCar;
        }

        // Adicionando paginação
        $perPage = $request->input('per_page', 3);
        $brandsCar = $brandsCar->paginate($perPage);

        return response()->json($brandsCar, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate($this->brandCarInstance->rules(), $this->brandCarInstance->feedback($request));

        $imageElement = $request->brand_image;
        $image_urn = $imageElement->store('images', 'public');

        $brandedStored = $this->brandCarInstance->create([
            'brand_name' => $request->brand_name,
            'brand_image' => $image_urn
        ]);
        return response()->json($brandedStored, 201);
    }

    /**
     * Display the specified resource.
     */

    public function show(int $id)
    {
        $brand = $this->brandCarInstance->with('modelCarRelation')->find($id);

        if (!$brand) {
            return response()->json(['errorMessage' => 'Searched resource does not exist!'], 404);
        }

        return response()->json($brand, 200);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {

        $brandId = $this->brandCarInstance->find($id);
        if (!$brandId) {
            return response()->json(['errorMessage' => 'Error On Update, The Record Does Not Exist!'], 404);
        }

        if ($request->method() === 'PATCH') {

            $dinamicRules = array();

            foreach ($brandId->rules() as $input => $rule) {
                if (array_key_exists($input, $request->all())) {
                    $dinamicRules[$input] = $rule;
                }
            }

            $request->validate($dinamicRules, $brandId->feedback());
        } else {

            $request->validate($brandId->rules(), $brandId->feedback());
        }

        $brandId->fill($request->all());

        if($request->brand_image){
            //remove o arquivo antigo, caso um novo tenha sido enviado no request
            Storage::disk('public')->delete($brandId->brand_image);

            $imageElement = $request->brand_image;
            $image_urn = $imageElement->store('images', 'public');
            $brandId->brand_image = $image_urn;
            
        }
        $brandId->save();
       return response()->json($brandId, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $brandId = $this->brandCarInstance->find($id);
        if (!$brandId) {
            return response()->json(['errorMessage' => 'Error On Remove, The Record Does Not Exist!'], 404);
        }

        /* remove o arquivo antigo, caso um novo tenha sido enviado no request */
        if ($brandId) {
            Storage::disk('public')->delete($brandId->brand_image);
        }

        $brandId->delete($brandId);
        return response()->json(['SuccessMessage' => 'Brand removed successfully!'], 200);
    }
}
