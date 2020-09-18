<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class EmployeeController extends Controller
{
    //
    public function __construct()
    {
        
    }

    /**
     * show all employees
     * 
     * @param none
     * 
     * @return emplyees
     */
    public function showAllEmployee()
    {
        return view('employee', ['employees'=> User::all()->except([1])->sortBy('role')]);
    }

    /**
     * add new employee by administrator
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return response with success message
     * 
     */
    public function addEmployee(Request $request){
        $employee  = new User;
        $employee->fullname = $request->fullname;
        $employee->username = $request->username;
        $employee->password = Hash::make($request->password);
        if($request->role == 1){
            $employee->title = "Admin";
            $employee->role = "Admin";
        }else{
            $employee->role = "Employee";
            if($request->title == 1){
                $employee->title = "Mechanic";
            }else if($request->title == 2){
                $employee->title = "Finisher";
            }
            if($request->level == 1){
                $employee->level = "Apprentice";
            }else if($request->level == 2){
                $employee->level = "Journeyman";
            }
        }
        $employee->save();
        $request->session()->flash('added', true);
        return redirect()->back();
    }

    /**
     * update the employee information
     * 
     * @param employeeID && \Illuminate\Http\Requst $request
     * 
     * @return response with success message
     * 
     */
    public function updateEmployee(Request $request, $employeeID){
        $employee = User::find($employeeID);
        
        $employee->fullname = $request->fullname;
        $employee->username = $request->username;
        $employee->password = Hash::make($request->password);
        if($request->title == 1){
            $employee->title = "Merchanic";
        }else if($request->title == 2){
            $employee->title = "Finisher";
        }
        if($request->level == 1){
            $employee->level = "Apprentice";
        }else if($request->level == 2){
            $employee->level = "Journeyman";
        }
        $employee->save();
        
        $request->session()->flash('updated', true);
        return redirect()->back();
    }
}
