<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'My Karaj') }}</title>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito"
	rel="stylesheet" type="text/css">

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link rel="stylesheet"
	href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
	integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf"
	crossorigin="anonymous">

</head>
<body>
	<div id="app">
		<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
			<div class="container">
				<a class="navbar-brand" href="{{ url('/') }}"> {{ config('app.name',
					'My Karaj') }} </a>
				<button class="navbar-toggler" type="button" data-toggle="collapse"
					data-target="#navbarSupportedContent"
					aria-controls="navbarSupportedContent" aria-expanded="false"
					aria-label="{{ __('Toggle navigation') }}">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<!-- Left Side Of Navbar -->
					<ul class="navbar-nav mr-auto">

					</ul>

					<!-- Right Side Of Navbar -->
					<ul class="navbar-nav ml-auto">
						<!-- Authentication Links -->
						@guest
						<li class="nav-item"><a class="nav-link"
							href="{{ route('login') }}">{{ __('Login') }}</a></li> @else
						<li class="nav-item dropdown"><a id="navbarDropdown"
							class="nav-link dropdown-toggle" href="#" role="button"
							data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
							v-pre> {{ Auth::user()->name }} <span class="caret"></span>
						</a>

							<div class="dropdown-menu dropdown-menu-right"
								aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href=""> <i class="fas fa-fingerprint"></i>
									Change password
								</a> <a class="dropdown-item" href="{{ route('logout') }}"
									onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
									<i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
								</a>
								<form id="logout-form" action="{{ route('logout') }}"
									method="POST" style="display: none;">@csrf</form>
							</div></li> @endguest
					</ul>
				</div>
			</div>
		</nav>

		<main class="py-4">
		<div class="container">
			<div class="row">
				<div class="col-3">
					<div class="wrapper">
						<!-- Sidebar -->
						@if(Auth::check())
						<nav id="sidebar">
							<div class="sidebar-header">
								<h3 class="hidden-xs hidden-sm">Main Menu</h3>
							</div>
							<ul class="list-unstyled components">
								<li><a href="{{url('home')}}"><i class="fas fa-tachometer-alt"></i>
										Dashboard</a></li>
								<li><a href="{{url('setting')}}"><i class="fas fa-cogs"></i>
										Setting</a></li>
								<li><a href="#UserMenu" data-toggle="collapse"
									aria-expanded="false" class="dropdown-toggle"> <i
										class="fas fa-user-circle"></i> Users
								</a>
									<ul
										class="collapse list-unstyled {{Request::is('*user*')?'show':''}}"
										id="UserMenu">
										<li><a href="{{url('users')}}"><i class="fas fa-user"></i>
												View Users</a></li>
										<li><a href="{{url('user-form')}}"><i class="fas fa-user-plus"></i>
												Add User</a></li>
									</ul></li>
								<li><a href="#CategoryMenu" data-toggle="collapse"
									aria-expanded="false" class="dropdown-toggle"><i
										class="fas fa-box-open"></i> Categories</a>
									<ul
										class="collapse list-unstyled {{Request::is('*cat*')||Request::is('*sub*')?'show':''}}"
										id="CategoryMenu">
										<li><a href="{{url('cat-main')}}"><i class="fas fa-box"></i>
												View Categories</a></li>
										<li><a href="{{url('cat-form')}}"><i
												class="fas fa-plus-circle"></i> Add Category</a></li>
										<li><a href="{{url('sub-main')}}"><i class="fas fa-boxes"></i>
												View SubCategories</a></li>
										<li><a href="{{url('sub-form')}}"><i
												class="fas fa-plus-circle"></i> Add SubCategory</a></li>
									</ul></li>
                                <li><a href="#modelMenu" data-toggle="collapse"
                                       aria-expanded="false" class="dropdown-toggle"><i class="fas fa-hotel"></i> Brands</a>
                                    <ul
                                        class="collapse list-unstyled {{Request::is('*model*')?'show':''}}"
                                        id="modelMenu">
                                        <li><a href="{{url('brand-create')}}"><i class="fas fa-plus-square"></i>
                                               Add Brand</a></li>
                                        <li><a href="{{url('brand')}}"><i class="fas fa-eye"></i>
                                                View Brands
                                            </a></li>
                                    </ul></li>
								<li><a href="#customerSubmenu" data-toggle="collapse"
									aria-expanded="false" class="dropdown-toggle"><i
										class="fas fa-users"></i> Customers</a>
									<ul
										class="collapse list-unstyled {{Request::is('*customer*')?'show':''}}"
										id="customerSubmenu">
										<li><a href="{{url('')}}"><i class="fas fa-user-tie"></i> Car
												Owner</a></li>
										<li><a href="{{url('')}}"><i class="fas fa-user-nurse"></i>
												Karaj Owner</a></li>
									</ul></li>
								<li><a href="#workshopSubmenu" data-toggle="collapse"
									aria-expanded="false" class="dropdown-toggle"><i
										class="fas fa-car-crash"></i> Workshop</a>
									<ul
										class="collapse list-unstyled {{Request::is('*workshop*')?'show':''}}"
										id="workshopSubmenu">
										<li><a href="{{url('workshop-list')}}"><i class="fas fa-tools"></i>
												View Workshop</a></li>
										<li><a href="{{url('workshop-form')}}"><i
												class="fas fa-plus-circle"></i> Add Workshop</a></li>
									</ul></li>
								<li><a href="#commentsSubmenu" data-toggle="collapse"
									aria-expanded="false" class="dropdown-toggle"><i
										class="fas fa-comment"></i> Comments</a>
									<ul
										class="collapse list-unstyled {{Request::is('*comment*')?'show':''}}"
										id="commentsSubmenu">
										<li><a href="#"><i class="fas fa-comments"></i> Customer
												Comments</a></li>
										<li><a href="#"><i class="fas fa-comments"></i> Workshop
												Comments </a></li>
									</ul></li>
								<li><a href="#CarsSubmenu" data-toggle="collapse"
									aria-expanded="false" class="dropdown-toggle"><i
										class="fas fa-car"></i> Cars</a>
									<ul
										class="collapse list-unstyled {{Request::is('*car*')?'show':''}}"
										id="CarsSubmenu">
										<li><a href="#"><i class="fas fa-car-side"></i> View Cars</a>
										</li>
										<li><a href="#"><i class="fas fa-calendar-alt"></i> Booking</a>
										</li>
									</ul></li>
								<li><a href="#"><i class="fas fa-envelope-open-text"></i> Send
										Message</a></li>
							</ul>
						</nav>
						@endif
					</div>
				</div>
				<div class="col-9">
					<div class="card">@yield('content')</div>
				</div>
			</div>
		</div>
		</main>

	</div>
</body>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script
	src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}
        &callback=initMap"
	async defer></script>


<script>

    (function () {
        'use strict';
        window.addEventListener('load', function () {
// Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $(document).ready(function () {

        $("#form").submit(function (submitEvent) {
            if ($("#image").val() != '') {
                var filename = $("#image").val();
                var extension = filename.replace(/^.*\./, '');
                if (extension == filename) {
                    extension = '';
                } else {
                    extension = extension.toLowerCase();
                }
                if (extension == 'jpg'
                    || extension == 'jpeg'
                    || extension == 'png') {
                    $("#form").submit();
                } else {
                    alert('Only image files');
                    $("#image").val('');
                    submitEvent.preventDefault();
                }
            }
        });
    });
</script>
</html>
