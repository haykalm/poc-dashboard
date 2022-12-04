@extends('template.body')
<style>
    .button {
        background-color: #4CAF50;
        border-radius: 5px;
        margin-top: 30px;
    }

    select {
        width: 100% !important;
        height: 30px;
        /* border-color: transparent; */
    }
</style>
@section('title')
dashboard
@endsection

@section('content')
@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <h2 class="" style="color:blue"><b>TAP ROOM A</b></h2>
                    <form method="POST" action="{{ url('api/people') }}">
                        @csrf
                        <table>
                            <tr>
                                <td>
                                    <label for="" style="color:transparent">Standard Select</label>
                                    <select name="nik" required>
                                        @foreach($get as $data)
                                        <option value="{{$data['nik']}}">{{$data['nama']}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="post" value="1">
                                </td>
                                <td>
                                    <button class="button" type="submit">
                                        TAP
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <h2 class="" style="color:blue"><b>TAP ROOM B</b></h2>
                    <form method="POST" action="{{ url('api/people/taping_b') }}">
                        @csrf
                        <table>
                            <tr>
                                
                                <td>
                                    <label for="" style="color:transparent">Standard Select</label>
                                    <select name="nik" required>
                                        @foreach($get as $data)
                                        <option value="{{$data['nik']}}">{{$data['nama']}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="post" value="1">
                                </td>
                                <td>
                                    <button class="button" type="submit">
                                        TAP
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <h2 class="" style="color:blue"><b>TAP ROOM C</b></h2>
                    <form method="POST" action="{{ url('api/people/taping_c') }}">
                        @csrf
                        <table>
                            <tr>
                                <td>
                                    <label for="" style="color:transparent">Standard Select</label>
                                    <select name="nik" required>
                                        @foreach($get as $data)
                                        <option value="{{$data['nik']}}">{{$data['nama']}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="post" value="1">
                                </td>
                                <td>
                                    <button class="button" type="submit">
                                        TAP
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection