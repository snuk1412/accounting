<?php
namespace App\Http\Controllers; // 👈 ต้องมีอันนี้
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->get();
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required',
        'tax_id' => 'required|size:13',
        'business_type' => 'required',
        'industry_type' => 'required',
        'product_type' => 'nullable',
        'employee_count' => 'required|integer|min:0',
        'address' => 'nullable',
        'phone' => 'nullable',
        'email' => 'nullable|email',
        'is_default' => 'nullable'
    ]);

    // upload logo ไป public/images
    if ($request->hasFile('logo')) {

        $file = $request->file('logo');
        $filename = time().'_'.$file->getClientOriginalName();

        $file->move(public_path('images'), $filename);

        $data['logo'] = 'images/'.$filename;
    }

    // set default company (ให้มีได้แค่ 1)
    if ($request->is_default) {
        Company::where('is_default', true)->update(['is_default' => false]);
        $data['is_default'] = true;
    }

    Company::create($data);

    return redirect()->route('companies.index')
        ->with('success','เพิ่มบริษัทสำเร็จ');
}

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $data = $request->validate([
            'name' => 'required',
            'tax_id' => 'required|max:13',
            'business_type' => 'required',
            'industry_type' => 'required',
            'product_type' => 'nullable',
            'employee_count' => 'required|integer',
            'address' => 'nullable',
            'phone' => 'nullable',
            'email' => 'nullable|email',
            'logo' => 'nullable|image',
            'is_default' => 'nullable'
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $data['logo'] = $request->file('logo')->store('companies', 'public');
        }

        if ($request->is_default) {
            Company::where('is_default', true)->update(['is_default' => false]);
            $data['is_default'] = true;
        }

        $company->update($data);

        return redirect()->route('companies.index')->with('success', 'อัปเดตสำเร็จ');
    }

    public function destroy(Company $company)
    {
        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }

        $company->delete();

        return back()->with('success', 'ลบสำเร็จ');
    }
}
