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
	<link rel="icon" type="image" href="https://i.ibb.co/6NNbp7K/store.png">
</head>
<body>

	@yield('content')

	<!-- Bootstrap core JavaScript-->
	<script src="{{ asset('sb-admin-2') }}/vendor/jquery/jquery.min.js"></script>
	<script src="{{ asset('sb-admin-2') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- Core plugin JavaScript-->
	<script src="{{ asset('sb-admin-2') }}/vendor/jquery-easing/jquery.easing.min.js"></script>
	<!-- Custom scripts for all pages-->
	<script src="{{ asset('sb-admin-2') }}/js/sb-admin-2.min.js"></script>
</body>
</html>