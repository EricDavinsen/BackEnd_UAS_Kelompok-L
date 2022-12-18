<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Buku;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class BukuController extends Controller
{
        /**
    * index
    *
    * @return void
    */
    public function index()
    {
        $bukus = Buku::all();

        if(count($bukus) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $bukus 
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
            'judul_buku' => 'required',
            'penerbit' => 'required',
            'harga_buku' => 'required|numeric',
            'jumlah_buku' => 'required|numeric'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        
        $buku = Buku::create($storeData);
        return response([
            'message' => 'Add Buku Success',
            'data' => $buku
        ], 200);

    }

    public function show($id)
    {
        $buku = Buku::find($id);

        if(!is_null($buku)){
            return response([
                'message' => 'Retrieve Buku Success',
                'data' => $buku
            ], 200);
        }

        return response([
            'message' => 'Buku Not Found',
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
        $buku = Buku::find($id);
        if(is_null($buku)){
            return response([
                'message' => 'Buku Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'judul_buku' => ['required', Rule::unique('bukus')->ignore($buku)],
            'penerbit' => 'required',
            'harga_buku' => 'required|numeric',
            'jumlah_buku' => 'required|numeric'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $buku->judul_buku = $updateData['judul_buku'];
        $buku->penerbit = $updateData['penerbit'];
        $buku->harga_buku = $updateData['harga_buku'];
        $buku->jumlah_buku = $updateData['jumlah_buku'];

        if($buku->save()) {
            return response([
                'message' => 'Update Buku Success',
                'data' => $buku
            ], 200);
        }

        return response([
            'message' => 'Update Buku Failed',
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
        $buku = Buku::find($id);

        if(is_null($buku)){
            return response([
                'message' => 'Buku Not Found',
                'data' => null
            ], 404);
        }

        if($buku->delete()){
            return response([
                'message' => 'Delete Buku Success',
                'data' => $buku
            ], 200);
        }

        return response([
            'message' => 'Delete Buku Failed',
            'data' => null
        ], 400);
    }
}
