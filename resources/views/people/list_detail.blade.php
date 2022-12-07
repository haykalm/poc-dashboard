@extends('template.master')

@section('title')
  Detail Absent 
@endsection

@section('content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-gray-500">List Rest Time</h6>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead> 
                    <tr style="vertical-align: middle;text-align: center;">
                        <th width="5%">No</th>
                        <th width="7%">NIK</th>
                        <th width="20%">Name</th>
                        <th width="10%">In</th>
                        <th width="10%">Out</th>
                        <th width="10%">Status</th>
                        <th width="10%">Rest Duration</th>
                        <th width="10%">Date</th>
                    </tr>
                </thead>

                <tbody>
                    @if(!empty($response['data']))
                        @foreach($response['data'] as $datail => $value)
                        <tr style="vertical-align: middle;text-align: center;font-size: 13px;">
                            <td width="5%">{{ $data +1 }}</td>
                            <td width="10%">{{ $value['nik'] }}</td>
                            <td width="20%" style="text-transform: uppercase;">{{ $value['nama'] }}</td>

                            <td width="10%">
                                {{ date("H:i:s",strtotime($value['time_in'])) }}
                            </td>
                            <td width="10%">
                                {{ date("H:i:s",strtotime($value['time_out'])) }}
                            </td>
                            <td width="10%">
                                {{ $value['type_room'] }}
                            </td>
                            <td width="10%">
                                {{ $value['total_duration_rest'] }}
                            </td>
                            <td width="10%">
                                {{ date("d/m/Y",strtotime($value['date'])) }}
                            </td>
                        </tr>
                        @endforeach()
                    @else
                    @endif()

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection