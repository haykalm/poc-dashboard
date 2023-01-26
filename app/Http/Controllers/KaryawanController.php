<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    User,
    Karyawan,
    // DetailTap,
    // PeopleTapMenu,
};
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $karyawan = Karyawan::select('*')->orderBy('id', 'DESC')->get();

        return view('karyawan.list', ['karyawan' => $karyawan]);
    }   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     // return $request;
        $validator = Validator::make($request->all(), [
            'nik' => 'required|unique:karyawan|max:5',
            'nama' => 'required',
            'email' => 'unique:karyawan|max:255',   
        ]);
        
        if ($validator->fails()) {
            $out = [
            "message" => $validator->messages()->all(),
            ];
            // return response()->json($out, 422);
            foreach ($out as $key => $value) {
                Alert::error('Failed!', $value);
                return back();
            }

        }

        $karyawan = Karyawan::all();
        $count = count($karyawan);

        if ($count == 201) {
            $response = [
                'status' => false,
                'message' => 'Failed to insert, limit max 200 data'
            ];
            $http_code = 422;

            Alert::error('Failed', 'jumlah karyawan sudah penuh! (limit:201)');
            return back();
        } else {
           $save = Karyawan::create($request->all());
        }

        if ($save) {
            $response = [
                'status' => true,
                'message' => 'success saved data',
                'data' => $save
            ];
            $http_code = 200;

            Alert::success('Success', 'karyawan berhasil ditambahkan!');
            return back();
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to saved data'
            ];
            $http_code = 422;

            Alert::error('Failed', 'karyawan gagal ditambahkan!');
            return back();
        }

        // return redirect()->back();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Karyawan::findOrFail($id);
        return view('karyawan.edit_modal')->with([
            'data' => $data
        ]);
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
        $id = base64_decode($id);
        $karyawan = Karyawan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nik' => 'required|max:5',
            'nama' => 'required',
        ]);
        
        if ($validator->fails()) {
            $out = [
                "message" => $validator->messages()->all(),
            ];
            return response()->json($out, 422);
        }

        $save = $karyawan->update($request->all()); 

        if ($save) {
            $response = [
                'status' => true,
                'message' => 'success updated data',
                'data' => $save
            ];
            $http_code = 200;

            Alert::success('Success', 'karyawan berhasil diupdate!');
            return back();
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to updated data'
            ];
            $http_code = 422;

            Alert::error('Failed', 'karyawan gagal diupdate!');
            return back();
        }

        // return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // return $id;

        $data = Karyawan::findOrFail($id);
        if ($data) {
            $response = [
                'status' => true,
                'message' => 'success deleted data',
                'data' => $data
            ];
            $http_code = 200;

            $data->delete();

            Alert::success('Success', 'karyawan berhasil dihapus!');
            return back();
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to delete data'
            ];
            $http_code = 422;

            Alert::error('Failed', 'karyawan gagal dihapus!');
            return back();
        }

       // return redirect()->back();
    }
}
