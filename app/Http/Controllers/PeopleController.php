<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeopleTapMenu;
use App\Models\User;
use App\Models\Karyawan;
use Carbon\Carbon;
use Session;


class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perpage = 10;
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

        $data = PeopleTapMenu::select('people_tap_menu.*', 'karyawan.nama', 'karyawan.email', 'karyawan.departemen')
            ->join('karyawan', 'karyawan.nik', '=', 'people_tap_menu.nik')
            ->offset($limit_page)
            ->limit($perpage)
            ->orderBy('created_at', 'DESC')
            ->get();
        $datalist = [];
        foreach ($data as $key => $value) {
            if ($value->absen_a_time_out != null) {
                $a_duration = Carbon::parse($value->absen_a_time_in)->diff(Carbon::parse($value->absen_a_time_out))->format('%H:%I:%S');
            } else {
                $a_duration = '00:00:00';
            }
            if ($value->absen_b_time_out != null) {
                $b_duration = Carbon::parse($value->absen_b_time_in)->diff(Carbon::parse($value->absen_b_time_out))->format('%H:%I:%S');
            } else {
                $b_duration = '00:00:00';
            }
            if ($value->absen_c_time_out != null) {
                $c_duration = Carbon::parse($value->absen_c_time_in)->diff(Carbon::parse($value->absen_c_time_out))->format('%H:%I:%S');
            } else {
                $c_duration = '00:00:00';
            }
            $a_explode=explode(':',$a_duration);
            $b_explode=explode(':',$b_duration);
            $c_explode=explode(':',$c_duration);
            $totalhour=$a_explode[0]+$b_explode[0]+$c_explode[0];
            $totalminutes=$a_explode[1]+$b_explode[1]+$c_explode[1];
            $totalsecond=$a_explode[2]+$b_explode[2]+$c_explode[2];
            $minutes=$totalminutes;
            $second=$totalsecond;

            if ($totalminutes==60) {
                $hour=$totalhour+1;
                $minutes=0;
            }elseif($totalminutes<60 && $totalsecond>=60 ){
                $hour=$totalhour;
                $minutes=$totalminutes+1;
                $second=0;
            }elseif($totalminutes<60 && $totalsecond<60 ){
                $hour=$totalhour;
                $minutes=$totalminutes;
                $second=$totalsecond+0;
            }else{
                $hour=$totalhour;
                $minutes=$totalminutes;
                $second=$totalsecond;
            }
            $totaldurations=$hour.':'.$minutes.':'.$second;
            
            $datalist[] = [
                'nik' => $value->nik,
                'nama' => $value->nama,
                'absen_a_time_in' => $value->absen_a_time_in,
                'absen_a_time_out' => $value->absen_a_time_out,
                'absen_b_time_in' => $value->absen_b_time_in,
                'absen_b_time_out' => $value->absen_b_time_out,
                'absen_c_time_in' => $value->absen_c_time_in,
                'absen_c_time_out' => $value->absen_c_time_out,
                'status_tap_in' => $value->status_tap_in,
                'status_tap_out' => $value->status_tap_out,
                'created_at' => $value->created_at,
                'a_duration' => $a_duration,
                'b_duration' => $b_duration,
                'c_duration' => $c_duration,
                'total_duration'=>Carbon::parse($totaldurations)->format('H:i:s')
            ];
        }

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
                "data" => $datalist,
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
            $http_code = 422;
        }

        return view('people.list', ['data' => $data, 'response' => $response, 'datalist' => $datalist]);

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
        //  return $request->all();
        $datenow = Carbon::now()->format('Y-m-d H:i:s');
        $dateparam = Carbon::now()->format('Y-m-d');


        $data = PeopleTapMenu::where('nik', $request->nik)->whereDate('created_at', $dateparam)->first();
        if (empty($data)) {
            $save = new PeopleTapMenu();
            $save->nik = $request->nik;
            $save->absen_a_time_in = $datenow;
            $save->status_tap_in = 1;
            $save = $save->save();
        } else {

            if ($data->absen_a_time_in == NULL || $data->absen_a_time_in == null) {

                $data->nik = $request->nik;
                $data->absen_a_time_in = $datenow;
                $data->status_tap_in = 1;
                $save = $data->save();
            } elseif ($data->absen_a_time_out == NULL || $data->absen_a_time_out == null) {

                $data->absen_a_time_out = $datenow;
                $data->status_tap_out = 1;
                $save = $data->save();
            } elseif ($data->absen_a_time_out != NULL || $data->absen_a_time_out != null) {

                $data->absen_a_time_out = null;
                $data->status_tap_in = 1;
                $save = $data->save();
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Failed to taping'
                ];
                $http_code = 422;
                return response($response, $http_code);
            }
        }

        if ($save) {
            $response = [
                'status' => true,
                'message' => 'Tapping success',
                'data' => $save,
            ];
            $http_code = 200;
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to taping'
            ];
            $http_code = 422;
        }
        if (!empty($request->post)) {
            // return redirect()->back();
            return redirect()->back()->with('success', 'your message,here');
        } else {
            return response($response, $http_code);
        }

        // return response($response, $http_code);
    }
    public function taping_b(Request $request)
    {
        // return $request->all();
        $datenow = Carbon::now()->format('Y-m-d H:i:s');
        $dateparam = Carbon::now()->format('Y-m-d');


        $data = PeopleTapMenu::where('nik', $request->nik)->whereDate('created_at', $dateparam)->first();
        if (empty($data)) {
            $save = new PeopleTapMenu();
            $save->nik = $request->nik;
            $save->absen_b_time_in = $datenow;
            $save->status_tap_in = 2;
            $save = $save->save();
        } else {

            if ($data->absen_b_time_in == NULL || $data->absen_b_time_in == null) {

                $data->absen_b_time_in = $datenow;
                $data->status_tap_in = 2;
                $save = $data->save();
            } elseif ($data->absen_b_time_out == NULL || $data->absen_b_time_out == null) {

                $data->absen_b_time_out = $datenow;
                $data->status_tap_out = 2;
                $save = $data->save();
            } elseif ($data->absen_b_time_out != NULL || $data->absen_b_time_out != null) {

                $data->absen_b_time_out = null;
                $data->status_tap_out = 3;
                $save = $data->save();
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Failed to taping'
                ];
                $http_code = 422;
                return response($response, $http_code);
            }
        }

        if ($save) {
            $response = [
                'status' => true,
                'message' => 'Tapping success',
                'data' => $save,
            ];
            $http_code = 200;
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to taping'
            ];
            $http_code = 422;
        }

        if (!empty($request->post)) {
            return redirect()->back()->with('success', 'your message,here');
        } else {
            return response($response, $http_code);
        }
        // return response($response, $http_code);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function taping_c(Request $request)
    {
        // return $request->all();
        $datenow = Carbon::now()->format('Y-m-d H:i:s');
        $dateparam = Carbon::now()->format('Y-m-d');


        $data = PeopleTapMenu::where('nik', $request->nik)->whereDate('created_at', $dateparam)->first();
        if (empty($data)) {
            $save = new PeopleTapMenu();
            $save->nik = $request->nik;
            $save->absen_c_time_in = $datenow;
            $save->status_tap_in = 3;
            $save = $save->save();
        } else {

            if ($data->absen_c_time_in == NULL || $data->absen_c_time_in == null) {

                // $data->nik = $request->nik;
                $data->absen_c_time_in = $datenow;
                $data->status_tap_in = 3;
                $save = $data->save();
            } elseif ($data->absen_c_time_out == NULL || $data->absen_c_time_out == null) {

                $data->absen_c_time_out = $datenow;
                $data->status_tap_out = 3;
                $save = $data->save();
            } elseif ($data->absen_c_time_out != NULL || $data->absen_c_time_out != null) {

                $data->absen_c_time_out = null;
                $data->status_tap_in = 3;
                $save = $data->save();
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Failed to taping'
                ];
                $http_code = 422;
                return response($response, $http_code);
            }
        }

        if ($save) {
            $response = [
                'status' => true,
                'message' => 'Tapping success',
                'data' => $save,
            ];
            $http_code = 200;
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to taping'
            ];
            $http_code = 422;
        }
        if (!empty($request->post)) {
            return redirect()->back()->with('success', 'your message,here');
        } else {
            return response($response, $http_code);
        }
        // return response($response, $http_code);
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

    public function submitform()
    {
        $get=Karyawan::all();
        return view('submitform',['get' => $get]);
    }

    public function getkaryawan()
    {
        $get=Karyawan::all();
        return view('submitform',['get' => $get]);
        
    }
}
