<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

  public function store(Request $request)
{
    $request->validate([
        'business_name' => 'required',
        'fullname' => 'required',
        'commercial_registration_no' => 'required|string|max:50',
    'commercial_registration_date' => 'required|date',
        'tax_id' => 'required'
    ],[
        'business_name.required' => 'กรุณากรอกชื่อผู้ประกอบการ',
          'commercial_registration_no.required' => 'กรุณากรอกเลขทะเบียนพาณิชย์',
    'commercial_registration_date.required' => 'กรุณาเลือกวันที่จดทะเบียน',
        'fullname.required' => 'กรุณากรอกชื่อ-นามสกุล',
        'tax_id.required' => 'กรุณากรอกเลขผู้เสียภาษี'
    ]);


    Customer::create($request->all());

    return redirect()->route('customers.index')
        ->with('success','เพิ่มลูกค้าเรียบร้อย');
}

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);

        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $customer->update($request->all());

        return redirect()->route('customers.index')
        ->with('success','แก้ไขข้อมูลสำเร็จ');
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();

        return back()->with('success','ลบข้อมูลแล้ว');
    }

}
