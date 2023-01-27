@extends('template.master')

@section('title')
list people absen
@endsection

@section('content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-gray-500">Absent List</h6>
        <!-- <a href="{{url('/karyawan')}}" class="btn btn-outline-primary py-1" style="margin-left: 2px; float: right;margin-right: 30px">List Karyawan</a> -->
        <button class="btn btn-outline-primary btn-rounded mb-2 py-1 sidebarcuk" style="margin-top: 10px">Menu <-></button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> -->
            <table class="table table-bordered" id="zero-config" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th rowspan="2" style="vertical-align: middle;text-align: center;" width="5%">No</th>
                        <th rowspan="2" style="vertical-align: middle;text-align: center;" width="5%">NIK</th>
                        <th rowspan="2" style="vertical-align: middle;text-align: center;" width="25%">Name</th>
                        <th colspan="3" style="vertical-align: middle;text-align: center;">Room A</th>
                        <th colspan="3" style="vertical-align: middle;text-align: center;">Room B</th>
                        <th colspan="3" style="vertical-align: middle;text-align: center;">Room C</th>
                        <th rowspan="2" style="vertical-align: middle;text-align: center;" width="10%">Information</th>
                        <th rowspan="2" style="vertical-align: middle;text-align: center;" width="5%">Total Duration</th>
                        <th rowspan="2" style="vertical-align: middle;text-align: center;" width="5%">Date</th>
                    </tr>
                    <tr>
                        <th style="vertical-align: middle;text-align: center;" width="5%">in</th>
                        <th style="vertical-align: middle;text-align: center;" width="5%">out</th>
                        <th style="vertical-align: middle;text-align: center;" width="5%">duration</th>
                        <th style="vertical-align: middle;text-align: center;" width="5%">in</th>
                        <th style="vertical-align: middle;text-align: center;" width="5%">out</th>
                        <th style="vertical-align: middle;text-align: center;" width="5%">duration</th>
                        <th style="vertical-align: middle;text-align: center;" width="5%">in</th>
                        <th style="vertical-align: middle;text-align: center;" width="5%">out</th>
                        <th style="vertical-align: middle;text-align: center;" width="5%">duration</th>
                    </tr>
                </thead>

                <tbody>
                    @if(!empty($response['data']))
                        @foreach($response['data'] as $absent => $value)
                        <tr style="vertical-align: middle;text-align: center;font-size: 13px;">
                            <td style="vertical-align: middle;text-align: center;" width="5%">{{ $absent +1 }}</td>
                            <td style="vertical-align: middle;text-align: center;" width="5%">{{ $value['nik'] }}</td>
                            <td style="vertical-align: middle;text-align: center;" width="25%" style="text-transform: uppercase;">{{ $value['nama'] }}</td>

                            <td style="vertical-align: middle;text-align: center;" width="5%">
                                @if($value['absen_a_time_in']!=null)
                                {{ date("H:i:s",strtotime($value['absen_a_time_in'])) }}
                                @endif()
                            </td>
                            <td style="vertical-align: middle;text-align: center;" width="5%">
                                @if($value['absen_a_time_out']!=null)
                                {{ date("H:i:s",strtotime($value['absen_a_time_out'])) }}
                                @endif()
                            </td>
                            <td style="vertical-align: middle;text-align: center;" width="5%">
                                @if($value['absen_a_time_out']!=null)
                                {{ $value['a_duration'] }}
                                @endif()
                            </td>

                            <td style="vertical-align: middle;text-align: center;" width="5%">
                                @if($value['absen_b_time_in']!=null)
                                {{ date("H:i:s",strtotime($value['absen_b_time_in'])) }}
                                @endif()
                            </td>
                            <td style="vertical-align: middle;text-align: center;" width="5%">
                                @if($value['absen_b_time_out']!=null)
                                {{ date("H:i:s",strtotime($value['absen_b_time_out'])) }}
                                @endif()
                            </td>
                            <td style="vertical-align: middle;text-align: center;" width="5%">
                                @if($value['absen_b_time_out']!=null)
                                {{ date("H:i:s",strtotime($value['b_duration'])) }}
                                @endif()
                            </td>

                            <td style="vertical-align: middle;text-align: center;" width="5%">
                                @if($value['absen_c_time_in']!=null)
                                {{ date("H:i:s",strtotime($value['absen_c_time_in'])) }}
                                @endif()
                            </td>
                            <td style="vertical-align: middle;text-align: center;" width="5%">
                                @if($value['absen_c_time_out']!=null)
                                {{ date("H:i:s",strtotime($value['absen_c_time_out'])) }}
                                @endif()
                            </td>
                            <td style="vertical-align: middle;text-align: center;" width="5%">
                                @if($value['absen_c_time_out']!=null)
                                {{ date("H:i:s",strtotime($value['c_duration'])) }}
                                @endif()
                            </td>

                            <td style="vertical-align: middle;text-align: center;" width="5%">
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
                            <td style="vertical-align: middle;text-align: center;" width="10%">
                                <!-- total duration -->
                                {{ $value['total_duration'] }}

                            </td>
                            <td style="vertical-align: middle;text-align: center;" width="5%">
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

@push('scripts')
<script>
    $(document).ready(function(){
      $(".sidebarcuk").click(function(){
        $("#accordionSidebar").toggle();
    });
  });
</script>

<!-- datatable -->
<script>
    $('#zero-config').DataTable({
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7 
    });
</script>
@endpush    