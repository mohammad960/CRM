@extends('admin.home.app')

@section('topnav')
<style>
    .dataTables_paginate{

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

        position: absolute;
        bottom:-60px;
        font-family: 'Cairo';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height:18px;
        margin-left:10px;
        color: #12171B;
    }
    #emptbl_info{
        display: none;
    }
    #emptbl_filter{


    }
    #emptbl_filter input{
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
    #emptbl_filter label{
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
    #emptbl_next , #emptbl_previous{
        width: 75px;
        background-color: white;
        margin-right: 0px;
        border-radius: 0 !important;
    }
    #emptbl_previous{
    padding-right:85px !important;
    }
    #emptbl{
    border-bottom:none;
    border-collapse: collapse;
    }
    input[type="date"]::-webkit-calendar-picker-indicator {
    background: none;
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

    ul.ui-autocomplete {
        z-index: 1100;
        background-color:white;
        width: 20%;
        border: 1px solid black;
        border-radius: 8px;
        list-style-type: none;
        margin:0;
        padding-left:0;
    }
    li.ui-menu-item{
        padding-left:16px;
        border-radius: 8px;
    }
    li.ui-menu-item:hover {
        background-color: rgba(100, 100, 100, 0.2);

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
    @media (max-width: 640px) {
        #emptbl{
            margin-top:15% !important;
        }
    }
    @media (max-width: 400px) {
        #emptbl{
            margin-top:25% !important;
        }
    }
    select.sort_select{
        -webkit-appearance: none;
        -moz-appearance: none;
        -o-appearance: none;
        /* no standardized syntax available, no ie-friendly solution available */
        background: url("{{ asset('icons/v-icon.svg') }}") no-repeat 100% center;
        }
    </style>
<header class="dash-toolbar">

    <div class="main-label">

       <button id="addreport" class="btn-create" > <span><i> <img src="{{ asset('icons/setproject2.svg') }}" style="width:16px; height:20px; margin-right:5px;" alt=""> </i> Create New Reports </span> </button>

    </div>
    <div class="tools">
       @include('notification')
	@include('admin.home.header')
    </div>
</header>
@endsection
@section('main')

                <div class="modal_inputs" style="padding-left:0; margin-top:-5%;">
                <div class="date-from-to">

                        <div class="date-from" style="" >
                                <i class="calendar"> <img src="{{ asset('icons/calendar.svg') }}"></i>
                                <div class="form-floating">

                                    <input type="text" class="form-control" name="end_date" id="status_due_date" placeholder="" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
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
                        </div>
                    </div>
                </div>

                <div class="tltbl">
                    <table class="tl-table" id="emptbl" style="margin-top:4%; margin-left:1%;">
                        <thead style="width: 1078px; height: 40px;">
                            <th width="233px">Project Name</th>
                            <th style="width:273px">Timeline</th>
                            <th width="174px">Expected Hours</th>
                            <th width="151px">Price</th>
							 <th width="151px">Current Cost</th>
                            <th style="width:120px;"><i><img class="" src="{{ asset('icons/cone.svg') }}" style="" alt=""></i> Status</th>

                        </thead>
                        <tbody>

						@foreach($all_projects as $p)
						@if($p->status=="Not started")
							<tr style="color:#CBD4DB;">
                                <td>
                                    <i><img class="" src="/storage/quotation/{{$p->image}}" style="" alt="profile"></i>
                                    <span class="td_empname" ><a href="/admin/project/{{$p->id}}" style="color:#CBD4DB;">{{$p->project_name}}</a></p> </span>
                                </td>
                                <td>
                                     <span class="empprog_enddate " style="color:#CBD4DB; margin-left:25%;">{{$p->all_hours_cost}}/{{$p->all_hours}}</span>
                                    <center>
                                    <div class="progress empprogress" style="height: 6.34px;width:100%; border-radius: 5px;" style="color:#CBD4DB;">
                                        <div class="progress-bar bg-{{$p->style}}" role="progressbar" style="width: {{$p->timeline}}% ;border-radius: 5px;" aria-valuenow="{{$p->timeline}}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div> </center>
                                </td>
                                <td><span class="tl-text " style="color:#CBD4DB;">{{$p->hours}}/{{$p->expected_hours}}</span></td>
                                <td><span class="tl-text ">{{$p->price}}</span></td>
								 <td><span class="tl-text">{{$p->current_cost}}</span></td>
								 <td>{{$p->status}}</td>
                            </tr>
						@else
						<tr>
                                <td>
                                    <i>@if ($p->image==null)
                                        <img class="" src="/storage/quotation/2122136.png" style="" alt="profile"></i>

                                        @else
                                        <img class="" src="/storage/quotation/{{$p->image}}" style="" alt="profile"></i>
                                        @endif

                                    <span class="td_empname" ><a href="/admin/project/{{$p->id}}">{{$p->project_name}}</a></p> </span>
                                </td>
                                <td>
                                     <span class="empprog_enddate ">{{$p->all_hours_cost}}/{{$p->all_hours}}</span>
                                    <center>
                                    <div class="progress empprogress" style="height: 6.34px;width:100%; border-radius: 5px;">
                                        <div class="progress-bar bg-{{$p->style}}" role="progressbar" style="width: {{$p->timeline}}% ;border-radius: 5px;" aria-valuenow="{{$p->timeline}}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div> </center>
                                </td>
                                <td><span class="tl-text text-{{$p->style}}">{{$p->hours}}/{{$p->expected_hours}}</span></td>
                                <td><span class="tl-text ">{{$p->price}}</span></td>
								 <td><span class="tl-text">{{$p->current_cost}}</span></td>
								 <td>{{$p->status}}</td>
                            </tr>
						 @endif
                         @endforeach
                        </tbody>
                    </table>
                </div>
                @include('reportModal')

<script>
$(document).ready(function(){
        $("#emptbl").DataTable({

        initComplete: function () {
            this.api()
                .columns(5)
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
                            select.append("<option  value='" + d + "'>" + d + '</option>');
                        });
                });
            },
            columnDefs: [
                            { orderable: false, targets: 5 }
                        ]
            });
        $('#emptbl_length label').html($('#emptbl_length label').html().replace("entries", "Entries"));
        $("#emptbl_filter label").append("<i id='filter_icon'><img src='"+"{{asset('icons/search_icon.svg')}}" +"' style='width:17px; height:17px; ' alt=''></i>");
        $("#emptbl_filter input").attr("placeholder", "Search");
        $(".search_grid").append($("#emptbl_filter"));


        $("#emptbl_length label").append( " of " + $("#emptbl").DataTable().column( 0 ).data().length );
        $("#clientsnum").html($("#emptbl").DataTable().column( 0 ).data().length);



        var modal1 = document.getElementById("reportModal");
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
