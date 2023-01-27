<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    User,
    Karyawan,
    DetailTap,
    PeopleTapMenu,
    HistoryInOut,
};
use Carbon\Carbon;
use Session;

class PeopleController extends Controller
{
    
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
        if (!empty($data)) {
            foreach ($data as $key => $value) {

                if ($value->absen_a_time_out != null) {
                    // $a_duration = Carbon::parse($value->absen_a_time_out)->diff(Carbon::parse($value->absen_a_time_in))->format('%H:%I:%S');
                    $a_in = Carbon::parse($value->absen_a_time_in);
                    $a_out = Carbon::parse($value->absen_a_time_out);
                    $a_duration = $a_in->diffInSeconds($a_out);
                    $duration_a =  gmdate('H:i:s',$a_duration);
                } else {
                    $duration_a = '00:00:00';
                }
                if ($value->absen_b_time_out != null) {
                    // $b_duration = Carbon::parse($value->absen_b_time_out)->diff(Carbon::parse($value->absen_b_time_in))->format('%H:%I:%S');
                    $b_in = Carbon::parse($value->absen_b_time_in);
                    $b_out = Carbon::parse($value->absen_b_time_out);
                    $b_duration = $b_in->diffInSeconds($b_out);
                    $duration_b =  gmdate('H:i:s',$b_duration);
                } else {
                    $duration_b = '00:00:00';
                }
                if ($value->absen_c_time_out != null) {
                    // $c_duration = Carbon::parse($value->absen_c_time_out)->diff(Carbon::parse($value->absen_c_time_in))->format('%H:%I:%S');
                    $c_in = Carbon::parse($value->absen_c_time_in);
                    $c_out = Carbon::parse($value->absen_c_time_out);
                    $c_duration = $c_in->diffInSeconds($c_out);
                    $duration_c =  gmdate('H:i:s',$c_duration);
                } else {
                    $duration_c = '00:00:00';
                }

                if ($value->absen_a_time_out != null && $value->absen_b_time_out == null && $value->absen_c_time_out == null) {
                    $totaldurations = intval($a_duration);
                    $totaldurations = gmdate('H:i:s',$totaldurations);
                }elseif ($value->absen_a_time_out == null && $value->absen_b_time_out != null && $value->absen_c_time_out == null) {
                    $totaldurations = intval($b_duration);
                    $totaldurations = gmdate('H:i:s',$totaldurations);
                }elseif ($value->absen_a_time_out == null && $value->absen_b_time_out == null && $value->absen_c_time_out != null) {
                    $totaldurations = intval($c_duration);
                    $totaldurations = gmdate('H:i:s',$totaldurations);
                }elseif ($value->absen_a_time_out != null && $value->absen_b_time_out != null && $value->absen_c_time_out != null) {
                    $totaldurations = intval($a_duration)+intval($b_duration)+intval($c_duration);
                    $totaldurations = gmdate('H:i:s',$totaldurations);
                }elseif ($value->absen_a_time_out != null && $value->absen_b_time_out != null && $value->absen_c_time_out == null) {
                    $totaldurations = intval($a_duration)+intval($b_duration);
                    $totaldurations = gmdate('H:i:s',$totaldurations);
                }elseif ($value->absen_a_time_out != null && $value->absen_b_time_out == null && $value->absen_c_time_out != null) {
                    $totaldurations = intval($a_duration)+intval($c_duration);
                    $totaldurations = gmdate('H:i:s',$totaldurations);
                }elseif ($value->absen_a_time_out == null && $value->absen_b_time_out != null && $value->absen_c_time_out != null) {
                    $totaldurations = intval($b_duration)+intval($c_duration);
                    $totaldurations = gmdate('H:i:s',$totaldurations);
                }else {
                    $totaldurations = '00:00:00';
                }

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
                    'a_duration' => Carbon::parse($duration_a)->format('H:i:s'),
                    'b_duration' => Carbon::parse($duration_b)->format('H:i:s'),
                    'c_duration' => Carbon::parse($duration_c)->format('H:i:s'),
                    'total_duration'=> Carbon::parse($totaldurations)->format('H:i:s')
                ];
            }
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

        return view('people.list', ['response' => $response]);

    }


    public function create()
    {
    }


    public function store(Request $request)
    {
        $datenow = Carbon::now()->format('Y-m-d H:i:s');
        $dateparam = Carbon::now()->format('Y-m-d');
        $yearnow = Carbon::now()->format('Y');
        $monthnow = Carbon::now()->format('m');
        $daynow = Carbon::now()->format('d');
     
        $karyawan  = Karyawan::where('nik', $request->nik)->first();

        if (empty($karyawan)) {
            $response = [
                'status' => false,
                'message' => 'Failed to taping'
            ];
            $http_code = 404;
            return response()->json($response, $http_code);
        }
       
        $data = PeopleTapMenu::where('nik', $request->nik)->whereDate('created_at', $dateparam)->orderBy('created_at', 'DESC')->first();
        if (!empty($data)) {

            $getdetail=DetailTap::where('id_people_tap_menu', $data->id)->orderBy('created_at', 'DESC')->first();

            if ($data->absen_b_time_in!=null && $data->absen_b_time_out==null) {
                $data->absen_b_time_out = $datenow;
                $data->status_tap_out = 2;
                $save = $data->save();

                // update history absent/in_out
                $get_history=HistoryInOut::where('id_people_tap_menu', $data->id)->orderBy('created_at', 'DESC')->first();

                $b_duration = Carbon::parse($data->absen_b_time_in)->diffInSeconds(Carbon::parse($data->absen_b_time_out));
                $b_duration =  gmdate('Y-m-d H:i:s',$b_duration); 

                $get_history->time_out= $data->absen_b_time_out;
                $get_history->duration= $b_duration;
                $get_history->type_room= 'B';
                $get_history->save();

                $save_detail = new DetailTap;
                $save_detail->time_out= $data->absen_b_time_out;
                $save_detail->time_in= $data->absen_b_time_in;
                $save_detail->type_room= 'B';
                $save_detail->id_people_tap_menu= $data->id;
                $save_detail->save();
            } 
            if ($data->absen_c_time_in!=null && $data->absen_c_time_out==null) {
                $data->absen_c_time_out = $datenow;
                $data->status_tap_out = 3;
                $save = $data->save();

                // update history absent/in_out
                $get_history=HistoryInOut::where('id_people_tap_menu', $data->id)->orderBy('created_at', 'DESC')->first();

                $c_duration = Carbon::parse($data->absen_c_time_in)->diffInSeconds(Carbon::parse($data->absen_c_time_out));
                $c_duration =  gmdate('Y-m-d H:i:s',$c_duration); 

                $get_history->time_out= $data->absen_c_time_out;
                $get_history->duration= $c_duration;
                $get_history->type_room= 'C';
                $get_history->save();

                $save_detail = new DetailTap;
                $save_detail->time_out= $data->absen_c_time_out;
                $save_detail->time_in= $data->absen_c_time_in;
                $save_detail->type_room= 'C';
                $save_detail->id_people_tap_menu= $data->id;
                $save_detail->save();
            }
        }

        if (empty($data)) {
            $data = new PeopleTapMenu();
            $data->nik = $request->nik;
            $data->absen_a_time_in = $datenow;
            $data->status_tap_in = 1;
            $save = $data->save();

            // insert history
            $save_history = new HistoryInOut;
            $save_history->id_people_tap_menu= $data->id;
            $save_history->time_in= $data->absen_a_time_in;
            $save_history->type_room= 'A';
            $save_history->save();

        } else {

            if ($data->absen_a_time_in == NULL || $data->absen_a_time_in == null) {

                $data->nik = $request->nik;
                $data->absen_a_time_in = $datenow;
                $data->status_tap_in = 1;
                $save = $data->save();

                // insert history
                $save_history = new HistoryInOut;
                $save_history->id_people_tap_menu= $data->id;
                $save_history->time_in= $data->absen_a_time_in;
                $save_history->type_room= 'A';
                $save_history->save();

            } elseif ($data->absen_a_time_out == NULL || $data->absen_a_time_out == null) {
                // insert people_tap_menu
                $data->absen_a_time_out = $datenow;
                $data->status_tap_out = 1;
                $save = $data->save();

                // update history absent/in_out
                $get_history=HistoryInOut::where('id_people_tap_menu', $data->id)->orderBy('created_at', 'DESC')->first();

                $a_duration = Carbon::parse($data->absen_a_time_in)->diffInSeconds(Carbon::parse($data->absen_a_time_out));
                $a_duration =  gmdate('Y-m-d H:i:s',$a_duration); 

                $get_history->time_out= $data->absen_a_time_out;
                $get_history->duration= $a_duration;
                $get_history->type_room= 'A';
                $get_history->save();

                // insert detail_absent
                $getdetail=DetailTap::where('id_people_tap_menu', $data->id)->orderBy('created_at', 'DESC')->first();
                if (empty($getdetail)) {
                    $save_detail = new DetailTap;
                    $save_detail->time_out= $datenow;
                    $save_detail->type_room= 'A';
                    $save_detail->id_people_tap_menu= $data->id;
                    $save_detail = $save_detail->save();

                }else {
                    if ($getdetail->time_in==null && $getdetail->time_out != null) {

                        $getdetail->time_in= $datenow;
                        $getdetail->type_room= 'A';
                        $getdetail->id_people_tap_menu= $data->id;
                        $getdetail->save();

                    } elseif ($getdetail->time_in!=null && $getdetail->time_out != null) {
                        $save_detail = new DetailTap;
                        $save_detail->time_out= $datenow;
                        $save_detail->type_room= 'A';
                        $save_detail->id_people_tap_menu= $data->id;
                        $save_detail->save();

                    } else {

                    }
                }

            } elseif ($data->absen_a_time_out != null || $data->absen_a_time_out != NULL) {
                $data->absen_a_time_out = null;
                $data->status_tap_in = 1;
                $save = $data->save();

                $getdetail=DetailTap::where('id_people_tap_menu', $data->id)->orderBy('created_at', 'DESC')->first();

                if ($getdetail->time_in==null && $getdetail->time_out != null) {
                    $getdetail->time_in= $datenow;
                    $getdetail->type_room= 'A';
                    $getdetail->id_people_tap_menu= $data->id;
                    $save_detail= $getdetail->save();

                } elseif ($getdetail->time_in!=null && $getdetail->time_out != null) {
                 $save_detail = new DetailTap;
                 $save_detail->time_out= $datenow;
                 $save_detail->type_room= 'A';
                 $save_detail->id_people_tap_menu= $data->id;
                 $save_detail = $save_detail->save();

                } else {
                            //
                }

            }elseif ($data->absen_a_time_out != null && $data->absen_b_time_out != null && $data->absen_c_time_out != null) {
                $save = new PeopleTapMenu();
                $save->nik = $request->nik;
                $save->absen_a_time_in = $datenow;
                $save->status_tap_in = 1;
                $save = $save->save();
            }elseif ($data->absen_a_time_out != null && $data->absen_b_time_out != null && $data->absen_c_time_out == null) {
                $save = new PeopleTapMenu();
                $save->nik = $request->nik;
                $save->absen_a_time_in = $datenow;
                $save->status_tap_in = 1;
                $save = $save->save();
            }elseif ($data->absen_a_time_out != null && $data->absen_b_time_out == null && $data->absen_c_time_out != null) {
                $save = new PeopleTapMenu();
                $save->nik = $request->nik;
                $save->absen_a_time_in = $datenow;
                $save->status_tap_in = 1;
                $save = $save->save();
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
        $datenow = Carbon::now()->format('Y-m-d H:i:s');
        $dateparam = Carbon::now()->format('Y-m-d');

        $karyawan  = Karyawan::where('nik', $request->nik)->first();

        if (empty($karyawan)) {
            $response = [
                'status' => false,
                'message' => 'Failed to taping'
            ];
            $http_code = 404;
            return response()->json($response, $http_code);
        }

        $data = PeopleTapMenu::where('nik', $request->nik)->whereDate('created_at', $dateparam)->orderBy('created_at', 'DESC')->first();

        if (!empty($data)) {

            $getdetail=DetailTap::where('id_people_tap_menu', $data->id)->orderBy('created_at', 'DESC')->first();

            if ($data->absen_a_time_in !=null && $data->absen_a_time_out ==null) {
                $data->absen_a_time_out = $datenow;
                $data->status_tap_out = 1;
                $save = $data->save();

                // update history absent/in_out
                $get_history=HistoryInOut::where('id_people_tap_menu', $data->id)->orderBy('created_at', 'DESC')->first();

                $a_duration = Carbon::parse($data->absen_a_time_in)->diffInSeconds(Carbon::parse($data->absen_a_time_out));
                $a_duration =  gmdate('Y-m-d H:i:s',$a_duration); 

                $get_history->time_out= $data->absen_a_time_out;
                $get_history->duration= $a_duration;
                $get_history->type_room= 'A';
                $get_history->save();

                $save_detail = new DetailTap;
                $save_detail->time_out= $data->absen_a_time_out;
                $save_detail->time_in= $data->absen_a_time_in;
                $save_detail->type_room= 'A';
                $save_detail->id_people_tap_menu= $data->id;
                $save_detail->save();
            } 
            if ($data->absen_c_time_in!=null && $data->absen_c_time_out==null) {
                $data->absen_c_time_out = $datenow;
                $data->status_tap_out = 3;
                $save = $data->save();

                // update history absent/in_out
                $get_history=HistoryInOut::where('id_people_tap_menu', $data->id)->orderBy('created_at', 'DESC')->first();

                $c_duration = Carbon::parse($data->absen_c_time_in)->diffInSeconds(Carbon::parse($data->absen_c_time_out));
                $c_duration =  gmdate('Y-m-d H:i:s',$c_duration); 

                $get_history->time_out= $data->absen_c_time_out;
                $get_history->duration= $c_duration;
                $get_history->type_room= 'C';
                $get_history->save();

                $save_detail = new DetailTap;
                $save_detail->time_out= $data->absen_c_time_out;
                $save_detail->time_in= $data->absen_c_time_in;
                $save_detail->type_room= 'C';
                $save_detail->id_people_tap_menu= $data->id;
                $save_detail->save();
            }
        }

        if (empty($data)) {
            $data = new PeopleTapMenu();
            $data->nik = $request->nik;
            $data->absen_b_time_in = $datenow;
            $data->status_tap_in = 2;
            $save = $data->save();

            // insert history
            $save_history = new HistoryInOut;
            $save_history->id_people_tap_menu= $data->id;
            $save_history->time_in= $data->absen_b_time_in;
            $save_history->type_room= 'B';
            $save_history->save();

        } else {

            if ($data->absen_b_time_in == NULL || $data->absen_b_time_in == null) {
                $data->absen_b_time_in = $datenow;
                $data->status_tap_in = 2;
                $save = $data->save();

                // insert history
                $save_history = new HistoryInOut;
                $save_history->id_people_tap_menu= $data->id;
                $save_history->time_in= $data->absen_b_time_in;
                $save_history->type_room= 'B';
                $save_history->save();

            } elseif ($data->absen_b_time_out == NULL || $data->absen_b_time_out == null) {
                // update people_tap_menu
                $data->absen_b_time_out = $datenow;
                $data->status_tap_out = 2;
                $save = $data->save();

                // update history absent/in_out
                $get_history=HistoryInOut::where('id_people_tap_menu', $data->id)->orderBy('created_at', 'DESC')->first();

                $b_duration = Carbon::parse($data->absen_b_time_in)->diffInSeconds(Carbon::parse($data->absen_b_time_out));
                $b_duration =  gmdate('Y-m-d H:i:s',$b_duration); 

                $get_history->time_out= $data->absen_b_time_out;
                $get_history->duration= $b_duration;
                $get_history->type_room= 'B';
                $get_history->save();

                // insert detail absent
                $save_detail = new DetailTap;
                $save_detail->time_out= $datenow;
                $save_detail->type_room= 'B';
                $save_detail->id_people_tap_menu= $data->id;
                $save_detail = $save_detail->save();

            } elseif ($data->absen_b_time_out != NULL || $data->absen_b_time_out != null) {
                $data->absen_b_time_out = null;
                $data->status_tap_out = 3;
                $save = $data->save();

                $getdetail=DetailTap::where('id_people_tap_menu', $data->id)->orderBy('created_at', 'DESC')->first();

                if ($getdetail->time_in==null && $getdetail->time_out != null) {

                    $getdetail->time_in= $datenow;
                    $getdetail->type_room= 'B';
                    $getdetail->id_people_tap_menu= $data->id;
                    $save_detail= $getdetail->save();

                } elseif ($getdetail->time_in!=null && $getdetail->time_out != null) {
                     $save_detail = new DetailTap;
                     $save_detail->time_out= $datenow;
                     $save_detail->type_room= 'B';
                     $save_detail->id_people_tap_menu= $data->id;
                     $save_detail = $save_detail->save();

                } else {

                }

            } elseif ($data->absen_a_time_out != null && $data->absen_b_time_out != null && $data->absen_c_time_out != null) {
                $save = new PeopleTapMenu();
                $save->nik = $request->nik;
                $save->absen_b_time_in = $datenow;
                $save->status_tap_in = 2;
                $save = $save->save();
            } elseif ($data->absen_a_time_out != null && $data->absen_b_time_out != null && $data->absen_c_time_out == null) {
                $save = new PeopleTapMenu();
                $save->nik = $request->nik;
                $save->absen_b_time_in = $datenow;
                $save->status_tap_in = 2;
                $save = $save->save();
            } elseif ($data->absen_a_time_out == null && $data->absen_b_time_out != null && $data->absen_c_time_out != null) {
                $save = new PeopleTapMenu();
                $save->nik = $request->nik;
                $save->absen_b_time_in = $datenow;
                $save->status_tap_in = 2;
                $save = $save->save();
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


    public function taping_c(Request $request)
    {
        $datenow = Carbon::now()->format('Y-m-d H:i:s');
        $dateparam = Carbon::now()->format('Y-m-d');

        $karyawan  = Karyawan::where('nik', $request->nik)->first();

        if (empty($karyawan)) {
            $response = [
                'status' => false,
                'message' => 'Failed to taping'
            ];
            $http_code = 404;
            return response()->json($response, $http_code);
        }
        
        $data = PeopleTapMenu::where('nik', $request->nik)->whereDate('created_at', $dateparam)->orderBy('created_at', 'DESC')->first();

        if (!empty($data)) {

            $getdetail=DetailTap::where('id_people_tap_menu', $data->id)->orderBy('created_at', 'DESC')->first();

            if ($data->absen_a_time_in !=null && $data->absen_a_time_out ==null) {
                $data->absen_a_time_out = $datenow;
                $data->status_tap_out = 1;
                $save = $data->save();

                // update history absent/in_out
                $get_history=HistoryInOut::where('id_people_tap_menu', $data->id)->orderBy('created_at', 'DESC')->first();

                $a_duration = Carbon::parse($data->absen_a_time_in)->diffInSeconds(Carbon::parse($data->absen_a_time_out));
                $a_duration =  gmdate('Y-m-d H:i:s',$a_duration); 

                $get_history->time_out= $data->absen_a_time_out;
                $get_history->duration= $a_duration;
                $get_history->type_room= 'A';
                $get_history->save();

                $save_detail = new DetailTap;
                $save_detail->time_out= $data->absen_a_time_out;
                $save_detail->time_in= $data->absen_a_time_in;
                $save_detail->type_room= 'A';
                $save_detail->id_people_tap_menu= $data->id;
                $save_detail->save();
            } 
            if ($data->absen_b_time_in!=null && $data->absen_b_time_out==null) {
                $data->absen_b_time_out = $datenow;
                $data->status_tap_out = 2;
                $save = $data->save();

                // update history absent/in_out
                $get_history=HistoryInOut::where('id_people_tap_menu', $data->id)->orderBy('created_at', 'DESC')->first();

                $b_duration = Carbon::parse($data->absen_b_time_in)->diffInSeconds(Carbon::parse($data->absen_b_time_out));
                $b_duration =  gmdate('Y-m-d H:i:s',$b_duration); 

                $get_history->time_out= $data->absen_b_time_out;
                $get_history->duration= $b_duration;
                $get_history->type_room= 'B';
                $get_history->save();

                $save_detail = new DetailTap;
                $save_detail->time_out= $data->absen_b_time_out;
                $save_detail->time_in= $data->absen_b_time_in;
                $save_detail->type_room= 'B';
                $save_detail->id_people_tap_menu= $data->id;
                $save_detail->save();
            }
        }

        if (empty($data)) {
            $data = new PeopleTapMenu();
            $data->nik = $request->nik;
            $data->absen_c_time_in = $datenow;
            $data->status_tap_in = 3;
            $save = $data->save();

            // insert history
            $save_history = new HistoryInOut;
            $save_history->id_people_tap_menu= $data->id;
            $save_history->time_in= $data->absen_c_time_in;
            $save_history->type_room= 'C';
            $save_history->save();

        } else {

            if ($data->absen_c_time_in == NULL || $data->absen_c_time_in == null) {
                $data->absen_c_time_in = $datenow;
                $data->status_tap_in = 3;
                $save = $data->save();

                // insert history
                $save_history = new HistoryInOut;
                $save_history->id_people_tap_menu= $data->id;
                $save_history->time_in= $data->absen_c_time_in;
                $save_history->type_room= 'C';
                $save_history->save();

            } elseif ($data->absen_c_time_out == NULL || $data->absen_c_time_out == null) {
                // update people_tap_menu
                $data->absen_c_time_out = $datenow;
                $data->status_tap_out = 3;
                $save = $data->save();

                // update history absent/in_out
                $get_history=HistoryInOut::where('id_people_tap_menu', $data->id)->orderBy('created_at', 'DESC')->first();

                $c_duration = Carbon::parse($data->absen_c_time_in)->diffInSeconds(Carbon::parse($data->absen_c_time_out));
                $c_duration =  gmdate('Y-m-d H:i:s',$c_duration); 

                $get_history->time_out= $data->absen_c_time_out;
                $get_history->duration= $c_duration;
                $get_history->type_room= 'C';
                $get_history->save();

                // insert detail_absent
                $save_detail = new DetailTap;
                $save_detail->time_out= $datenow;
                $save_detail->type_room= 'B';
                $save_detail->id_people_tap_menu= $data->id;
                $save_detail = $save_detail->save();

            } elseif ($data->absen_c_time_out != NULL || $data->absen_c_time_out != null) {
                $data->absen_c_time_out = null;
                $data->status_tap_in = 3;
                $save = $data->save();

                $getdetail=DetailTap::where('id_people_tap_menu', $data->id)->orderBy('created_at', 'DESC')->first();

                if ($getdetail->time_in==null && $getdetail->time_out != null) {
                    $getdetail->time_in= $datenow;
                    $getdetail->type_room= 'C';
                    $getdetail->id_people_tap_menu= $data->id;
                    $save_detail= $getdetail->save();

                } elseif ($getdetail->time_in!=null && $getdetail->time_out != null) {
                     $save_detail = new DetailTap;
                     $save_detail->time_out= $datenow;
                     $save_detail->type_room= 'C';
                     $save_detail->id_people_tap_menu= $data->id;
                     $save_detail = $save_detail->save();

                } else {

                }
            } elseif ($data->absen_a_time_out != null && $data->absen_b_time_out != null && $data->absen_c_time_out != null) {
                $save = new PeopleTapMenu();
                $save->nik = $request->nik;
                $save->absen_c_time_in = $datenow;
                $save->status_tap_in = 3;
                $save = $save->save();
            } elseif ($data->absen_a_time_out == null && $data->absen_b_time_out != null && $data->absen_c_time_out != null) {
                $save = new PeopleTapMenu();
                $save->nik = $request->nik;
                $save->absen_c_time_in = $datenow;
                $save->status_tap_in = 3;
                $save = $save->save();
            } elseif ($data->absen_a_time_out != null && $data->absen_b_time_out == null && $data->absen_c_time_out != null) {
                $save = new PeopleTapMenu();
                $save->nik = $request->nik;
                $save->absen_c_time_in = $datenow;
                $save->status_tap_in = 3;
                $save = $save->save();
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


    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }

    public function detail_absent()
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

        $list_detail = DetailTap::with('people_tap_menu.karyawan')
                    // ->whereNotNull('time_in')
                    ->offset($limit_page)
                    ->limit($perpage)
                    ->orderBy('created_at', 'DESC')
                    ->get();

        $data_detail = [];
        if (!empty($list_detail)) {
            foreach ($list_detail as $key => $value) {

                if ($value->time_in !=null) {
                    // $rest_duration = Carbon::parse($value->time_in)->diff(Carbon::parse($value->time_out))->format('%H:%I:%S');
                    $in = Carbon::parse($value->time_in);
                    $out = Carbon::parse($value->time_out);
                    $rest_duration = $in->diffInSeconds($out);
                    $rest_duration =  gmdate('H:i:s',$rest_duration);

                    $time_in = $value->time_in;

                } else {
                    $rest_duration = '00:00:00';
                    $time_in = '00:00:00';
                }

                
                $data_detail[] = [
                    'nama' => $value->people_tap_menu->karyawan->nama,
                    'nik' => $value->people_tap_menu->nik,
                    'time_in' => $time_in,
                    'time_out' => $value->time_out,
                    'type_room' => $value->type_room,
                    'total_duration_rest' => Carbon::parse($rest_duration)->format('H:i:s'),
                    'date' => $value->created_at
                ];
            }
        }

        $count = count($data_detail);
        if ($count / $requestpage <= ($perpage)) {

            $islastpage = true;
        } else {
            $islastpage = false;
        }

        $lastPage = ceil($count / $perpage);


        if (count($data_detail) != 0) {

            $response = [
                "status" => true,
                "message" => "page berhasil ditampilkan",
                "data" => $data_detail,
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
    //    return $response;
      return view('people.list_detail', ['response' => $response]);
    }


    public function submitform()
    {
        $get=Karyawan::orderBy('id', 'DESC')->get();
        return view('submitform',['get' => $get]);
    }


    public function getkaryawan()
    {
        $get=Karyawan::all();
        return view('submitform',['get' => $get]);
        
    }


    public function history_in_out()
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

        $data_history = HistoryInOut::select('*', 'people_tap_menu.*', 'karyawan.nama', 'karyawan.nik')
            ->leftjoin('people_tap_menu', 'people_tap_menu.id', '=', 'history_in_out.id_people_tap_menu')
            ->leftjoin('karyawan', 'karyawan.nik', '=', 'people_tap_menu.nik')
            ->offset($limit_page)
            ->limit($perpage)
            ->orderBy('history_in_out.updated_at', 'DESC')
            ->get();

        $dathis = [];
        if (!empty($data_history)) {
            foreach ($data_history as $key => $value) {
                if ($value->time_out !=null || $value->duration !=null) {
                    $time_out = $value->time_out;
                    $duration = $value->duration;
                } else {
                    $time_out = '00:00:00';
                    $duration = '00:00:00';
                }
                
                $dathis[] = [
                    'nik' => $value->nik,
                    'nama' => $value->nama,
                    'time_in' => $value->time_in,
                    'time_out' => $time_out,
                    'duration' => $duration,
                    'type_room' => $value->type_room,
                    'date' => $value->created_at
                ];
            }
        } 

        $count = count(HistoryInOut::get());
        if ($count / $requestpage <= ($perpage)) {

            $islastpage = true;
        } else {
            $islastpage = false;
        }

        $lastPage = ceil($count / $perpage);


        if (count($dathis) != 0) {

            $response = [
                "status" => true,
                "message" => "page berhasil ditampilkan",
                "data" => $dathis,
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

        return view('people.list_history', ['response' => $response]);
    }
}