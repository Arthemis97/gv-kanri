<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $per_page = 10;

        if ($request->has('per_page')) {
            $per_page = $request->get('per_page');
        }

        $employees = Employee::paginate($per_page);

        $employees->getCollection()->transform(function ($employee) {
            $employee->working_place_value = $employee->working_place_value;
            $employee->working_plan_value = $employee->working_plan_value;
            $employee->driver_license_value = $employee->driver_license;
            $employee->visa_type_value = $employee->visa_type;
            $employee->advancement_value = $employee->advancement;
            $employee->japanese_level_value = $employee->japanese_level;
            return $employee;
        });
        return $employees;
    }

    public function store(Request $request)
    {

        $rules = [
            'name' => 'required',
            'furigana' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'pos' => 'required',
            'pos_date' => 'required',
            'driver_license' => 'required',
            'working_place' => 'required',
            'working_plan' => 'required',
            'introduce' => 'required'
        ];

        $this->validate($request, $rules);

        return Employee::create($request->all());
    }

    public function update(Request $request)
    {

    }

    public function destroy()
    {

    }
}
