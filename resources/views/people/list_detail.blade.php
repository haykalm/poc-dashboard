@extends('template.master')

@section('title')
  Detail Absent 
@endsection

@section('content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-gray-500">List Rest Time</h6>
        <button class="btn btn-outline-primary btn-rounded mb-2- py-1 sidebarcuk" style="margin-top: 10px">Menu <-></button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> -->
            <table class="table table-bordered" id="zero-config" width="100%" cellspacing="0">
                <thead> 
                    <tr>
                        <th style="vertical-align: middle;text-align: center;" width="5%">No</th>
                        <th style="vertical-align: middle;text-align: center;" width="7%">NIK</th>
                        <th style="vertical-align: middle;text-align: center;" width="20%">Name</th>
                        <th style="vertical-align: middle;text-align: center;" width="10%">Out</th>
                        <th style="vertical-align: middle;text-align: center;" width="10%">In</th>
                        <th style="vertical-align: middle;text-align: center;" width="10%">Status</th>
                        <th style="vertical-align: middle;text-align: center;" width="10%">Rest Duration</th>
                        <th style="vertical-align: middle;text-align: center;" width="10%">Date</th>
                    </tr>
                </thead>

                <tbody>
                    @if(!empty($response['data']))
                        @foreach($response['data'] as $datail => $value)
                        <tr style="font-size: 13px;">
                            <td style="vertical-align: middle;text-align: center;" width="5%">{{ $datail +1 }}</td>
                            <td style="vertical-align: middle;text-align: center;" width="10%">{{ $value['nik'] }}</td>
                            <td style="vertical-align: middle;text-align: center;text-transform: uppercase;" width="20%">{{ $value['nama'] }}</td>

                            <td style="vertical-align: middle;text-align: center;" width="10%">
                                {{ date("H:i:s",strtotime($value['time_out'])) }}
                            </td>
                            <td style="vertical-align: middle;text-align: center;" width="10%">
                                {{ date("H:i:s",strtotime($value['time_in'])) }}
                            </td>
                            <td style="vertical-align: middle;text-align: center;" width="10%">
                                {{ $value['type_room'] }}
                            </td>
                            <td style="vertical-align: middle;text-align: center;" width="10%">
                                {{ $value['total_duration_rest'] }}
                            </td>
                            <td style="vertical-align: middle;text-align: center;" width="10%">
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