<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeopleTapMenu;
use App\Models\User;
use App\Models\Karyawan;
use Carbon\Carbon;


class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perpage=10;
        if (empty($request->page)) {
            $requestpage = 1;
        } else {
            $requestpage = $request->page;
        }

        if ($requestpage == 1) {
            $page = 1;
            $limit_page = 0;
        } else {
            $limit_page = ($request->page * $perpage) - $perpage;
        }
        
        $data = PeopleTapMenu::select('people_tap_menu.*','karyawan.nama','karyawan.email','karyawan.departemen')
        ->join('karyawan','karyawan.nik','=','people_tap_menu.nik')
        ->offset($limit_page)
        ->limit($perpage)
        ->orderBy('created_at', 'DESC')
        ->get();

        $count = count(PeopleTapMenu::get());
        if ($count / $requestpage <= ($perpage)) {

            $islastpage = true;
        } else {
            $islastpage = false;
        }

        $lastPage = ceil($count / $perpage);


        if (count($data) != 0) {

            $response = [
                "status" => true,
                "message" => "page berhasil ditampilkan",
                "data" => $data,
                "totaldata" => $count,
                "page" => $requestpage,
                "last_page" => $lastPage,
                "is_last_page" => $islastpage
            ];
            $http_code = 200;
        } else {
            $response = [
                "status" => false,
                "message" => "Tidak Ada data page",
                "totaldata" => $count,
                "page" => $requestpage,
                "last_page" => $lastPage,
                "is_last_page" => $islastpage
            ];
            $http_code = 200;
        }

        return view('people.list', ['data' => $data, 'response' => $response]);

            // return response($response, $http_code);

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
        // return $request->all();
        $datenow=Carbon::now()->format('Y-m-d H:i:s');
        $dateparam=Carbon::now()->format('Y-m-d');


        $data = PeopleTapMenu::where('nik',$request->nik)->whereDate('created_at',$dateparam)->first();
        if (empty($data)) {
           $save = new PeopleTapMenu();
           $save->nik = $request->nik;
           $save->absen_a_time_in = $datenow;
           $save->status_tap_in = 1;
           $save = $save->save();

        } else {

            if ($data->absen_a_time_out==NULL || $data->absen_a_time_out==null) {

               $data->nik = $request->nik;
               $data->absen_a_time_out = $datenow;
               $data->status_tap_out = 1;
               $save = $data->save();

            } elseif ($data->absen_b_time_in==NULL || $data->absen_b_time_in==null) {
               $data->absen_b_time_in = $datenow;
               $data->status_tap_in = 2;
               $save = $data->save();

            } elseif ($data->absen_b_time_out==NULL || $data->absen_b_time_out==null) {

               $data->absen_b_time_out = $datenow;
               $data->status_tap_out = 2;
               $save = $data->save();

            }elseif ($data->absen_c_time_in==NULL || $data->absen_c_time_in==null) {

              $data->absen_c_time_in = $datenow;
              $data->status_tap_in = 3;
              $save = $data->save();

            }elseif ($data->absen_c_time_out==NULL || $data->absen_c_time_out==null) {

               $data->absen_c_time_out = $datenow;
               $data->status_tap_out = 3;
               $save = $data->save();

            } else {
                $response = [
                    'status'=> false,
                    'message'=> 'Failed to taping'
                ];
                $http_code = 422;
                return response($response, $http_code);

            }

            $response = [
                'status'=> false,
                'message'=> 'Failed to taping'
            ];
            $http_code = 422;
            return response($response, $http_code);

        }
        
        if($save){
            $response = [
             'status'=> true,
             'message'=> 'Tapping success',
             'data' => $save,
             ];
            $http_code = 200;

        }else{
             $response = [
                'status'=> false,
                'message'=> 'Failed to tap'
            ];
            $http_code = 422;
     
        }
        return response($response, $http_code);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
