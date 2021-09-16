<?php

namespace App\Http\Controllers;

/**
 * No generic models from what I can see, so let's compose in the common operations.
 * This class abstracts the common CRUD logic between the Employee and Company controllers.
 */
class Binding
{
    private $model;

    /**
     * Store the model class to work against
     */
    function __construct($m) {
        $this->model = $m;
    }

    /**
     * Display all records for the given model
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->model::all()->toJson();
    }

    /**
     * Create a new model
     * @return Illuminate\Database\Eloquent\Model
     */
    public function store($request, $validate_rules)
    {
        $resourceData = $request->validate($validate_rules);
        $resource = new $this->model();

        # this is the problem, it cannot handle the foreign key being passed in as integer
        $resource->fill($resourceData);

        // mass assignment
        //Company::create($resourceData);

        return $resource;
    }

    /**
     * Update a model
     * @return Illuminate\Database\Eloquent\Model
     */
    public function update($request, $validate_rules, $id)
    {
        $resourceData = $request->validate($validate_rules);
        $resource = $this->model::findOrFail($id);
        $resource->fill($resourceData);
        return $resource;
    }

    /**
     * Read a model
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resource = $this->model::findOrFail($id);
        return $resource->toJson();
    }

    /**
     * Delete a model
     * @param  int  $id
     */
    public function destroy($id)
    {
        $resource = $this->model::findOrFail($id);
        $resource->delete();
        return response()->json(['id' => $id, 'deleted' => True,]);
    }
}
