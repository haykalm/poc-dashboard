@extends('template.master')

@section('title')
    list people absen
@endsection

@section('content')
 <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-gray-500">List people absen</h6>
                            <div class="col-13 text-right">
                                <a href="#" class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-plus-circle"></i>
                                    </span>
                                    <span class="text">Add</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Number</th>
                                            <th>Name</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    	@foreach($data as $data => $value)
                                    	<tr>
                                    		<td width="4%">{{ $data +1 }}</td>
                                    		<td>{{ $value['name'] }}</td>
                                    		<td>{{ $value['created_at'] }}</td>
                                    		<td>{{ $value['updated_at'] }}</td>
                                    		{{--<td>{{ date("d-M-Y",strtotime($data->created_at))}}</td> --}}
                                    		<td>
                                                <form action="#" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    
                                                    <a href="#" class="btn btn-warning btn-circle btn-sm" title="edit data"><i class="fa fa-edit"></i>
                                                    </a>

                                                    <button class="btn btn-danger btn-circle btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                    	</tr>
                                    	@endforeach()
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

@endsection
