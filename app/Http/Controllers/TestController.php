<?php

namespace App\Http\Controllers;

use App\Models\TestCrud;
use Illuminate\Http\Request;
use DataTables;

class TestController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:test-list|test-create|test-edit|test-delete', ['only' => ['index','show']]);
        $this->middleware('permission:test-create', ['only' => ['create','store']]);
        $this->middleware('permission:test-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:test-delete', ['only' => ['destroy']]);
    }

    public function getList(Request $request)
    {
        if ($request->ajax()) {
            $data = TestCrud::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
//                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a><a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    $actionBtn = $row->id;
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function index(Request $request)
    {
        return view('test.test');
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
