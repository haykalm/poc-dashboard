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
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" cellspacing="0">
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
                        <tr style="vertical-align: middle;text-align: center;font-size: 13px;">
                            <td>{{ $data +1 }}</td>
                            <td>{{ $value['nik'] }}</td>
                            <td style="text-transform: uppercase;">{{ $value['nama'] }}</td>
                            <td>
                                @if($value['departemen']!=null)
                                {{ $value['departemen'] }}
                                @endif()
                            </td>
                            <td>
                                @if($value['no_hp']!=null)
                                {{ $value['no_hp'] }}
                                @endif()
                            </td>
                            <td style="display: flex;justify-content:center;">
                                <a href="#" onClick="show({{ $value->id }})" title="Edit" class="btn btn-warning btn-xs" style="margin-right: 3px"><i class="fa fa-pencil" style="font-size:20px;color:yellow;"></i></a>
                                <form method="POST" action="{{ route('karyawan.destroy', $value->id) }}">
                                    @csrf
                                    <input name="_method" type="hidden" value="DELETE">
                                    <a class="btn btn-danger btn-xs show_confirm" data-toggle="tooltip" title="Delete">
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
          event.preventDefault();
          swal({
              title: `apakah anda yakin ingin menghapus data ini ?`,
              text: "Jika data ini dihapus, maka akan hilang selamanya!",
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
@endpush    
