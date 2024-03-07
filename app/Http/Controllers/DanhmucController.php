<?php

namespace App\Http\Controllers;

use App\Models\Danhmuc;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateDanhmucRequest;
use Illuminate\Support\Facades\DB;

class DanhmucController extends Controller
{
    
    public function index()
    {
        $danhmucs = DB::select("SELECT * FROM danhmucs");
        return view('admin.danhmucs.index',[
            'danhmucs'=> $danhmucs
        ]);  
    }

    public function create()
    {
        return view('admin.danhmucs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'tendanhmuc'=>'required'
        ]);

        $danhmuc = new Danhmuc();
        $danhmuc->tendanhmuc = $request->tendanhmuc;
        $danhmuc->save();
        return redirect('/admin/danhmuc');
    }

    /**
     * Display the specified resource.
     */
    public function show(Danhmuc $danhmuc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Danhmuc $danhmuc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDanhmucRequest $request, Danhmuc $danhmuc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Danhmuc $danhmuc)
    {
        //
    }
}
