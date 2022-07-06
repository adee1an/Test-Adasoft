<?php

namespace App\Http\Controllers;

use App\Http\Resources\TestResource;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $test = Test::query()->where('active', 1)->latest()->get();
        return response()->json(['fetch succssfully',TestResource::collection($test)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'dsec' =>  'string|nullable|max:999',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        // $test = Test::create([
        //     'title' => $request->title,
        //     'desc' => $request->desc

        // ]);
        $test = new Test; 
        $test->title = $request->post('title'); 
        $test->desc = $request->post('desc'); 
        $test->save();


        return response()->json(['insert successfully', new TestResource($test)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        return response()->json($test);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'dsec' =>  'string|nullable|max:999',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
    
        $test->title = $request->post('title'); 
        $test->desc = $request->post('desc'); 
        $test->save();


        return response()->json(['update successfully', new TestResource($test)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,Test $test)
    {
        //ลบจริง        
        $test->delete();
        return response()->json('delete successfully');
        
        //เปลี่ยนสถานะการแสดง
        // $test->active = 0; 
        // $test->save();


        // return response()->json(['delete successfully', new TestResource($test)]);
    }
}
