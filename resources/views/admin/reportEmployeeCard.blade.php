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

                <div id="info_container" style="margin-left:20px;">
                    <div id="info_img">
                        <img src="/storage/employee/{{$e->image}}" style=""/>
                        <div id="emp_name_main">
						{{$e->first_name}} {{$e->last_name}}
                            <div id="emp_position">
							{{$e->position}}
                            </div>
                        </div>

                    </div>
                    <div id="info_details" style="margin-left:20px;">
                        <table>
                            <thead id="titles">
                                <th style="width:80px">
                                    Start Working Date
                                </th>
                                <th style="width:75px">
                                    Hours Target
                                </th>
                                <th style="width:80px">
                                    Overtime Hour Price
                                </th>
                                <th style="width:65px">
                                    Hours Cost
                                </th>

                            </thead>

                            <tr id="info">
                                <td>
                                   {{$e->start_job}}
                                </td>
                                <td>
                                    {{$e->target_hours}}
                                </td>
                                <td>
                                    <i class="showPassword" style="float:right; transform:translate(-45px,-2px)"><img src="{{ asset('icons/eye-show.svg') }}"></i>
                                    <i class="hidePassword" style="float:right; display:none; transform:translate(-45px,-2px)"><img src="{{ asset('icons/eye-hide.svg') }}" style=""></i>
                                    <span class="text-14"> {{$e->over_price}} s.p </span>
                                    <span class="" style="display:none;"> **** </span>
                                </td>
                                <td>
                                    <i class="showPassword" style="float:right; transform:translate(-45px,-2px)"><img src="{{ asset('icons/eye-show.svg') }}"></i>
                                    <i class="hidePassword" style="float:right; display:none; transform:translate(-45px,-2px)"><img src="{{ asset('icons/eye-hide.svg') }}" style=""></i>
                                    <span class="text-14"> {{$e->hour_cost}} s.p </span>
                                    <span class="" style="display:none;"> **** </span>


                                </td>

                            </tr>
                        </table>
                    </div>
                    <span id="release_date">Release Date : 2022/1/1</span>
                </div>

                <p class="text-bold-14" style="letter-spacing: 0.125em; color: #051626; position:relative"> INFO </p>
                <div class="tltbl" style="margin-bottom:24px">
                    <table class="tl-table" id="report_tbl1" style="width:100%;margin-top:5%; margin-left:1%;">
                        <thead style="width: 1078px; height: 40px;">
                            <th width="328px">Status From Date</th>
                            <th width="307px">Status To Date</th>
                            <th width="307px">Department</th>
                            <th width="136px">Username</th>
                        </thead>
                        <tbody>
                       	    <tr>
                                <td>{{$e->start_date}}</td>
                                <td>{{$e->end_date}}</td>
                                <td> {{$e->department}}</td>
                                <td> {{$e->username}}</td>
                            </tr>
                        </tbody>
                    </table>
@if($type==1 || $type==0)
                    <p class="text-bold-14" style="letter-spacing: 0.125em; color: #051626; margin-left:12px; margin-top:16px;margin-bottom:-14px;"> Projects </p>

                    <table class="tl-table" id="report_tbl2" style="width:100%;margin-top:24px; margin-left:1%;">
                        <thead style="width: 1078px; height: 40px;">
                            <th width="348px">Assigned Projects</th>
                            <th width="169px">Status</th>
                            <th width="272px">Timeline</th>
                            <th width="140px">Working Hours</th>
                            <th width="145px">Overtime Hours</th>
                        </thead>
                        <tbody>
                            @foreach($e->projects as $p)
                       	    <tr>
                                <td><img src="/storage/quotation/{{$p->image}}" style=""/> {{$p->project_name}}</td>
                                <td><i class="point"><img src="{{ asset('icons/point.svg') }}" ></i>{{$p->status}} </td>
                                <td>
                                    <div class="progress" style="height: 6.34px; border-radius: 5px; width: 256px;">
                                        <div class="progress-bar bg-{{$p->style}}  " role="progressbar" style="width:{{$p->timeline}}% ;border-radius: 5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td class="text-{{$p->work_style}}">{{$p->work}}</td>
                                <td class="text-{{$p->back_style}}">{{$p->over}}</td>
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
                                <th width="174px">Salary Date</th>
                                <th width="176px">Completed Hours</th>

                                <th width="239px">accepted Overtime Hours</th>
                                <th width="197px">Bonus/deduction</th>
                                <th width="120px">Salary</th>
								<th width="120px">State</th>
                            </thead>
                            <tbody>
                                @foreach($salaries as $s)
                                    <tr>
                                        <td> {{$s->date}}</td>
                                        <td> {{intval($s->hours/60)}} H : {{$s->hours%60}} m</td>
                                        <td> {{$s->over_hours}} hours</td>
                                        <td> {{$s->bonus}} s.p</td>
                                        <td> {{$s->amount}} s.p</td>
										<td> {{$s->status}}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="expected" id="expected_cost">
                       <b> Total salaries : {{$e->all_salary}} s.p </b>
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
