@extends('template.body')
<style>
    .button {
        background-color: #4CAF50;
        border-radius: 5px;
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
                        <div class="group">
                            <input type="text" required name="nik" placeholder="NIK">
                            <input type="hidden" name="post" value="1">
                            <button class="button" type="submit">
                                TAP
                            </button>
                        </div>

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
                        <div class="group">
                            <input type="text" required name="nik" placeholder="NIK">
                            <input type="hidden" name="post" value="1">
                            <button class="button" type="submit">
                                TAP
                            </button>
                        </div>

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
                        <div class="group">
                            <input type="text" required name="nik" placeholder="NIK">
                            <input type="hidden" name="post" value="1">
                        <button class="button" type="submit">
                            TAP
                        </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection