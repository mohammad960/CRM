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
    #report_tbl1_next , #report_tbl1_previous{
        width: 75px;
        background-color: white;
        margin-right: 0px;
        border-radius: 0 !important;
    }
    #report_tbl1{
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
	  #report_tbl1_length{
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
    #report_tbl1_info{
        display: none;
    }
    #report_tbl1_filter{
    display:none;


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
    #report_tbl1_next , #emptbl_previous{
        width: 75px;
        background-color: white;
        margin-right: 0px;
        border-radius: 0 !important;
    }
    #report_tbl1{
    border-bottom:none;
    border-collapse: collapse;
    }
    #report_tbl1 tr td{
        font-family: 'Cairo';
        font-style: normal;
        font-weight: 500;
        font-size: 14px;
        line-height: 120%;
        letter-spacing: 0.125em;
        color: #051626;
    }
    #report_tbl3 tr td
    {
        font-family: 'Cairo';
        font-style: normal;
        font-weight: 400;
        font-size: 14px;
        line-height: 120%;
        letter-spacing: 0.125em;
        color: #051626;
    }
      .calendar{
        position:relative;
        top:30px;
        left: 85%;
        z-index:10;
    }
        .main_section{
        display:flex;
        flex-direction: column;
    }
    .main_section div.tltbl{
        margin-top:1%;
    }
    .main_section .tltbl .dataTables_filter{
        margin-top:-5%;
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

    <div class="main-label">
        Annual inventory
    </div>
    <div class="tools">
   @include('notification')
	@include('admin.home.header')
    </div>
</header>
@endsection
@section('main')

                <div>

                <div class="modal_inputs" style="padding-left:0; margin-top:-5%;">
                <div class="date-from-to">

                        <div class="date-from" style="" >
                                <i class="calendar"> <img src="{{ asset('icons/calendar.svg') }}"></i>
                                <div class="form-floating">

                                    <input  type="text"   class="form-control" name="start_date" id="start_date" placeholder="" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                    <label class="date_label" id="fdue_date" for="due_date">{{__('From Date of')}}</label>
                                </div>
                        </div>
                        <div class="text-to" style="">
                            {{__('To')}}
                        </div>
                        <div class="date-to" style="">
                                <i class="calendar"> <img src="{{ asset('icons/calendar.svg') }}"></i>
                                <div class="form-floating">

                                    <input type="text"   class="form-control" name="end_date" id="end_date" placeholder="" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                    <label class="date_label" id="fdue_date" for="due_date">{{__('To Date')}}</label>
                                </div>
                        </div>
                        <div class="search_grid">
                        </div>
                    </div>
                </div>

                <p id="annual_label" style="margin-top:2%;"> Annual inventory 2021/2022 </p>
                <p class="text-bold-14" style="letter-spacing: 0.125em; color: #051626; position:relative"> Projects </p>
                <div class="tltbl" style="margin-bottom:24px">
                    <table class="tl-table" id="report_tbl1" style="width:100%;margin-top:5%; margin-left:1%;">
                        <thead style="width: 1078px; height: 40px;">

                            <th width="140px">Project Name</th>
                            <th width="138px">Client</th>
                            <th width="127px">Start Date</th>
                            <th width="129px">Due Date</th>
                            <th width="134px">Project Hours</th>
                            <th width="134px">Admin Hours</th>
                            <th width="83px">Total Price</th>
                            <th width="119px">Final Status</th>
                        </thead>
                        <tbody>
						@foreach($projects as $p)
                       	    <tr>
                                <td><img src="/storage/quotation/{{$p->image}}" style=""/>
									{{$p->project_name}}</td>
									 <td >{{$p->client}}</td>
                                <td>{{$p->start_date}}</td>
                                <td>{{$p->end_date}}</td>

                                <td>{{$p->expected_hours}} Hour</td>
                                <td>{{$p->admin_hours}} Hour</td>
                                <td>{{$p->price}} </td>
                                <td class="text-success">{{$p->status}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="text-bold-14" style="letter-spacing: 0.125em; color: #051626;"> employees Salaries </p>

                <div class="tltbl">
                    <table class="tl-table" id="emptbl" style="width:100%;margin-top:5%; margin-left:1%;">
                            <thead style="width: 1078px; height: 40px;">
							 <th width="401px">Date</th>
                                <th width="401px">Assigned Employees</th>
                                <th width="170px">Working Hours</th>
                                <th width="222px">accepted Overtime Hours</th>
                                <th width="150px">Bonus/deduction</th>
                                <th width="131px">Salary</th>
                            </thead>
                            <tbody>
                              @foreach ($salaries as $s)
                                    <tr>
									<td>{{$s->date}}</td>
                                        <td><img src="/storage/employee/{{$s->image}} " style=""/> {{$s->name}} </td>
                                        <td>{{$s->hours}}  Hour</td>
                                        <td class="text-danger">{{$s->over_hours}}  Hour</td>
                                        <td>{{$s->bonus}}  s.p</td>
                                        <td>{{$s->amount}}  s.p</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--
                    <div class="expected" id="expected_cost">
                       <b> Total Payments :{{$all_salary}} S.P = {{intval($all_salary/$currency->sp_value)}} $ </b>

                       <b style="float:right;padding-right:10px;"> Total Revenue : {{$all_amount}} $</b>
                    </div>
                    <div class="expected box-{{$style}}">
                       <b> Amount {{$style}} : {{intval($all_amount-($all_salary/$currency->sp_value))}}  $ </b>
                    </div>
!-->
<script>

$(document).ready(function(){
        $("#emptbl").DataTable();

		$('input[name=start_date]').change(function() {

	 window.location.replace('/admin/reports/inventory?start_date='+$("#start_date").val()+"&end_date="+$("#end_date").val());

	});
	$('input[name=end_date]').change(function() {

	 window.location.replace('/admin/reports/inventory?start_date='+$("#start_date").val()+"&end_date="+$("#end_date").val());

	});

		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		const start_date = urlParams.get('start_date');
		const end_date = urlParams.get('end_date');
	   document.getElementById("start_date").value=start_date;
	   document.getElementById("end_date").value=end_date;
        $("#emptbl_filter label").append("<i id='filter_icon'><img src='"+"{{asset('icons/search_icon.svg')}}" +"' style='width:17px; height:17px; ' alt=''></i>");
        $("#emptbl_filter input").attr("placeholder", "Search");


        $("#emptbl_length label").append( " of " + $("#emptbl").DataTable().column( 0 ).data().length );
        $("#clientsnum").html($("#emptbl").DataTable().column( 0 ).data().length);


});
$(document).ready(function(){
        $("#report_tbl1").DataTable();


});
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
