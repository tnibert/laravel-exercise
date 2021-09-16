<?php

namespace App\Http\Controllers;

/**
 * No generic models from what I can see, so let's compose in the common operations.
 * This class abstracts the common CRUD logic between the Employee and Company controllers.
 */
class Binding
{
    private $model;

    function __construct($m) {
        $this->model = $m;
    }

    public function index()
    {
        return $this->model::all()->toJson();
    }

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resource = $this->model::findOrFail($id);
        return $resource->toJson();
    }

    public function destroy($id)
    {
        $resource = $this->model::findOrFail($id);
        $resource->delete();
        return response()->json(['id' => $id, 'deleted' => True,]);
    }
}
