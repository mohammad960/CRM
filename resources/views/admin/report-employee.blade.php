@extends('admin.home.app')

@section('topnav')
<style>
    .dataTables_paginate{
    /*display:none !important;*/
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
    #report_tbl1_length{
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
    .search_grid input{
        width: 234px;
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
    .search_grid label{
        color: white;
        float:right;
        margin-right:5%;
    }
    #filter_icon{
        position: relative;
        left: -85%;
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
    #report_tbl1_filter{
        display:none;
    }
    .dash-app{
        overflow-y:scroll;
        width:100%;
    }
    table tr td{
    margin-top:5px;
    padding-top:5px;
    }
    .hidden{
        display:none;
    }
    .rotate{
        transform:rotate(90deg);
    }
    .last img{
        float:right;
        margin-right:20px;
        margin-top:4px;
    }
     .calendar{
        position:relative;
        top:30px;
        left: 85%;
        z-index:10;
    }
    .calendar2{
        position:relative;
        top:30px;
        left: 92%;
        z-index:10;
    }
    .main_section{
        display:flex;
        flex-direction: column;
    }
    .main_section div.tltbl{
        margin-top:5%;
    }
    .main_section .tltbl .dataTables_filter{
        margin-top:-5%;
    }
    #report_tbl1{
        margin-top:5% !important;
    }
    @media (max-width: 560px){
        #filter_icon {
        position: absolute;
        left: 63.5%;
        top: 31.5%;
        }
        .date-from-to{
            margin-bottom:15%;
        }
    }
    .date-from-to{
        margin-bottom:8%;
    }
    @media (max-width: 950px) {
        #report_tbl1{
            margin-top:10% !important;
        }
    }
    @media (max-width: 640px) {
        #report_tbl1{
            margin-top:15% !important;
        }
    }
    @media (max-width: 450px) {
        #report_tbl1{
            margin-top:25% !important;
        }
    }
    </style>
<header class="dash-toolbar">

    <div class="main-label">
        <button class="btn-Report" id="addreport">
            <i><img src="{{asset('icons/setproject2.svg')}}" style="width:16px; height:20px;margin-right:4px;"/></i> Create New Reports
        </button>
    </div>
    <div class="tools">
   @include('notification')
	@include('admin.home.header')
    </div>
</header>
@endsection
@section('main')



                <div class="modal_inputs" style="padding-top:0; margin-bottom:6%;width:80%; padding-left:0;">

                <div class="date-from-to">

                        <div class="date-from" style="" >
                                <i class="calendar"> <img src="{{ asset('icons/calendar.svg') }}"></i>
                                <div class="form-floating">

                                    <input type="text" class="form-control" name="end_date" id="status_due_date" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                    <label class="date_label" id="fdue_date" for="due_date">{{__('From Date of')}}</label>
                                </div>
                        </div>
                        <div class="text-to" style="">
                            {{__('To')}}
                        </div>
                        <div class="date-to" style="">
                                <i class="calendar"> <img src="{{ asset('icons/calendar.svg') }}"></i>
                                <div class="form-floating">

                                    <input type="text" class="form-control" name="end_date" id="due_date" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                    <label class="date_label" id="fdue_date" for="due_date">{{__('To Date')}}</label>
                                </div>
                        </div>
                        <div class="search_grid">
                            <!--div>
                                <label>
                                    <input type="search" placeholder="Search" >
                                    <i id='filter_icon'><img src="{{asset('icons/search_icon.svg')}}" style='width:17px; height:17px; ' alt=''></i>

                                </label>
                            </div-->
                        </div>
                    </div>


                </div>

                <div class="tltbl" style="margin-bottom:24px">
                    <table class="tl-table" id="report_tbl1" style="width:100%;margin-top:2%; margin-left:1%;">
                        <thead style="width: 1078px; height: 40px;">
                            <th width="285px">Employee Name</th>
                            <th width="140px">Position</th>
                            <th width="148px">Hours Target</th>
                            <th width="148px">Total hours</th>
                            <th width="164px">Overtime Hours</th>
                            <th width="188px">Assigned Projects</th>
                        </thead>
                        <tbody>
						@foreach ($employees as $e)

                       	        <tr class="c{{ $e->id }}">

                                <td>
                                    @if ($e->image==null)
                                    <img class="" src="/storage/employee/2122136.png" style="" alt="profile"></i>

                                    @else
                                    <img class="" src="/storage/employee/{{$e->image}}" style="" alt="profile"></i>
                                    @endif


                                    {{$e->first_name}} {{$e->last_name}}</td>
                                <td>UI/UX Designer</td>
                                <td>{{$e->target_hours}} Hour</td>
                                <td>{{$e->all_excpected}} Hour</td>
                                <td>
                                    {{$e->all_back}} Hour
                                </td>
                                <td class="last">All <img style="" src="{{asset('icons/extend.svg')}}"></td>
                            </tr>
                                    @foreach ($e->projects as $p)
                                        <tr  class="c{{ $e->id }} hidden">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>{{$p->excpected}} Hour</td>
                                            <td>
                                                {{$p->back}} Hour
                                            </td>
                                            <td>{{$p->project_name}}</td>
                                        </tr>

                                    @endforeach
                         	@endforeach
                        </tbody>
                    </table>


                </div>

                @include('EreportModal')


<script>
     $('td.last').on('click', function(){
            //console.log(1);
            var class_name = $(this).parent().attr("class").split(' ')[0];
            $('.'+class_name+'.hidden').insertAfter($(this).parent())
            $('.'+class_name+'.hidden').toggle();
            //$(this).parent().nextUntil(".stop").toggle();
            $(this).find('img').toggleClass( "rotate" )
        });
$(document).ready(function(){

        $("#report_tbl1").DataTable({
             order: [[1, 'desc']],
            columnDefs: [
                            { orderable: false, targets: [0, 5] }
                        ],
             aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            iDisplayLength: 25
        });
        $('#report_tbl1_length label').html($('#report_tbl1_length label').html().replace("entries", "Entries"));


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

        var modal1 = document.getElementById("EreportModal");
        // Get the button that opens the modal
        var btn1 = document.getElementById("addreport");
        // Get the <span> element that closes the modal
        var span1 = document.getElementsByClassName("close")[0];
        // When the user clicks the button, open the modal
        btn1.onclick = function() {
            modal1.style.display = "block";
        }
        // When the user clicks on <span> (x), close the modal
        span1.onclick = function() {
            modal1.style.display = "none";
        }
        // When the user clicks anywhere outside of the modal, close it

        window.onclick = function(event) {
            if(event.target == modal1) {
                modal1.style.display = "none";
            }
        }
});
</script>

@endsection
