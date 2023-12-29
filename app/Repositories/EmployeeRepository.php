<?php

namespace App\Repositories;

use App\Models\Employee;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class EmployeeRepository
{
    public function allEmployees($perPage = 10)
    {
        $tasks = Employee::latest();

        $tasks = $tasks->paginate($perPage);

        if (!$tasks) {
            throw new \Exception("No Records Found!", HttpResponse::HTTP_NOT_FOUND);
        }

        return $tasks;
    }

    public function insertEmployee($task)
    {
        $isSave = Employee::create($task);

        if (!$isSave) {
            throw new \Exception("Something wrong, unable to save this records!", HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $isSave;
    }

    public function findEmployee($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            throw new \Exception("Employee {$id} is not found!", HttpResponse::HTTP_NOT_FOUND);
        }

        return $employee;
    }

    public function deleteEmployee($id)
    {
        $employee = $this->findEmployee($id);

        $isDeleted = $employee->delete();

        if (!$isDeleted) {
            throw new \Exception("Something wrong, unable to delete this record!", HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $isDeleted;
    }

    public function updateEmployee($employee, $id)
    {
        $isUpdated = Employee::where([
            'id' => $id
        ])->update($employee);

        if (!$isUpdated) {
            throw new \Exception("Something wrong, unable to update this record!", HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $isUpdated;
    }
}
