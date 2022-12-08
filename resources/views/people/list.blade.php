@extends('template.master')

@section('title')
list people absen
@endsection

@section('content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-gray-500">List absent</h6>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="105%" cellspacing="0">
                <thead>
                    <tr>
                        <th rowspan="2" style="vertical-align: middle;text-align: center;" width="5%">No</th>
                        <th rowspan="2" style="vertical-align: middle;text-align: center;" width="5%">NIK</th>
                        <th rowspan="2" style="vertical-align: middle;text-align: center;" width="25%">Name</th>
                        <th colspan="3" style="text-align: center;">Room A</th>
                        <th colspan="3" style="text-align: center;">Room B</th>
                        <th colspan="3" style="text-align: center;">Room C</th>
                        <th rowspan="2" style="vertical-align: middle;" width="10%">Information</th>
                        <th rowspan="2" style="vertical-align: middle;" width="10%">total duration</th>
                        <th rowspan="2" style="vertical-align: middle;" width="5%">date</th>
                    </tr>
                    <tr>
                        <th width="5%">in</th>
                        <th width="5%">out</th>
                        <th width="10%">duration</th>
                        <th width="5%">in</th>
                        <th width="5%">out</th>
                        <th width="10%">duration</th>
                        <th width="5%">in</th>
                        <th width="5%">out</th>
                        <th width="10%">duration</th>
                    </tr>
                </thead>

                <tbody>
                    @if(!empty($response['data']))
                        @foreach($response['data'] as $absent => $value)
                        <tr style="vertical-align: middle;text-align: center;font-size: 13px;">
                            <td width="5%">{{ $absent +1 }}</td>
                            <td width="5%">{{ $value['nik'] }}</td>
                            <td width="25%" style="text-transform: uppercase;">{{ $value['nama'] }}</td>

                            <td width="5%">
                                @if($value['absen_a_time_in']!=null)
                                {{ date("H:i:s",strtotime($value['absen_a_time_in'])) }}
                                @endif()
                            </td>
                            <td width="5%">
                                @if($value['absen_a_time_out']!=null)
                                {{ date("H:i:s",strtotime($value['absen_a_time_out'])) }}
                                @endif()
                            </td>
                            <td width="10%">
                                @if($value['absen_a_time_out']!=null)
                                {{ $value['a_duration'] }}
                                @endif()
                            </td>

                            <td width="5%">
                                @if($value['absen_b_time_in']!=null)
                                {{ date("H:i:s",strtotime($value['absen_b_time_in'])) }}
                                @endif()
                            </td>
                            <td width="5%">
                                @if($value['absen_b_time_out']!=null)
                                {{ date("H:i:s",strtotime($value['absen_b_time_out'])) }}
                                @endif()
                            </td>
                            <td width="10%">
                                @if($value['absen_b_time_out']!=null)
                                {{ date("H:i:s",strtotime($value['b_duration'])) }}
                                @endif()
                            </td>

                            <td width="5%">
                                @if($value['absen_c_time_in']!=null)
                                {{ date("H:i:s",strtotime($value['absen_c_time_in'])) }}
                                @endif()
                            </td>
                            <td width="5%">
                                @if($value['absen_c_time_out']!=null)
                                {{ date("H:i:s",strtotime($value['absen_c_time_out'])) }}
                                @endif()
                            </td>
                            <td width="10%">
                                @if($value['absen_c_time_out']!=null)
                                {{ date("H:i:s",strtotime($value['c_duration'])) }}
                                @endif()
                            </td>

                            <td width="10%">
                                @if($value['status_tap_in']==1)
                                @if($value['absen_a_time_out']==null)
                                In Room A
                                @else()
                                Out Room A
                                @endif()
                                @elseif($value['status_tap_in']==2)
                                @if($value['absen_b_time_out']==null)
                                In Room B
                                @else()
                                Out Room B
                                @endif()
                                @else()
                                @if($value['absen_c_time_out']==null)
                                In Room C
                                @else()
                                Out Room C
                                @endif()
                                @endif()
                            </td>
                            <td width="5%">
                                <!-- total duration -->
                                {{ $value['total_duration'] }}

                            </td>
                            <td width="5%">
                                {{ date("d/m/Y",strtotime($value['created_at'])) }}
                            </td>
                        </tr>
                        @endforeach()
                    @else()
                    @endif()

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection