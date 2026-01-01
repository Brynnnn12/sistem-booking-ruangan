<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\User;
use App\Services\EmployeeService;
use Illuminate\Http\Request;


class EmployeeController extends Controller
{

    public function __construct(protected EmployeeService $employeeService)
    {
        $this->authorizeResource(User::class, 'employee');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employees = $this->employeeService->getAllPaginated(
            10,
            $request->only(['search'])
        );

        return view('dashboard.employee.index', compact('employees'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        // dd($request->validated());
        $this->employeeService->create($request->validated());

        return redirect()->route('dashboard.employees.index')
            ->with('success', 'Pegawai berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $employee)
    {
        return view('dashboard.employee.show', compact('employee'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $employee)
    {
        return view('dashboard.employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, User $employee)
    {
        $this->employeeService->update($employee, $request->validated());

        return redirect()->route('dashboard.employees.index')
            ->with('success', 'Pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $employee)
    {
        $this->employeeService->delete($employee);

        return redirect()->route('dashboard.employees.index')
            ->with('success', 'Pegawai berhasil dihapus.');
    }
}
