@extends('template.master')

@section('title')
list Karyawan
@endsection

@section('content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-gray-500">List Karyawan</h6>
        <a href="#" class="btn btn-outline-primary btn-rounded mb-2- py-1" style="float: right;margin-right: 40px" data-toggle="modal" data-target="#createmodal">+ Add </a>
        <button class="btn btn-outline-primary btn-rounded mb-2- py-1 sidebarcuk" style="margin-top: 10px">Menu <-></button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- <table class="table table-bordered" id="zero-config" cellspacing="0"> -->
            <table class="table table-hover" id="zero-config" cellspacing="0">
                <thead>
                    <tr>
                        <th style="vertical-align: middle;text-align: center;" width="1%">No</th>
                        <th style="vertical-align: middle;text-align: center;" width="5%">NIK</th>
                        <th style="vertical-align: middle;text-align: center;" width="20%">Name</th>
                        <th style="vertical-align: middle;text-align: center;" width="10%">Departemen</th>
                        <th style="vertical-align: middle;text-align: center;" width="10%">Handphone</th>
                        <th style="vertical-align: middle;text-align: center;" width="1%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if(!empty($karyawan))
                        @foreach($karyawan as $data => $value)
                        <tr style="text-align:center;font-size: 13px;">
                            <td style="vertical-align: middle;">{{ $data +1 }}</td>
                            <td style="text-transform: uppercase;vertical-align: middle;">{{ $value['nik'] }}</td>
                            <td style="text-transform: uppercase;vertical-align: middle;">{{ $value['nama'] }}</td>
                            <td style="vertical-align: middle;">
                                @if($value['departemen']!=null)
                                {{ $value['departemen'] }}
                                @endif()
                            </td>
                            <td style="text-transform: uppercase;vertical-align: middle;">
                                @if($value['no_hp']!=null)
                                {{ $value['no_hp'] }}
                                @endif()
                            </td>
                            <td style="display: flex;justify-content:center;">
                                <a href="#" onClick="show({{ $value->id }})" title="Edit" class="btn btn-success btn-xs" style="margin-right: 3px;"><i class="fa fa-pencil" style="font-size:19px;"></i></a>
                                <form method="POST" action="{{ route('karyawan.destroy', $value->id) }}">
                                    @csrf
                                    <input name="_method" type="hidden" value="DELETE">
                                    <a class="btn btn-danger btn-xs show_confirm" data-nama="({{ $value->nama }})" data-toggle="tooltip" title="Delete">
                                        <li type="submit" class="fa fa-trash" ></li>
                                    </a>
                                </form>
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

<!-- create Modal-->
<div class="modal fade" id="createmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to create Employe?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ url('/karyawan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label style="margin-bottom: 0.5px">NIk :</label>
                    <input type="text" id="nik" name="nik" class="form-control mb-2" placeholder="nik ?" required>
                    <label style="margin-bottom: 0.5px">Name :</label>
                    <input type="text" id="nama" name="nama" class="form-control mb-2" placeholder="name ?" required>
                    <label style="margin-bottom: 0.5px">Email :</label>
                    <input type="text" id="email" name="email" class="form-control mb-2" placeholder="email ?">
                    <label style="margin-bottom: 0.5px">Departemen :</label>
                    <input type="text" id="departemen" name="departemen" class="form-control mb-2" placeholder="departemen ?">
                    <label style="margin-bottom: 0.5px">Tgl Lahir :</label>
                    <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control mb-2" placeholder="tgl lahir ?">
                    <label style="margin-bottom: 0.5px">No Hp/Wa :</label>
                    <input type="text" id="no_hp" name="no_hp" class="form-control mb-2" placeholder="handphone ?">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal master to edit and update-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Karyawan</h5>
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="page" class="p-2"></div>
            </div>
        </div>
    </div>
</div>

@endsection 

@push('scripts')
<script>
    $(document).ready(function() {
        $('#content').html(karyawan);
    });

    function show(id) {
        $.get("{{ url('/karyawan') }}/" + id, {}, function(data, status) {
            // $("#exampleModalLabel").html('Edit Karyawan')
            $("#page").html(data);
            $("#exampleModal").modal('show');
        });
    }
    
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">
 
     $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("nama");
          // console.log(event)
          event.preventDefault();
          swal({
              title: `Apakah anda yakin ingin menghapus ${name} ?`,
              text: "Jika data ini dihapus, maka akan hilang selamanya! ",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });
  
</script>
<script>
    $(document).ready(function(){
      $(".sidebarcuk").click(function(){
        $("#accordionSidebar").toggle();
    });
  });
</script>

<!-- datatable -->
<link rel="stylesheet" type="text/css" href="{{ asset('sb-admin-2') }}/plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="{{ asset('sb-admin-2') }}/plugins/table/datatable/dt-global_style.css">
<script src="{{ asset('sb-admin-2') }}/plugins/table/datatable/datatables.js"></script>

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
