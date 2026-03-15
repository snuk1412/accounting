<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Account;

class ExpenseController extends Controller
{
    public function index()
    {
        $data = Expense::with('category')->latest()->get();
        return view('expense.index', compact('data'));
    }

    public function create()
    {
            $accounts = Account::all();

        $categories = Category::where('type', 'expense')->get();
        return view('expense.create', compact('categories','accounts'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'date' => 'required',
            'amount' => 'required|numeric',
            'category_id' => 'required',
            'description' => 'nullable|max:255'
        ]);

        $data['date'] = Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');

        Expense::create($data);

        return redirect()->route('expense.index')
            ->with('success', 'เพิ่มรายจ่ายสำเร็จ');
    }

 public function edit($id)
{
        $accounts = Account::all();
    $expense = Expense::findOrFail($id);
    return view('expense.edit', compact('expense','accounts'));
}

public function update(Request $request, $id)
{
    $expense = Expense::findOrFail($id);

    $date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');

    $expense->update([
        'date' => $date,
        'amount' => $request->amount,
        'description' => $request->description,
        'category_id' => $request->category_id

    ]);

    return redirect()->route('expense.index')
        ->with('success','แก้ไขข้อมูลเรียบร้อย');
}


    public function destroy($id)
    {
        Expense::findOrFail($id)->delete();
        return back();
    }
}
