<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    private $binding;

    function __construct() {
        $this->binding = new Binding(Company::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->binding->index();
    }

    /**
     * Create operation
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = $this->binding->store($request, ['name' => 'required']);
        $company->save();
        return $company->toJson();
    }

    /**
     * Read operation
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->binding->show($id);
    }

    /**
     * Update operation
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company = $this->binding->update($request, ['name' => 'string'], $id);
        $company->save();
        return $company->toJson();
    }

    /**
     * Delete operation
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->binding->destroy($id);
    }
}
