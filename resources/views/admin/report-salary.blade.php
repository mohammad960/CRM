@extends('admin.home.app')

@section('topnav')
<style>
    .dataTables_paginate{

        position: absolute;
        bottom:-50px;
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
    #report_tbl1_length{
        position: absolute;
        bottom:-50px;
        font-family: 'Cairo';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height:18px;
        margin-left:2%;
        color: #12171B;
    }
    #report_tbl1_info{
        display: none;
    }
    #report_tbl1_filter{
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
    table tr td{
    margin-top:5px;
    padding-top:5px;
    font-size:14px;
    }
    #select_time{
        position: relative;
        float:right;
        top: -20px;
        /*left:80%;*/

    }

    @media (max-width: 750px) {
        #report_tbl1{
            margin-top:10% !important;
        }
        #select_time{
            left:75%;
        }
    }
    @media (max-width: 500px) {
        #report_tbl1{
            margin-top:20% !important;
        }
         #select_time{
            left:60%;
            top: 0px;
        }
    }
     @media (max-width: 300px) {
        #report_tbl1{
            margin-top:40% !important;
        }
         #select_time{
            left:50%;
            top: 0px;
        }
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



                <p class="text-14" style="font-size: 20px;letter-spacing: 0.125em; color: #051626; position:relative; margin-top:20px">
                    Salaries Reports
                    <!--{{$c->us_value}}$ = {{$c->sp_value}} SP !-->
                </p>
                <div id="select_time">
                    <i> <img src="{{ asset('icons/calendar.svg') }}"></i>
                    <input type="month" id="today" name="today" >
                    <i style="margin-left:-20px"> <img width="8px" height="8px" src="{{ asset('icons/down.svg') }}"></i>
                </div>
                <div class="tltbl" style="margin-bottom:60px">
                    <table class="tl-table" id="report_tbl1" style="width:100%;margin-top:5%; margin-left:1%;">
                        <thead style="width: 1078px; height: 40px;">
                            <th style="width:30px"></th>
                            <th style="width:300px; font-size:12px"> <i><img class="" src="{{ asset('icons/cone.svg') }}" style="margin-right:3%" alt=""></i> Employee Name</th>
                            <th style="width:190px">Completed hours</th>
                            <th width="134px">Overtime Hours</th>
                            <th style="width:200px">accepted overtime hours</th>
                            <th style="width:140px">Bonus/deduction</th>
                            <th style="width:180px">Salary</th>
                            <th width="84px">Status</th>
                        </thead>
                        <tbody>
						@foreach($salaries as $s )
                       	    <tr>
                                <td>
                                    @if ($s->image==null)
                                    <img class="" src="/storage/employee/2122136.png" style="" alt="profile"></i>

                                    @else
                                    <img class="" src="/storage/employee/{{$s->image}}" style="" alt="profile"></i>
                                    @endif

                                </td>
                                <td>{{$s->name}}</td>
                                <td>{{$s->hours}} Hour</td>
                                <td>{{$s->over}} Hour</td>
                                <td>{{$s->over_hours}} Hour </td>
                                <td>
                                    <i class="showPassword" style="float:right; "><img src="{{ asset('icons/eye-show.svg') }}" style="width:28px; margin-right:16px; margin-bottom:5px"></i>
                                    <i class="hidePassword" style="float:right; display:none; "><img src="{{ asset('icons/eye-hide.svg') }}" style="width:28px; margin-right:16px; margin-bottom:5px"></i>
                                    <span class="text-14"> {{$s->bonus}} sp  </span>
                                    <span class="" style="display:none;"> **** </span>

                                </td>
                                <td>
                                    <i class="showPassword" style="float:right; "><img src="{{ asset('icons/eye-show.svg') }}" style="width:28px; margin-right:16px; margin-bottom:5px"></i>
                                    <i class="hidePassword" style="float:right; display:none; "><img src="{{ asset('icons/eye-hide.svg') }}" style="width:28px; margin-right:16px; margin-bottom:5px"></i>
                                    <span class="text-14"> {{$s->amount}} sp </span>
                                    <span class="" style="display:none;"> **** </span>

                                </td>
                                <td>{{$s->status}} </td>
                            </tr>
							@endforeach

                        </tbody>
                    </table>


                </div>
<!--
                    <div class="expected" id="expected_cost">
                        <i class="showPassword1" style="float:right; "><img src="{{ asset('icons/eye-show.svg') }}" style="width:28px; margin-right:16px; margin-bottom:5px"></i>
                        <i class="hidePassword1" style="float:right; display:none; "><img src="{{ asset('icons/eye-hide.svg') }}" style="width:28px; margin-right:16px; margin-bottom:5px"></i>
                        <b> Total salaries paid : <span class="text-14"> {{$total_amount}} sp = {{intval($total_dollar)}} $  </span></b>
                        <span class="" style="display:none;"> **** </span>

                    </div>
!-->

<script>
$('input[name=today]').change(function() {

 window.location.replace('/admin/reports/salary?date='+$("#today").val());

});
$(document).ready(function(){

         $("#report_tbl1").DataTable({
          order: [[6, 'asc']],
         initComplete: function () {
            this.api()
                .columns(1)
                .every(function () {
                    var column = this;
                    var select = $('<select class="sort_select" style="width:20%; border:none; background-color:#F1F1F1; margin-left:2px;"><option value=""></option>'
                                 +'</select>'
                    )
                        .appendTo($(column.header()))
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });
                    column
                        .data()
                        .unique()
                        .sort()
                        .each(function (d, j) {
                            select.append("<option value='"+ d +"'>" + d + "</option>");
                        });
                });
            },

        "columns": [
                {"name": "1", "orderable": false},
                {"name": "2", "orderable": false},
                {"name": "3", "orderable": false},
                {"name": "4", "orderable": false},
                {"name": "5", "orderable": false},
                {"name": "6", "orderable": false},
                {"name": "7", "orderable": true},
                {"name": "8", "orderable": true}
              ],

        });
        $('#report_tbl1_length label').html($('#report_tbl1_length label').html().replace("entries", "Entries"));



        const monthControl = document.querySelector('input[type="month"]');
        const date= new Date()
        const month=("0" + (date.getMonth() + 1)).slice(-2)
        const year=date.getFullYear()
        monthControl.value = `${year}-${month}`;
		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		const date_filter = urlParams.get('date');
		if(date_filter){
			monthControl.value=date_filter;
		}

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

        $(".showPassword1").click(function() {
            $(this).toggle();
            $(this).next().toggle();
            $(this).next().next().toggle();
            $(this).next().next().next().toggle();
        });
        $(".hidePassword1").click(function() {
            $(this).toggle();
            $(this).prev().toggle();
            $(this).next().toggle();
            $(this).next().next().toggle();

        });


});
</script>

@endsection
