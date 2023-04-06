<!doctype html>
<html lang="en">
<style>
.hide{
  display:none;  
}
</style>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600|Open+Sans:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/spur.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script src="{{asset('js/chart-js-config.js')}}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Admin Page</title>
</head>

<body>
    <div id="overlay">
        <div id="overlay-top" class="vert"></div>
        <div id="overlay-bottom" class="vert"></div>
        <div id="overlay-left" class="hor"></div>
        <div id="overlay-right" class="hor"></div>
    </div>
    <div class="dash">
        <div class="dash-nav dash-nav-dark">
            <header id="header-nav">
                <div class="Vroad-logo-img"><img width="46px" height="24px" src="{{asset('icons/w1.png')}}" alt="VRoad"/></div>
                <a href="#!" class="menu-toggle-nav">
                    <img width="28px" height="15px" src="{{asset('images/nav-toggle.svg')}}" alt="VRoad"/>
                </a>
            </header>
            <nav class="dash-nav-list">
                <a href="/admin/home" class="dash-nav-item @if(\Request::segment(2) == "home") active @endif">
                   <i><img src="{{asset('icons/Home.svg')}}"/></i> <span>Home</span>  </a>

                <a href="/admin/attendance/all" class="dash-nav-item @if(\Request::segment(2) == "attendance") active @endif">
                    <i><img src="{{asset('icons/attendance.svg') }}"/></i> <span>Attendance </span> </a>

                <a href="/admin/salary" class="dash-nav-item @if(\Request::segment(2) == "salary") active @endif">
                    <i><img src="{{asset('icons/salaries.svg')}}"/></i> <span>Salaries </span> </a>

                <a href="/admin/current" class="dash-nav-item @if(\Request::segment(2) == "current") active @endif">
                    <i><img src="{{asset('icons/current.svg')}}"/></i> <span>Current Projects</span>  </a>

                <!--a href="quotation" class="dash-nav-item">
                    <i><img src="{{asset('icons/calculator.svg')}}"/></i> <span>Projects Calculator </span> </a-->

                <div class="dash-nav-dropdown @if(\Request::segment(2) == "quotation") show @endif" style="margin-top:1%; margin-left:-6%;">
                    <a href="#" class="dash-nav-item  dash-nav-dropdown-toggle" id="pcalc">
                        <i><img src="{{asset('icons/calculator.svg')}}"/></i> <span style="margin-right:5%;">Projects Calculator</span>  <img id="pcalc_img" class="@if(\Request::segment(2) == "quotation") rotate @endif" style="margin-left: 16%;" src="{{asset('icons/wextend.svg')}}"> </a>
                    
                    <div class="dash-nav-dropdown-menu" id="dash-nav-dropdown-menu1">
                            <a href="/admin/quotation/create" class="dash-nav-dropdown-item1 @if(\Request::segment(2) == "quotation" && \Request::segment(3) == "create") active @endif">
                            <span>Add New Quotation </span> </a>
                            <a href="/admin/quotation" class="dash-nav-dropdown-item1 @if(\Request::segment(2) == "quotation" && \Request::segment(3) != "create") active @endif">
                            <span>Saved Quotations</span> </a>
                    </div>
                </div>

                <div class="dash-nav-dropdown @if(\Request::segment(2) == "reports") show @endif" style="margin-top:1%; margin-left:-6%;">
                    <a href="#" class="dash-nav-item dash-nav-dropdown-toggle" id="reps">
                        <i><img src="{{asset('icons/reports.svg')}}"/></i> <span style="margin-right:5%;">Reports </span> <img id="reps_img" class="@if(\Request::segment(2) == "reports") rotate @endif" style="margin-left: 56%;" src="{{asset('icons/wextend.svg')}}"> </a>
                    
                    <div class="dash-nav-dropdown-menu" id="dash-nav-dropdown-menu1">
                            <a href="/admin/reports/projects" class="dash-nav-dropdown-item1 @if(\Request::segment(3) == "projects") active @endif">
                            <span> Projects </span> </a>

                            <a href="/admin/reports/employee" class="dash-nav-dropdown-item1 @if(\Request::segment(3) == "employee") active @endif">
                            <span>Employee</span> </a>

                            <a href="/admin/reports/salary" class="dash-nav-dropdown-item1 @if(\Request::segment(3) == "salary") active @endif">
                            <span>Salaries</span> </a>


                            <a href="/admin/reports/inventory" class="dash-nav-dropdown-item1 @if(\Request::segment(3) == "inventory") active @endif">
                            <span>Annual inventory</span> </a>


                    </div>
                </div>

               


                <div class="Hline"></div>

                <a href="/admin/client" class="dash-nav-item @if(\Request::segment(2) == "client") active @endif">
                    <i><img src="{{asset('icons/clients.svg')}}"/></i> <span>Clients</span>  </a>

                 <a href="/admin/project" class="dash-nav-item @if(\Request::segment(2) == "project") active @endif">
                     <i><img src="{{asset('icons/projects.svg')}}"/></i> <span>Projects </span> </a>

                 <a href="/admin/user" class="dash-nav-item @if(\Request::segment(2) == "user") active @endif">
                     <i><img src="{{asset('icons/users.svg')}}"/></i> <span>Users </span> </a>

                 <a href="/admin/department" class="dash-nav-item @if(\Request::segment(2) == "department") active @endif">
                     <i><img src="{{asset('icons/department.svg')}}"/></i> <span>Department</span>  </a>

                 <a href="/admin/position" class="dash-nav-item @if(\Request::segment(2) == "position") active @endif">
                     <i><img src="{{asset('icons/position.svg')}}"/></i> <span>Position </span> </a>

                 <a href="/admin/currency" class="dash-nav-item @if(\Request::segment(2) == "currency") active @endif">
                     <i><img src="{{asset('icons/currency.svg')}}"/></i> <span>Currency </span> </a>

			<div class="Hline"></div>
 
			<a href="/admin/setting" class="dash-nav-item @if(\Request::segment(2) == "setting") active @endif">
                     <i><img src="{{asset('icons/currency.svg')}}"/></i> <span>Setting </span> </a>
		
                <!--div class="dash-nav-dropdown">
                    <a href="#!" class="dash-nav-item dash-nav-dropdown-toggle">
                        <i class="fas fa-info"></i> About </a>
                    <div class="dash-nav-dropdown-menu">
                        <a href="https://github.com/HackerThemes/spur-template" target="_blank" class="dash-nav-dropdown-item">GitHub</a>
                        <a href="http://hackerthemes.com" target="_blank" class="dash-nav-dropdown-item">HackerThemes</a>
                    </div>
                </div-->
            </nav>
        </div>
        <div class="dash-app">
            @yield('topnav')
                <a href="#!" class="menu-toggle-nav-compact">
                    <img width="28px" height="15px" style="" src="{{asset('images/nav-toggledark.svg')}}" alt="VRoad"/>
                </a>
            <div class="Hline2"></div>
            <main class="dash-content">
                @yield('main')


            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="{{asset('js/spur.js')}}"></script>
    <script>

    </script>
</body>

</html>
