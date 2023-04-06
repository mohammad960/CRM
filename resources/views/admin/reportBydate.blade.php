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
    display:none;
        position: absolute;
        top: -50px;
        right: 5px;

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
    .dash-app{
        overflow-y:scroll;
        width:100%;
    }
    .dash-toolbar{
        padding-top:10px;
    }
    </style>
<header class="dash-toolbar">
    
    <div class="main-label">
        <button class="btn-print" > 
            <i><img src="{{asset('icons/print2.svg')}}" style="width:17.5px; height:15px;"/></i> Print
        </button>
    </div>
    <div class="tools">
   @include('notification')
	@include('admin.home.header')
    </div>
</header>
@endsection
@section('main')
                
                <div id="info_container">
                    <div id="info_img">
                        <img src="/storage/quotation/{{$project->image}}" style=""/>
                        <div id="project_name">
						{{$project->project_name}}
                            <div id="project_status-{{$project->style_win}}">
							{{$project->win}} Project
                            </div>
                        </div>
                        
                    </div>
                    <div id="info_details">
                        <table>
                            <thead id="titles">
                                <th style="width:70px">
                                    Client
                                </th>
                                <th style="width:70px"> 
                                    Start Date
                                </th>
                                <th style="width:70px">
                                    Due Date
                                </th>
                                <th style="width:70px">
                                    Price
                                </th>
                                <th style="width:70px">
                                    Status
                                </th>
                            </thead>

                            <tr id="info">
                                <td>
                                    {{$project->client}}
                                </td>
                                <td>
                                  {{$project->start_date}}
                                </td>
                                <td>
                                   {{$project->end_date}}
                                </td>
                                <td>
                                    <i class="showPassword" style="float:right; transform:translate(-45px,-2px)"><img src="{{ asset('icons/eye-show.svg') }}"></i>
                                    <i class="hidePassword" style="float:right; display:none; transform:translate(-45px,-2px)"><img src="{{ asset('icons/eye-hide.svg') }}" style=""></i>
                                    <span class="text-14">  {{$project->price}} $ </span>
                                    <span class="" style="display:none;"> **** </span>
                                    

                                </td>
                                <td>
                                     {{$project->status}}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
				@if($type==1 || $type==0)
                <p class="text-bold-14" style="letter-spacing: 0.125em; color: #051626; position:relative"> INFO </p>
                <div class="tltbl" style="margin-bottom:24px">
                    <table class="tl-table" id="report_tbl1" style="width:100%;margin-top:5%; margin-left:1%;">
                        <thead style="width: 1078px; height: 40px;">
                            <th width="206px">Status From Date</th>
                            <th width="200px">Status To Date</th>
                            <th width="260px">Expected Hours</th>
                            <th width="260px">Admin Hours</th>
                            <th width="148px">Unused Hours</th>
                        </thead>
                        <tbody>
                       	    <tr>
                                <td> {{$project->start}}</td>
                                <td>    {{$project->end}}</td>
                                <td>  {{$project->hours_minute}}/  {{$project->expected_hours+$project->backup_hours}}</td>
                                <td>{{$project->hours_minute}}/  {{$project->admin_hours}}</td>
                                <td class="text-{{$project->style}}">{{$project->hours_minute_un}} Hour</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="tl-table" id="report_tbl2" style="width:100%;margin-top:24px; margin-left:1%;">
                        <thead style="width: 1078px; height: 40px;">
                            <th width="491px">Employee Name</th>
                            <th width="276px">Timeline</th>
                            <th width="164px">Working Hours</th>
                            <th width="144px">Backup Hours</th>
                        </thead>
                        <tbody>
                            @foreach($employees as $e)
                       	    <tr>
                                <td><img src="/storage/employee/{{$e->image}}" style=""/> {{$e->name}}</td>
                                <td>
                                    <div class="progress" style="height: 6.34px; border-radius: 5px; width: 256px;">
                                        <div class="progress-bar bg-{{$e->style}} " role="progressbar" style="width:{{$e->timeline }}% ;border-radius: 5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="text-{{$e->style}}">{{$e->hours}}/{{$e->expected_hours}}</td>
                                <td class="text-success">{{$e->back}}/{{$e->backup_hours}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
				@endif
			@if($type==2 || $type==0)
                <p class="text-bold-14" style="letter-spacing: 0.125em; color: #051626;"> employees Salaries </p>
	
                <div class="tltbl">
                    <table class="tl-table" id="report_tbl3" style="width:100%;margin-top:5%; margin-left:1%;">
                            <thead style="width: 1078px; height: 40px;">
                                <th width="368px">Assigned Employees</th>
                                <th width="163px">Expected Hours</th>
                    
                                <th width="132px">Salary</th>
                            </thead>
                            <tbody>
                                @foreach($employees as $e)
                                    <tr>
                                        <td><img src="/storage/employee/{{$e->image}}" style=""/> {{$e->name}} </td>
                                        <td>{{$e->expected_hours}} Hours</td>
                             
                                        <td>{{$e->salary}} s.p</td>
                                    </tr>
                                 @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="expected" id="expected_cost">
                       <b> Total salaries paid : {{$project->all_salary}} s.p = {{intval($project->all_salary/$currencies[0]->sp_value)}} $ </b>
                    </div>
                    <div class="expected box-{{$project->win}}" >
                       <b> Amount {{$project->win}} : {{$project->price_us_win}} $ </b>
                    </div>
				@endif
                
<script>
$(document).ready(function(){
        
        $(".showPassword").click(function() {
            $(this).toggle();
            $(this).next("td i").toggle();
            $(this).next().next().toggle();
            $(this).next().next().next().toggle();
        });
        $(".hidePassword").click(function() {
            $(this).toggle();
            $(this).prev("td i").toggle();
            $(this).next().toggle();
            $(this).next().next().toggle();

        });


});
</script>

@endsection
