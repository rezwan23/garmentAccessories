<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\PrepareSalary;
use App\Models\SalaryAllowance;
use App\Models\SalarySheet;
use App\Models\SalarySheetDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PrepareSalaryController extends Controller
{
    public function prepare(Request $request)
    {
        $employeeDetails = new Collection();
        if ($request->filled('employee_id') && $request->get('employee_id') != '*') {
            $prepareSalary = PrepareSalary::where('employee_id', $request->get('employee_id'))
                ->where('month', $request->get('month'))
                ->where('year', $request->get('year'))
                ->get();
            if ($prepareSalary->count() > 0) {
                return back()->withErrors(['error-message' => 'Salary already Prepared for this employee']);
            }
            $employeeDetails = Employee::where('id', $request->get('employee_id'))->get();
        }
        if ($request->filled('employee_id') && $request->filled('department_id') && $request->get('employee_id') == '*') {
            $employees = Employee::whereHas('department', function ($query) use ($request) {
                $query->where('depart_id', $request->get('department_id'));
            })->get();
            foreach ($employees as $emp) {
                $prepareSalary = PrepareSalary::where('employee_id', $emp->id)
                    ->where('month', $request->get('month'))
                    ->where('year', $request->get('year'))
                    ->get();
                if ($prepareSalary->count() > 0) {
                    return back()->withErrors(['error-message' => 'Salary already Prepared for some employees']);
                }
            }
            $employeeDetails = Employee::where('depart_id', $request->get('department_id'))
                ->get();
        }
        return view('prepare-salary.create', [
            'departments'=>Department::all(),
            'employeeDetails'   =>  $employeeDetails,
            'allowances'    =>  Allowance::where('status', 1)->get(),
        ]);
    }
    public function getEmployee(Request $request)
    {
        return Department::find($request->department_id)->employees;
    }

    public function store(Request $request)
    {
        foreach($request->employee_id as $key=>$value){
            $employee = Employee::find($value);
            $totalAllowance = $request->single_allowance;
            $totalDeduction = $request->single_deduction;
            $totalPayable = $employee->salary+$totalAllowance-$totalDeduction;
            $prepareSalary = PrepareSalary::create([
                'employee_id'   =>  $value,
                'designation_id'    =>  $request->designation_id[$key],
                'department_id' =>  $request->department_id[$key],
                'month' =>  $request->month,
                'year'  =>  $request->year,
                'total_payable' =>  $totalPayable,
                'total_allowance'   =>  $totalAllowance,
                'total_deduction'   =>  $totalDeduction,
            ]);
            foreach($request->allowance_id as $key=>$value){
                SalaryAllowance::create([
                    'prepare_salary_id' =>  $prepareSalary->id,
                    'allowance_id'  =>  $value,
                    'allowance' =>  $request->allowance_value[$key],
                    'type'  =>  1,
                ]);
            }
            foreach($request->deduction_id as $key=>$value){
                SalaryAllowance::create([
                    'prepare_salary_id' =>  $prepareSalary->id,
                    'allowance_id'  =>  $value,
                    'allowance' =>  $request->deduction_value[$key],
                    'type'  =>  0,
                ]);
            }
        }
        return redirect()->route('salary.sheet')->with('success-message', 'Salary Prepared');
    }

    public function getAll()
    {
        $salaries = PrepareSalary::where('is_paid', 0)->get();
        return view('prepare-salary.all-prepared', ['salaries'  =>  $salaries]);
    }

    public function destroy(PrepareSalary $salary)
    {
        $salary->prepareSalaryAllowances->each->delete();
        $salary->delete();
        return back()->with('success-message', 'Salary deleted successfully!');
    }

    public function salaryPayment(Request $request)
    {
        $salarySheet = SalarySheet::create([
            'total_payable' => $request->total_payable,
            'month' =>  date('F'),
            'year'  =>  date('Y'),
        ]);
        foreach($request->prepare_salary_id as $salary){
            $prepare = PrepareSalary::find($salary);
            SalarySheetDetail::create([
                'salary_sheet_id'   =>  $salarySheet->id,
                'prepare_salary_id' =>  $prepare->id,
                'employee_id'   =>  $prepare->employee_id,
                'total_allowance'   =>  $prepare->total_allowance,
                'total_deduction'   =>  $prepare->total_deduction,
                'payable'   =>  $prepare->total_payable-$prepare->paid,
                'month' =>  $prepare->month,
                'year'  =>  $prepare->year,
            ]);
            $prepare->markAsPaid();
        }
        return back()->with('success-message', 'Salary Paid');
    }

    public function getAllSalaryRecord()
    {
        return view('salary-sheet.index', ['salaries'=>SalarySheet::all()]);
    }

    public function viewSalaryRecord(SalarySheet $salary)
    {
        return view('salary-sheet.show', ['salary'=>$salary]);
    }

    public function payslip(SalarySheetDetail $detail)
    {
        return view('salary-sheet.payslip', ['detail'=>$detail]);
    }

    public function destroySalarySheet(SalarySheet $salary)
    {
        $salary->details()->delete();
        $salary->delete();
        return back()->with('success-message', 'Deleted Successfully!');
    }
}