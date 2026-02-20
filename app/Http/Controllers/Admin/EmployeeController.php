<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index(Request $request)
    {
        $query = User::where('role', User::ROLE_EMPLOYEE);

    // Apply search if provided
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%")
              ->orWhere('phone', 'like', "%$search%")
              ->orWhere('emp_id', 'like', "%$search%")
              ->orWhere('department', 'like', "%$search%")
              ->orWhere('company_title', 'like', "%$search%");
        });
    }

    $employees = $query->latest()
        ->paginate(10)
        ->withQueryString(); // keeps search during pagination

    return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone'    => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6'],
            'status'   => ['required', 'boolean'],
             'department'    => ['nullable','string','max:255'],
             'company_title' => ['nullable','string','max:255'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role']     = User::ROLE_EMPLOYEE;

        User::create($data);

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit($id)
    {
        $employee = User::where('role', User::ROLE_EMPLOYEE)
            ->findOrFail($id);

        return view('admin.employees.edit', compact('employee'));
    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request, $id)
    {
        $employee = User::where('role', User::ROLE_EMPLOYEE)
            ->findOrFail($id);

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email,' . $employee->id],
            'phone'    => ['required', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:6'],
            'status'   => ['required', 'boolean'],
              'department'    => ['nullable','string','max:255'],
            'company_title' => ['nullable','string','max:255'],
        ]);

        // Update password only if provided
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $employee->update($data);

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified employee.
     */
    public function destroy($id)
    {
        $employee = User::where('role', User::ROLE_EMPLOYEE)
            ->findOrFail($id);

        $employee->delete();

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
