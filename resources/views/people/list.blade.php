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
            <table class="table table-bordered" id="dataTable" width="1200px" cellspacing="0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nik</th>
                        <th>Name</th>
                        <th>A in</th>
                        <th>A out</th>
                        <th>B in</th>
                        <th>B out</th>
                        <th>C in</th>
                        <th>C out</th>
                        <th>status in</th>
                        <th>status out</th>
                    </tr>
                </thead>

                <tbody>
                   @foreach($data as $absent => $value)
                   <tr>
                    <td width="5%">{{ $absent +1 }}</td>
                    <td>{{ $value['nik'] }}</td>
                    <td width="25%"><b>{{ $value['nama'] }}</b></td>
                    <td><sup>{{ $value['absen_a_time_in'] }}</sup></td>
                    <td><sup>{{ $value['absen_a_time_out'] }}</sup></td>
                    <td><sup>{{ $value['absen_b_time_in'] }}</sup></td>
                    <td><sup>{{ $value['absen_b_time_out'] }}</sup></td>
                    <td><sup>{{ $value['absen_c_time_in'] }}</sup></td>
                    <td><sup>{{ $value['absen_c_time_out'] }}</sup></td>
                    <td><b>{{ $value['status_tap_in'] }}</b></td>
                    <td><b>{{ $value['status_tap_out'] }}</b></td>
                  </tr>
                @endforeach()
            </tbody>
        </table>
    </div>
</div>
</div>

@endsection
