<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = User::where(function ($query) use ($request) {
            if ($request->has('search') && !empty($request->search)) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            }

            if ($request->has('role') && !empty($request->role)) {
                $query->where('role', $request->role);
            }

            if ($request->has('company_id') && !empty($request->company_id)) {
                $query->where('companies_id', $request->company_id);
            }
        })->latest()->paginate(10)->withQueryString();

        $companies = Company::orderBy('name')->get();
        return view('user.index', compact('users', 'companies'));
    }

    public function create()
    {
        $companies = Company::orderBy('name')->get();
        return view('user.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'companies_id' => 'required|exists:companies,id',
            'role' => 'required|in:admin,user,manager',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // =========================
        // PASSWORD HASH
        // =========================
        $data['password'] = Hash::make($data['password']);

        // =========================
        // UPLOAD AVATAR (NO STORAGE)
        // =========================
        if ($request->hasFile('avatar')) {

            $destinationPath = public_path('avatars');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();

            $request->file('avatar')->move($destinationPath, $filename);

            $data['avatar'] = 'avatars/' . $filename;
        }

        // =========================
        // CREATE USER
        // =========================
        User::create($data);

        return redirect()->route('users.index')->with('success', 'เพิ่มผู้ใช้งานสำเร็จ');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $companies = Company::orderBy('name')->get();
        return view('user.edit', compact('user', 'companies'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => [
                'nullable',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|min:8|confirmed',
            'companies_id' => 'required|exists:companies,id',
            'role' => 'required|in:admin,user,manager',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // =========================
        // UPLOAD WITHOUT STORAGE
        // =========================
        if ($request->hasFile('avatar')) {

            // โฟลเดอร์จริง: public/avatars
            $destinationPath = public_path('avatars');

            // สร้างโฟลเดอร์ถ้ายังไม่มี
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // ลบรูปเก่า
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }

            // ตั้งชื่อไฟล์
            $filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();

            // ย้ายไฟล์
            $request->file('avatar')->move($destinationPath, $filename);

            // เก็บ path ใน DB
            $data['avatar'] = 'avatars/' . $filename;
        }

        // password
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'แก้ไขสำเร็จ');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'ลบผู้ใช้งานสำเร็จ');
    }
}
