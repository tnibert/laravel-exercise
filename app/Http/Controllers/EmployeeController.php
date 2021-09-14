<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     * todo: error handling
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        error_log(implode(", ", $request->all()));
        error_log("test");
        $employeeData = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'dob' => 'required',
            'email' => 'required',
            // todo: id or name? also, validate correctly
            'company_id' => 'required'
        ]);
        //error_log(implode(", ", $employeeData));
        $employee = new Employee();
        $employee->firstname = $employeeData['firstname'];
        $employee->lastname = $employeeData['lastname'];
        $employee->dob = $employeeData['dob'];
        $employee->email = $employeeData['email'];

        $co = Company::find($employeeData['company_id']);
        $employee->company()->associate($co);
        error_log("testpresave");
        $employee->save();
        error_log("testpostsave");
        //Employee::create($employeeData);
        error_log("test3");
        return response()->json([
            'name' => 'Abigail',
            'state' => 'CA',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
