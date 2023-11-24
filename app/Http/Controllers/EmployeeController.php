<?php

namespace App\Http\Controllers;

use App\Models\National;
use App\Models\Prefecture;
use App\Models\Relation;
use App\Models\User;
use App\Models\Work_place;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $per_page = 10;

        if ($request->has('per_page')) {
            $per_page = $request->get('per_page');
        }

        $employees = User::employee()->with(['relation']);

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
                            $query->filterByDriverLicense($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->filterByWorkingPlan($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->filterByVisaType($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->filterByAdvancement($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->filterByJapaneseLevel($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->filterByPos($search);
                        });
                    // ->orWhere(function ($query) use ($search) {
                    //     $query->filterByGender($search);
                    // });
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
            $employee->manager_value = $employee->manager_value;
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
                            $query->filterByDriverLicense($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->filterByWorkingPlan($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->filterByVisaType($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->filterByAdvancement($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->filterByJapaneseLevel($search);
                        })
                        ->orWhere(function ($query) use ($search) {
                            $query->filterByPos($search);
                        });
                    // ->orWhere(function ($query) use ($search) {
                    //     $query->filterByGender($search);
                    // });
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

        $newuser = User::create($data);

        if (isset($data['relation'])) {
            foreach ($data['relation'] as $key => $value) {
                Relation::create([
                    'name' => $value['name'],
                    'furigana' => $value['furigana'],
                    'gender' => $value['gender'],
                    'resisdence_card_number' => $value['resisdence_card_number'],
                    'my_number' => $value['my_number'],
                    'dependent' => $value['dependent'],
                    'user_id' => $newuser->id,
                ]);
            }
        }

        return $newuser;
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
        return User::with(['relation'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $emp = User::findOrFail($id);
        $emp->fill($request->all());
        $emp->save();


        if (isset($request->all()['relation'])) {
            Relation::where('user_id', $id)->delete();
            foreach ($request->all()['relation'] as $key => $value) {
                Relation::create([
                    'name' => $value['name'],
                    'furigana' => $value['furigana'],
                    'gender' => $value['gender'],
                    'resisdence_card_number' => $value['resisdence_card_number'],
                    'my_number' => $value['my_number'],
                    'dependent' => $value['dependent'],
                    'user_id' => $id,
                ]);
            }
        }

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
        $prefecture = [];

        $workers = User::worker()->with(['national', 'prefecture'])->paginate(10000000);
        $employee = User::employee()->paginate(10000000);

        $workers->getCollection()->transform(function ($worker) {
            $worker->visa_type_value = $worker->visa_type_value;
            $worker->japanese_level_value = $worker->japanese_level_value;
            return $worker;
        });

        foreach ($workers as $key => $value) {
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

            if ($value->prefecture_id) {
                if (!isset($prefecture[$value->prefecture->name])) {
                    $prefecture[$value->prefecture->name] = 1;
                } else {
                    $prefecture[$value->prefecture->name]++;
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
            "prefecture" => $prefecture,
            "workers" => sizeof($workers),
            "employee" => sizeof($employee)
        ]);
    }

    public function getPrefecture()
    {
        return Prefecture::all();
    }
    public function getWorkPlace()
    {
        return Work_place::all();
    }
}
