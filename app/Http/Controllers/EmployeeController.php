<?php

namespace App\Http\Controllers;

use App\Models\National;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $per_page = 10;

        if ($request->has('per_page')) {
            $per_page = $request->get('per_page');
        }

        $employees = User::employee();

        // if ($request->has('name')) {
        //     $employees = $employees->where('name', 'like', '%' . $request->get('name') . '%');
        // }
        if ($request->has('search')) {
            $search = $request->get('search');
            $employees = $employees
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('furigana', 'like', '%' . $search . '%')
                        ->orWhere('phone_number', 'like', '%' . $search . '%')
                        ->orWhere('dob', 'like', '%' . $search . '%')
                        ->orWhere('address', 'like', '%' . $search . '%')
                        ->orWhere('introduce', 'like', '%' . $search . '%')
                        ->orWhere('pos_date', 'like', '%' . $search . '%')
                        ->orWhereHas('national', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->filterByWorkingPlace($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->FilterByDriverLicense($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->FilterByWorkingPlan($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->FilterByVisaType($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->FilterByAdvancement($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->FilterByJapaneseLevel($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->FilterByPos($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->FilterByGender($search);
                        });
                });
        }


        $employees = $employees->orderBy('id', 'asc')->paginate($per_page);

        $employees->getCollection()->transform(function ($employee) {
            $employee->working_place_value = $employee->working_place_value;
            $employee->working_plan_value = $employee->working_plan_value;
            $employee->driver_license_value = $employee->driver_license_value;
            $employee->visa_type_value = $employee->visa_type_value;
            $employee->advancement_value = $employee->advancement_value;
            $employee->japanese_level_value = $employee->japanese_level_value;
            $employee->pos_value = $employee->pos_value;
            return $employee;
        });
        return $employees;
    }

    public function indexWorker(Request $request)
    {
        $per_page = 10;

        if ($request->has('per_page')) {
            $per_page = $request->get('per_page');
        }

        $employees = User::worker()->with(['national']);

        // if ($request->has('name')) {
        //     $employees = $employees->where('name', 'like', '%' . $request->get('name') . '%');
        // }

        if ($request->has('search')) {
            $search = $request->get('search');
            $employees = $employees
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('furigana', 'like', '%' . $search . '%')
                        ->orWhere('phone_number', 'like', '%' . $search . '%')
                        ->orWhere('dob', 'like', '%' . $search . '%')
                        ->orWhere('address', 'like', '%' . $search . '%')
                        ->orWhere('introduce', 'like', '%' . $search . '%')
                        ->orWhere('pos_date', 'like', '%' . $search . '%')
                        ->orWhereHas('national', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->filterByWorkingPlace($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->FilterByDriverLicense($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->FilterByWorkingPlan($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->FilterByVisaType($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->FilterByAdvancement($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->FilterByJapaneseLevel($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->FilterByPos($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->FilterByGender($search);
                        });
                });
        }


        $employees = $employees->orderBy('id', 'asc')->paginate($per_page);

        $employees->getCollection()->transform(function ($employee) {
            $employee->working_place_value = $employee->working_place_value;
            $employee->working_plan_value = $employee->working_plan_value;
            $employee->driver_license_value = $employee->driver_license_value;
            $employee->visa_type_value = $employee->visa_type_value;
            $employee->advancement_value = $employee->advancement_value;
            $employee->japanese_level_value = $employee->japanese_level_value;
            $employee->pos_value = $employee->pos_value;
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
        $data = $request->all();
        $data['is_employee'] = 'employee';
        return User::create($data);
    }



    public function storeWorker(Request $request)
    {

        $rules = [
            'name' => 'required',
            'furigana' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'pos' => 'required',
            'pos_date' => 'required',
            'driver_license' => 'required'
        ];

        $this->validate($request, $rules);
        $data = $request->all();
        $data['is_employee'] = 'worker';
        return User::create($data);
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $emp = User::findOrFail($id);
        $emp->fill($request->all());
        $emp->save();
        return $emp;
    }

    public function destroy($id)
    {
        return User::destroy($id);
    }


    public function getNations()
    {
        return National::orderBy('number', 'asc')->get();
    }

    public function getStats()
    {
        $gender = [];
        $nation = [];
        $visa = [];
        $jpn = [];

        $employees = User::worker()->with(['national'])->paginate(10000000);

        $employees->getCollection()->transform(function ($employee) {
            $employee->visa_type_value = $employee->visa_type_value;
            $employee->japanese_level_value = $employee->japanese_level_value;
            return $employee;
        });

        foreach ($employees as $key => $value) {
            if ($value->gender) {
                if (!isset($gender['Male'])) {
                    $gender['Male'] = 1;
                } else {
                    $gender['Male']++;
                }
            } else {
                if (!isset($gender['Female'])) {
                    $gender['Female'] = 1;
                } else {
                    $gender['Female']++;
                }
            }

            if ($value->national) {
                if (!isset($nation[$value->national->name])) {
                    $nation[$value->national->name] = 1;
                } else {
                    $nation[$value->national->name]++;
                }
            }


            if ($value->visa_type_value) {
                if (!isset($visa[$value->visa_type_value])) {
                    $visa[$value->visa_type_value] = 1;
                } else {
                    $visa[$value->visa_type_value]++;
                }
            }

            if ($value->japanese_level_value) {
                if (!isset($jpn[$value->japanese_level_value])) {
                    $jpn[$value->japanese_level_value] = 1;
                } else {
                    $jpn[$value->japanese_level_value]++;
                }
            }

        }

        return response()->json([
            "gender" => $gender,
            "nation" => $nation,
            "visa" => $visa,
            "jpn" => $jpn,
        ]);
    }
}
