@extends('employees.home.app')

@section('topnav')
<header class="dash-toolbar">


    <div class="main-label">
       Home
    </div>
    <div class="tools">
        @include('notification')

        <div class="dropdown tools-item">
            <span id="profile_username">
                Njeeb Shbib
            </span>
            <i><img id="profile_pic" src="{{asset('images/profile.png')}}" style="width:32px; height:32px; " alt="profile"></i>
            <a href="#" class="" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i><img src="{{asset('icons/profile_menu.svg')}}" alt="profile"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                <a class="dropdown-item" href="#!">Change profile pic</a>
                <center><hr style="width: 140px; padding: 0;margin: 0;"></center>
                <a class="dropdown-item" href="login.html">Logout</a>
            </div>

        </div>
    </div>
</header>
@endsection
@section('main')
				<div id="finish">
					<p class="p1">Attendance</p>
					<p class="p2">You Are In Since 9:00 AM</p>
					<div class="finished-circle">
						<i><img src="../../icons/fEllipse 18.svg"/>  </i>
					</div>
					<div class="finished-circle2">
						<i><img src="../../icons/fEllipse 19.svg"/>  </i><span id="finishedText">I'm Finished</span>
					</div>
				</div>
                <div class="current-projects">
                    <span id="pcurrent">Current Projects You Are In</span>

                    <table class="pro-table" style="width:100%">
                        <thead>
                            <th width="303px">Project Name</th>
                            <th width="277px">Timeline</th>
                            <th width="186px">Working Hours</th>
                            <th width="168px">Backup Hours</th>
                            <th width="144px"></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td > <i class="project_name"><img src="../../images/company_logo_client.svg" /></i> <a href="" class="project_text">Box To Go Team</a></td>
                                <td>
                                    <span class="prog_startdate">20/3/22</span> <span class="prog_enddate">20/3/22</span>
                                    <center>
                                    <div class="progress" style="height: 6.34px; border-radius: 5px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 50% ;border-radius: 5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div> </center>
                                </td>
                                <td class="text-danger">15/300</td>
                                <td class="text-success">0/20</td>
                                <td><button class="create-btn"><span class="create-btn-text"><i class="create-isquare"><img src="../../icons/sqare.svg"/></i><i class="create-iok"> <img src="../../icons/ok.svg"/></i> Create Task</span></button></td>
                            </tr>
                            <tr>
                                <td><i class="project_name"><img src="../../images/company_logo_client.svg" /></i> <a href="" class="project_text">VRoad Team</a></td>
                                <td>
                                    <span class="prog_startdate">20/3/22</span> <span class="prog_enddate">20/3/22</span>
                                    <center>
                                    <div class="progress" style="height: 6.34px; border-radius: 5px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 50% ;border-radius: 5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div> </center>
                                </td>
                                <td class="text-success">15/300</td>
                                <td class="text-warning">0/20</td>
                                <td><button class="create-btn"><span class="create-btn-text"><i class="create-isquare"><img src="../../icons/sqare.svg"/></i><i class="create-iok"> <img src="../../icons/ok.svg"/></i> Create Task</span></button></td>
                            </tr>
                            <tr>
                                <td><i class="project_name"><img src="../../images/company_logo_client.svg" /></i> <a href="" class="project_text">CRM</a></td>
                                <td>
                                    <span class="prog_startdate">20/3/22</span> <span class="prog_enddate">20/3/22</span>
                                    <center>
                                    <div class="progress" style="height: 6.34px; border-radius: 5px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 35% ;border-radius: 5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div> </center>
                                </td>
                                <td class="text-warning">15/300</td>
                                <td class="text-danger">0/20</td>
                                <td><button class="create-btn"><span class="create-btn-text"><i class="create-isquare"><img src="../../icons/sqare.svg"/></i><i class="create-iok"> <img src="../../icons/ok.svg"/></i> Create Task</span></button></td>
                            </tr>
                            <tr>
                                <td><i class="project_name"><img src="../../images/company_logo_client.svg" /></i> <a href="" class="project_text">GPS</a></td>
                                <td>
                                    <span class="prog_startdate">20/3/22</span> <span class="prog_enddate">20/3/22</span>
                                    <center>
                                    <div class="progress" style="height: 6.34px; border-radius: 5px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 80% ;border-radius: 5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div> </center>
                                </td>
                                <td>15/300</td>
                                <td>0/20</td>
                                <td><button class="create-btn"><span class="create-btn-text"><i class="create-isquare"><img src="../../icons/sqare.svg"/></i><i class="create-iok"> <img src="../../icons/ok.svg"/></i> Create Task</span></button></td>
                            </tr>
                            <tr>
                                <td><i class="project_name"><img src="../../images/company_logo_client.svg" /></i> <a href="" class="project_text">finance</a></td>
                                <td>
                                    <span class="prog_startdate">20/3/22</span> <span class="prog_enddate">20/3/22</span>
                                    <center>
                                    <div class="progress" style="height: 6.34px; border-radius: 5px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 65% ;border-radius: 5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div> </center>
                                </td>
                                <td>15/300</td>
                                <td>0/20</td>
                                <td><button class="create-btn"><span class="create-btn-text"><i class="create-isquare"><img src="../../icons/sqare.svg"/></i><i class="create-iok"> <img src="../../icons/ok.svg"/></i> Create Task</span></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
@endsection
