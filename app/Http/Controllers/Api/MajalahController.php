<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Majalah;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class MajalahController extends Controller
{
        /**
    * index
    *
    * @return void
    */
    public function index()
    {
        $majalahs = Majalah::all();

        if(count($majalahs) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $majalahs 
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_majalah' => 'required',
            'jenis_majalah' => 'required',
            'penerbit' => 'required',
            'harga_majalah' => 'required|numeric',
            'jumlah_majalah' => 'required|numeric'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        
        $majalah = Majalah::create($storeData);
        return response([
            'message' => 'Add Majalah Success',
            'data' => $majalah
        ], 200);

    }

    public function show($id)
    {
        $majalah = Majalah::find($id);

        if(!is_null($majalah)){
            return response([
                'message' => 'Retrieve Majalah Success',
                'data' => $majalah
            ], 200);
        }

        return response([
            'message' => 'Majalah Not Found',
            'data' => null
        ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $majalah = Majalah::find($id);
        if(is_null($majalah)){
            return response([
                'message' => 'Majalah Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_majalah' => ['required', Rule::unique('majalahs')->ignore($majalah)],
            'jenis_majalah' => 'required',
            'penerbit' => 'required',
            'harga_majalah' => 'required|numeric',
            'jumlah_majalah' => 'required|numeric'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $majalah->nama_majalah = $updateData['nama_majalah'];
        $majalah->jenis_majalah = $updateData['jenis_majalah'];
        $majalah->penerbit = $updateData['penerbit'];
        $majalah->harga_majalah = $updateData['harga_majalah'];
        $majalah->jumlah_majalah = $updateData['jumlah_majalah'];

        if($majalah->save()) {
            return response([
                'message' => 'Update Majalah Success',
                'data' => $majalah
            ], 200);
        }

        return response([
            'message' => 'Update Majalah Failed',
            'data' => null
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $majalah = Majalah::find($id);

        if(is_null($majalah)){
            return response([
                'message' => 'Majalah Not Found',
                'data' => null
            ], 404);
        }

        if($majalah->delete()){
            return response([
                'message' => 'Delete Majalah Success',
                'data' => $majalah
            ], 200);
        }

        return response([
            'message' => 'Delete Majalah Failed',
            'data' => null
        ], 400);
    }
}
