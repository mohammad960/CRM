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
        float:right;
        margin-right: 25px;
    }
    #emptbl_filter input{
        width:100%;
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
        color: white !important;
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
    @media (max-width: 560px){
        #filter_icon {
        position: absolute;
        left: 63.5%;
        top: 31.5%;
        }
    }
    .modal_btn_add{
        height: 30px;
        border: 1px solid #003D6A;

    }
    </style>
<header class="dash-toolbar">

    <div class="main-label">
       Current Projects

    </div>
    <div class="tools">
       @include('notification')
	@include('admin.home.header')
    </div>
</header>
@endsection
@section('main')

        <div class="main_section">

                <div class="modal_inputs" style="padding-left:0;">

                    <div class="date-from-to">

                        <div class="date-from" style="" >
                                <i class="calendar"> <img src="{{ asset('icons/calendar.svg') }}"></i>
                                <div class="form-floating">

                                    <input type="text" class="form-control" name="start_date" id="start_date" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                    <label class="date_label" id="fdue_date" for="due_date">{{__('From Date of')}}</label>
                                </div>
                        </div>
                        <div class="text-to" style="">
                            {{__('To')}}
                        </div>
                        <div class="date-to" style="">
                                <i class="calendar"> <img src="{{ asset('icons/calendar.svg') }}"></i>
                                <div class="form-floating">

                                    <input type="text" class="form-control" name="end_date" id="end_date" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                    <label class="date_label" id="fdue_date" for="due_date">{{__('To Date')}}</label>
                                </div>
                        </div>
                        <div class="search_grid">
                        </div>
                    </div>
                </div>

                <div class="tltbl">
                    <table class="tl-table" id="emptbl" style="margin-top:4%; margin-left:1%;">
                        <thead style="width: 100%; height: 40px;">
                            <th >Project Name</th>
                            <th style="width:260px;">Timeline</th>
                            <th >Project Hours</th>
                            <th >Admin Hours</th>

                            <th >Current Cost</th>
                            <th ></th>

                        </thead>
                        <tbody>

						@foreach($all_projects as $p)
						<tr>
                                <td>
                                    <i>
                                    @if ($p->image==null)
                                    <img class="" src="/storage/quotation/2122136.png" style="" alt="profile"></i>

                                    @else
                                    <img class="" src="/storage/quotation/{{$p->image}}" style="" alt="profile"></i>
                                    @endif


                                    <span class="td_empname" ><a href="/admin/project/{{$p->id}}">{{$p->project_name}}</a></p> </span>
                                </td>
                                <td>

                                    <center>
                                    <span class="empprog_enddate">{{$p->all_hours_cost}}/{{$p->expected_hours}}</span>
                                    <div class="progress empprogress" style="height: 6.34px; border-radius: 5px;">
                                        <div class="progress-bar bg-{{$p->style}}" role="progressbar" style="width: {{$p->timeline}}% ;border-radius: 5px;" aria-valuenow="{{$p->timeline}}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div> </center>
                                </td>
                                <td><span class="tl-text ">{{$p->all_hours_cost}}/{{$p->expected_hours}}</span></td>
                                <td><span class="tl-text">{{$p->all_hours_cost}}/{{$p->admin_hours}}</span></td>
								 <td><span class="tl-text">{{$p->current_cost}} </span></td>
                                <td>
                                    <button id="current_edit" name="" class="modal_btn_add">
                                        <i> <img src="{{ asset('icons/edit.svg') }}"> </i>Edit
                                    </button>
                                 </td>
                            </tr>
                         @endforeach
                        </tbody>
                    </table>
                </div>
        </div>

<script>
$(document).ready(function(){
		const monthControl = document.querySelector('input[name=start_date]');
		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		const date_filter = urlParams.get('start');
		if(date_filter){
			monthControl.value=date_filter;
		}
		 const monthControl1 = document.querySelector('input[name=end_date]');
		 const queryString1 = window.location.search;
		 const urlParams1 = new URLSearchParams(queryString1);
		 const date_filter1 = urlParams1.get('end');

		if(date_filter1){
			monthControl1.value=date_filter1;
		}
        $("#emptbl").DataTable({
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
});
$('input[name=start_date]').change(function() {

 window.location.replace('/admin/current?start='+$("#start_date").val()+'&end='+$("#end_date").val());

});
$('input[name=end_date]').change(function() {

 window.location.replace('/admin/current?start='+$("#start_date").val()+'&end='+$("#end_date").val());

});

</script>

@endsection
