<?php

namespace App\Http\Controllers;

use App\Models\TestCrud;
use Illuminate\Http\Request;

class TestController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:test-list|test-create|test-edit|test-delete', ['only' => ['index','show']]);
        $this->middleware('permission:test-create', ['only' => ['create','store']]);
        $this->middleware('permission:test-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:test-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $tests = TestCrud::all();
        return view('test.test',compact('tests'));
    }

    public function create()
    {
        return view('test.test-create');
    }

    public function store(Request $request)
    {
        request()->validate([
            'test_name' => 'required',
            'test_desc' => 'required',
        ]);

        TestCrud::create($request->all());

        return redirect()->route('test.index')
            ->with('success','TestCrud created successfully.');
    }

    public function show(TestCrud $testCrud)
    {
        return view('test.test-show',compact('testCrud'));
    }

    public function edit(TestCrud $testCrud)
    {
        return view('test.test-edit',compact('testCrud'));
    }

    public function update(Request $request, TestCrud $testCrud)
    {
        request()->validate([
            'test_name' => 'required',
            'test_desc' => 'required',
        ]);

        $testCrud->update($request->all());

        return redirect()->route('test.index')
            ->with('success','TestCrud updated successfully');
    }

    public function destroy(TestCrud $testCrud)
    {
        $testCrud->delete();

        return redirect()->route('test.index')
            ->with('success','TestCrud deleted successfully');
    }
}
