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
            'name' => 'required|max:255',
            'company_name' => 'nullable|max:255',
            'companies_id' => 'required|exists:companies,id',
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
    $customer = Customer::findOrFail($id);
    $companies = Company::orderBy('name')->get();

    return view('customers.edit', compact(
        'customer',
        'companies'
    ));
}

public function update(Request $request,$id)
{
    $customer = Customer::findOrFail($id);

    $request->validate([
        'companies_id' => 'required|exists:companies,id',
        'customer_code' => 'required|digits:13|unique:customers,customer_code,'.$id,
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email',
        'address' => 'nullable|string',
    ]);

    $customer->update([
        'companies_id' => $request->companies_id,
        'customer_code' => $request->customer_code,
        'name' => $request->name,
        'phone' => $request->phone,
        'email' => $request->email,
        'address' => $request->address,
    ]);

    return redirect()
        ->route('customers.index')
        ->with('success','แก้ไขลูกค้าเรียบร้อย');
}
    public function destroy($id)
    {
        Customer::destroy($id);

        return redirect()->route('customers.index')
            ->with('success', 'ลบข้อมูลสำเร็จ');
    }
}
