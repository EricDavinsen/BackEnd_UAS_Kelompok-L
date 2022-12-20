<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Pegawai;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PegawaiController extends Controller
{
        /**
    * index
    *
    * @return void
    */
    public function index()
    {
        $pegawais = Pegawai::all();

        if(count($pegawais) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $pegawais 
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
            'nama_pegawai' => 'required',
            'alamat' => 'required',
            'umur' => 'required',
            'jenis_kelamin' => 'required',
            'tugas' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        
        $pegawai = Pegawai::create($storeData);
        return response([
            'message' => 'Add Employee Success',
            'data' => $pegawai
        ], 200);

    }

    public function show($id)
    {
        $pegawai = Pegawai::find($id);

        if(!is_null($pegawai)){
            return response([
                'message' => 'Retrieve Employee Success',
                'data' => $pegawai
            ], 200);
        }

        return response([
            'message' => 'Employee Not Found',
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
        $pegawai = Pegawai::find($id);
        if(is_null($pegawai)){
            return response([
                'message' => 'Employee Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_pegawai' => ['required', Rule::unique('pegawais')->ignore($pegawai)],
            'alamat' => 'required',
            'umur' => 'required',
            'jenis_kelamin' => 'required',
            'tugas' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $pegawai->nama_pegawai = $updateData['nama_pegawai'];
        $pegawai->alamat = $updateData['alamat'];
        $pegawai->umur = $updateData['umur'];
        $pegawai->jenis_kelamin = $updateData['jenis_kelamin'];
        $pegawai->tugas = $updateData['tugas'];

        if($pegawai->save()) {
            return response([
                'message' => 'Update Employee Success',
                'data' => $pegawai
            ], 200);
        }

        return response([
            'message' => 'Update Employee Failed',
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
        $pegawai = Pegawai::find($id);

        if(is_null($pegawai)){
            return response([
                'message' => 'Employee Not Found',
                'data' => null
            ], 404);
        }

        if($pegawai->delete()){
            return response([
                'message' => 'Delete Employee Success',
                'data' => $pegawai
            ], 200);
        }

        return response([
            'message' => 'Delete Employee Failed',
            'data' => null
        ], 400);
    }
}
