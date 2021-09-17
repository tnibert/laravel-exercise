<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;

class EmployeeController extends Controller
{

    function __construct() {
        $this->binding = new Binding(Employee::class);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation_rules = [
            'firstname' => 'required | string',
            'lastname' => 'required | string',
            'dob' => 'required | string',
            'email' => 'required | email',
            'company_id' => 'required | exists:companies,id'
        ];

        //$employee = $this->binding->store($request, $validation_rules);

        $resourceData = $request->validate($validation_rules);
        $employee = new Employee();
        $employee->firstname = $resourceData['firstname'];
        $employee->lastname = $resourceData['lastname'];
        $employee->dob = $resourceData['dob'];
        $employee->email = $resourceData['email'];

        // establish foreign key relationship with company
        $co = Company::findOrFail($resourceData['company_id']);
        //$co = Company::findOrFail($employee->company());
        $employee->company()->associate($co);
        $employee->save();

        return $employee->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->binding->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation_rules = [
            'firstname' => 'string',
            'lastname' => 'string',
            'dob' => 'string',
            'email' => 'email',
            'company_id' => 'integer | exists:companies,id'
        ];

        $employee = $this->binding->update($request, $validation_rules, $id);

        // establish foreign key relationship with company
        $co = Company::findOrFail($employee->company_id);
        $employee->company()->associate($co);

        $employee->save();
        return $employee->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->binding->destroy($id);
    }
}
