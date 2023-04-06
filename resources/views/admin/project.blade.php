@extends('admin.home.app')

@section('topnav')
<style>
    .dataTables_paginate{
    display:none !important;
        position: absolute;
        bottom:-40px;
        right: 0;
        font-family: 'Cairo';
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 120%;

        /* identical to box height, or 17px */
        letter-spacing: 0.125em;

        color: #000000;
        display: flex;
        flex-direction: row;
    }
    #emptbl_length{
    display:none;
        position: absolute;
        bottom:-60px;
        font-family: 'Cairo';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height:18px;

        color: #12171B;
    }
    #emptbl_info{
        display: none;
    }
    #emptbl_filter{
        position: absolute;
        top: -60px;
        right: 5px;

    }
    #emptbl_filter input{
        width: 134px;
        height: 32px;
        border-radius: 15px;
        border: 1px solid #CBD4DB;
        padding-left: 33px;
        color : #051626;
        font-family: Cairo;
        font-size: 12px;
        font-weight: 400;
        line-height: 16px;
        letter-spacing: 0px;
        text-align: left;
    }
    #emptbl_filter label{
        color: white;
    }
    #filter_icon{
        position: absolute;
        border-radius: 15px;
        left: 33px;
        top: 26px;
    }
    .paginate_button{
            width: 30px;
            height: 30px;
            border-radius: 50% !important;
            background-color: #C1C1C1;
            padding: .4em .55em .5em .5em !important;
            border: none !important;

    }
    .paginate_button.current{
        background-color: #84C2EF !important;
    }
    #emptbl_next , #emptbl_previous{
        width: 75px;
        background-color: white;
        margin-right: 0px;
        border-radius: 0 !important;
    }
    #emptbl{
    border-bottom:none;
    border-collapse: collapse;
    }
    .task-list table thead th{
    position: sticky !important;
    top: 0px !important;
    z-index:100;

    }
    .task-list {
        height: 330px;
        overflow-y:auto;
    }

    @media (max-width: 800px){
        .collegues{
            margin-top:10%;
        }
        .main-label{
            margin-top:5%;
        }
    }
    @media (max-width: 640px){
         #emptbl_filter{
            margin-top:-1%;
        }
        .duedate-progress{
              left: 70px;
        }
    }
    </style>
<header class="dash-toolbar">

    <div class="main-label" >
	{{$project->project_name}}
       <div class="duedate-progress">
        <div class="progress" style="height: 6.34px; border-radius: 5px; width: 177px;">
            <div class="progress-bar bg-{{$project->style}}" role="progressbar" style="width: {{$project->timeline}}% ;border-radius: 5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>

        </div>
        <span class="duedatelabel">
            Due Date {{$project->end_date}}
        </span>
        <span style="margin-left:10%;" class="duedatelabel">
            Hour Not used : {{$project->work_hours}}/<span id="project_expected_hours">{{$project->expected_hours}} </span>
        </span>
       </div>
    </div>
    <div class="tools">
   @include('notification')
	@include('admin.home.header')
    </div>
</header>
@endsection
@section('main')

                <div class="collegues">
				@foreach ($project->employee_details as $p)
                    <i><img class="" src="/storage/employee/{{$p->image}}" style="width:24px; height:24px; " alt="profile"></i>

				@endforeach
                    <a href="#" id="assign" class="assign">
                     <!--  <i><img class="" src="{{ asset('icons/plus.svg')}}" style="width:10px; height:10px; " alt="profile"></i> Assign Employee
                    -->
					</a>
                </div>
                <div>

                </div>

                <div class="tltbl" >
                    <table class="tl-table" id="emptbl" style="margin-top:6%; margin-left:1%;">
                        <thead style="width: 1078px; height: 40px;">
                            <th width="446px">Employee Name</th>
                            <th style="width:300px">Timeline</th>
                            <th width="174px">Working Hours</th>
                            <th width="185px">Backup Hours</th>

                        </thead>
                        <tbody ID="mytbody">
                       	@foreach ($project->employee_details as $p)
						<tr>
                                <td>
                                    <i><img class="" src="/storage/employee/{{$p->image}}" style="" alt="profile"></i>
                                    <span class="td_empname"> {{$p->first_name}} {{$p->last_name}}</span>
                                </td>
                                <td>
                                     <span style="" class="empprog_enddate" >{{$p->work_hours}}/{{$p->expected_hours}}</span>
                                    <center>
                                    <div class="progress empprogress" style="width:100%; height: 6.34px; border-radius: 5px;">
                                        <div class="progress-bar bg-{{$p->style}}" role="progressbar" style="width: {{$p->timeline}}% ;border-radius: 5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div> </center>
                                </td>
                                <td><span class="tl-text">{{$p->work_hours}}/{{$p->expected_hours}}</span></td>
                                <td><span class="tl-text">{{$p->back_work_hours}}/{{$p->backup_hours}}</span></td>

							</tr>
                           	@endforeach
                        </tbody>
                    </table>
                </div>
                <div class="task-list">

                    <table class="tasks-table" id="tsktbl" style="width: 100%;">
                        <thead  style="width: 100%; height: 40px;">
                            <tr>
                            <th width="453px">List of Tasks</th>
                            <th width="220px">All Employee</th>
                            <th width="120px">Start Date</th>
                            <th width="122px">End Date</th>
                            <th width="96px">Start Time</th>
                            <th width="108px">End Time</th>
							 <th width="174px">Hours</th>
                        </tr>
                        <tr style="height: 16px;"></tr>
                        </thead>
                        <tbody >
						@foreach ($project->tasks as $t)
                            <tr>
                                <td>
								{{$t->description}}
                                </td>
                                <td>
                                    <i><img class='' src="/storage/employee/{{$t->employee_image}}" style='' alt='profile'></i><span class='td_empname'> {{$t->employee_name}} </span>
                                </td>
                                 <td>
								{{explode(" ",$t->start_date)[0]}}
                                </td>

                                <td>
								@if($t->end_date)
                                   {{explode(" ",$t->end_date)[0]}}
							    @endif
                                </td>

                                <td>
                                   {{explode(" ",$t->start_date)[1]}}
                                </td>
                                <td>
								@if($t->end_date)
									{{explode(" ",$t->end_date)[1]}}
								@endif
                                </td>
							  <td>
							   <?php
							   echo intval(($t->hours/60)).' H :'.($t->hours%60)." m"
							   ?>
							   </td>
                            </tr>


						@endforeach
                        </tbody>
                    </table>
                </div>
				<span id="project_id" hidden>{{$project->id}}</span>
				  <span id="myprice" hidden>0</span>
  <span id="spvalue" hidden>0</span>
				@include('assignEModal')
                @include('employeeHoursModalUpdate')
<script>
$(document).ready(function(){
        $("#emptbl").DataTable();

        $("#emptbl_filter label").append("<i id='filter_icon'><img src='"+"{{asset('icons/search_icon.svg')}}" +"' style='width:17px; height:17px; ' alt=''></i>");
        $("#emptbl_filter input").attr("placeholder", "Search");


        $("#emptbl_length label").append( " of " + $("#emptbl").DataTable().column( 0 ).data().length );
        $("#clientsnum").html($("#emptbl").DataTable().column( 0 ).data().length);


});
	 var modal1 = document.getElementById("assignEModal");
     var modal2 = document.getElementById("employeeHModal");
    // Get the button that opens the modal
    var btn = document.getElementById("assign");

    // Get the <span> element that closes the modal
    //var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
	const employees=[];
   const hours=[];
   const back=[];
    btn.onclick = function() {
    modal1.style.display = "block";
    }
    function EHM(id,image,first,last,price,position){

		document.getElementById("emp_id").innerHTML=id;
		document.getElementById("all_name").innerHTML=first+" "+last;
		document.getElementById("position_all").innerHTML="("+position+")";
		//document.getElementById("myprice").innerHTML=price;

		document.getElementById("img_all").src="/storage/employee/"+image;
		    modal2.style.display = "block";
    }

    window.onclick = function(event) {
        if (event.target == modal1) {
            modal1.style.display = "none";
        }
        if(event.target == modal2){
            modal2.style.display = "none";
        }
    }
</script>

@endsection
