<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\EmployeeRepository;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class EmployeeController extends Controller
{
    private $employeeRepo;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepo = $employeeRepository;
    }

    public function getAllEmployees(Request $request)
    {
        try {
            $employees = $this->employeeRepo->allEmployees();
            return $this->successResponse($employees, 'Employees Retrieved Successfully!', HttpResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getCode(), $ex->getMessage());
        }
    }

    public function storeEmployee(Request $request)
    {
        try {
            $employeeData = $request->all();
            $employee = $this->employeeRepo->insertEmployee($employeeData);
            return $this->successResponse($employee, 'Employee Data Inserted!', HttpResponse::HTTP_CREATED);
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getCode(), $ex->getMessage());
        }
    }

    public function show(int $id)
    {
        try {
            $employee = $this->employeeRepo->findEmployee($id);
            return $this->successResponse($employee, "Employee Data Retrieved!", HttpResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getCode(), $ex->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $isDestroy = $this->employeeRepo->deleteEmployee($id);
            return $this->successResponse($isDestroy, "Employee Deleted!", HttpResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $employeeData = $request->except(['_method']);
            $employee = $this->employeeRepo->updateEmployee($employeeData, $id);
            return $this->successResponse($employee, 'Employee Updated!', HttpResponse::HTTP_OK);
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getCode(), $ex->getMessage());
        }
    }
}
