<!doctype html>
<html lang="en">

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>

       <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
    
    <script src="{{asset('js/chart-js-config.js')}}"></script>
    <title>Employees Page</title>
	 <meta name="csrf-token" content="{{ csrf_token() }}" />
     <style>
        .main-label{
            left: 28px;
        }
     </style>
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
                <a href="/attendance" class="dash-nav-item">
                   <i><img src="{{asset('icons/Home.svg')}}"/></i> <span>Home</span>  </a>

                <a href="/responsibilities" class="dash-nav-item">
                    <i><img src="{{asset('icons/respons.svg')}}"/></i> <span>Responsibilities </span> </a>



                <div class="Hline"></div>


				@foreach($employee->projects as $p)
					@if($p->status=="In Progress")
					<div class="dash-nav-dropdown @if($pid == $p->id) show @endif">
						<a href="#" class="dash-nav-item dash-nav-dropdown-toggle">
							<i><img src="../../icons/Vector2.svg"/></i> <span class="itemtext">{{$p->project_name}}</span>  </a>
						<div class="dash-nav-dropdown-menu">
						<?php $i=0; $count_project=count($p->employees);?>
								@foreach($p->employees as $e)
								   @if($i<5)
									<?php $i=$i+1;?>
									<a href="/project/tasks/{{$p->id}}" class="dash-nav-dropdown-item"><i><img class="" src="/storage/employee/{{$e->image}}" style="width:24px; height:24px; " alt="profile"></i></a>
									@endif
								@endforeach
							
							<a href="" class="dash-nav-dropdown-item alt_image"><span style="color: #D25B68;">+{{$count_project-$i}}</span></a>
						</div>
					</div>
					@endif
				@endforeach

         
            </nav>
        </div>
        <div class="dash-app">
            @yield('topnav')
<a href="#!" class="menu-toggle-nav-compact">
                    <img width="28px" height="15px" style="" src="{{asset('images/nav-toggle.svg')}}" alt="VRoad"/>
                </a>
            <div class="Hline2"></div>
            <main class="dash-content">
                @yield('main')


            </main>
        </div>
    </div>
  <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script><script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="{{asset('js/spur.js')}}"></script>
</body>

</html>
