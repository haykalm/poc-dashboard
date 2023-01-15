<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sb-admin-2') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('sb-admin-2') }}/datatable/datatables.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{ asset('sb-admin-2') }}/datatable/jquery.dataTables.js'; ?>"></script>
    <script type="text/javascript" src="{{ asset('sb-admin-2') }}/datatable/datatables.js'; ?>"></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sb-admin-2') }}/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="icon" type="image" href="https://i.ibb.co/Vq9GcWW/yazaki-logo.jpg">

     <!-- Custom styles for this page -->
    <link href="{{ asset('sb-admin-2') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body id="page-top">
    @include('sweetalert::alert')

    <!-- Page Wrapper -->
    <div id="wrapper">

        @includeIf('template.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @includeIf('template.nav')
                
                <div class="container-fluid">
                    
                    @yield('content')

                </div>

            </div>
            <!-- End of Main Content -->

            @includeIf('template.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="#" onclick="$('#logout-form').submit()">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ url('/logout') }}" method="POST" id="logout-form" style="display: none;">
        @csrf
    </form>

    <script src="{{ asset('sb-admin-2') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('sb-admin-2') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sb-admin-2') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sb-admin-2') }}/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('sb-admin-2') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('sb-admin-2') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('sb-admin-2') }}/js/demo/datatables-demo.js"></script>

    @stack('scripts')
    
</body>
</html>
