<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index()
    {
        $data = Customer::latest()->paginate(10);
        return view('customers.index', compact('data'));
    }

    public function create()
    {
        $companies = Company::orderBy('name')->get();
        return view('customers.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $query = $request->validate([
            'customer_code' => 'nullable|max:20',
    'companies_id' => 'required|exists:companies,id',
            'name' => 'required|max:255',
            'company_name' => 'nullable|max:255',
            'tax_number' => 'nullable|max:20',
            'phone' => 'nullable|max:20',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable'
        ]);

        Customer::create($query);

        return redirect()->route('customers.index')->with('success', 'เพิ่มลูกค้าสำเร็จ');
    }

     public function edit($id)
    {
        $row = Customer::findOrFail($id);

        $companies = Company::orderBy('name')->get();
        return view('customers.edit', compact('row', 'companies'));
    }

    public function update(Request $request, $id)
    {
        $query = $request->validate([
            'customer_code' => 'nullable|max:20',
            'name' => 'required|max:255',
            'company_name' => 'nullable|max:255',
            'companies_id' => 'required|exists:companies,id',
            'tax_number' => 'nullable|max:20',
            'phone' => 'nullable|max:20',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable'
        ]);

        $row = Customer::findOrFail($id);

        $row->update($query);

        return redirect()->route('customers.index')
            ->with('success', 'แก้ไขข้อมูลสำเร็จ');
    }

    public function destroy($id)
    {
        Customer::destroy($id);


        return redirect()->route('customers.index')
            ->with('success', 'ลบข้อมูลสำเร็จ');
    }
}
