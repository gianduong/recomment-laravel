<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rules = \DB::table('tapLuat')->get();
        return successResponse($rules);
    }

    public function distinctType()
    {
        $rules = \DB::table('tapLuat')->distinct()->get(['loaiSuKien'])->toArray();
        $list = [];
        foreach ($rules as $key => $value) {
            array_push($list, $value->loaiSuKien);
        }
        return successResponse($list);
    }

    public function getById($id)
    {
        $rules = \DB::table('tapLuat')->where('ID_luat', $id)->first();
        return successResponse($rules);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->all();
        return DB::table('tapLuat')->insert($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $record = DB::table('tapLuat')->upsert($data, ['id']);
        if ($record) return successResponse([]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        $record = \DB::table('tapLuat')->where('id', $id)->update($request->all());
        if ($record) return successResponse($request->all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        \DB::table('tapLuat')->delete($id);
        return successResponse([]);
    }
}
