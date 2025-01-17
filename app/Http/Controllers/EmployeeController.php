<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $employees = Employee::with('position')->get();
            return response()->json(['employees' => $employees]);
        }
        return view('employees.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'salary' => 'required|numeric',
            'position_id' => 'required|exists:positions,id',
        ]);

        $employee = Employee::create($request->all());
        return response()->json(['message' => 'Employee created successfully!', 'employee' => $employee]);
    }

    public function show($id)
    {
        $employee = Employee::with('position')->find($id);
        $positions = Position::all();  // Mengambil semua posisi untuk dropdown
        return response()->json(['employee' => $employee, 'positions' => $positions]);
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'salary' => 'required|numeric',
            'position_id' => 'required|exists:positions,id',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        return response()->json(['message' => 'Employee updated successfully!', 'employee' => $employee]);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully!']);
    }

    public function positions()
    {
        return response()->json(['positions' => Position::all()]);
    }
}
