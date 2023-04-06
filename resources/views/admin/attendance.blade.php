@extends('admin.home.app')

@section('topnav')
<style>
    #projecttbl_paginate{
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
    #projecttbl_length{
        position: absolute;
        bottom:-60px;
        font-family: 'Cairo';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height:18px;

        color: #12171B;
    }
    #projecttbl_info{
        display: none;
    }
    #projecttbl_filter{
        position: absolute;
        top: -50px;
        right: 5px;
        display:none;

    }
    #projecttbl_filter input{
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
    #projecttbl_filter label{
        color: white;
    }
    #filter_icon{
        position: absolute;
        border-radius: 15px;
        left: 65px;
        top: 2px;
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
    #projecttbl_next , #projecttbl_previous{
        width: 75px;
        background-color: white;
        margin-right: 0px;
        border-radius: 0 !important;
    }
    #select_time{
        position: relative;
        float:right;
        top: -40px;
        right:10px;
    }
    #select_time input{
    border:none;
    }
    .hidden{
        display:none;
    }
    .rotate{
        transform:rotate(90deg);
    }
    td.last{
        padding-left:13px !important;
    }
.input-container input {

    outline: 0;
    padding: .75rem;
    position: relative;
    width: 100%;
}

input[type="date"]{
    border-width:0px;
    border:none;
    outline:none;
}
tr:nth-child(4n+0) {background:#F8F8FA;}
tr:nth-child(4n+1) {background:#fff;}
tr:nth-child(4n+2) {background:#fff;}
tr:nth-child(4n+3) {background:#F8F8FA;}
input[type="date"]::-webkit-calendar-picker-indicator {
    background: none;

}
#calendar{
   /* float:right;
    transform:translateX(20px);*/
}
</style>
<header class="dash-toolbar">


    <div class="main-label">
       Attendance


    </div>
    <div class="tools">
        @include('notification')
		@include('admin.home.header')
    </div>
</header>
@endsection

@section('main')

                <p class="p1" style="">Employees (<span id="usersnum">{{count($all)}}</span>)</p>
                <div id="select_time">

                    <i id="calendar"> <img src="{{ asset('icons/calendar.svg') }}"> </i>
					<input type="date" id="today" name="today" value="{{$date_day}}">
                    <i style="margin-left:-30px"> <img width="8px" height="8px" src="{{ asset('icons/down.svg') }}"></i>
                </div>

                <div class="clients_table" style="" id="employee_table">
                    <table class="pro-table" id="projecttbl" style="width:100%; /*1078px;*/">
                        <thead>

                            <th width="554px">Employee Name</th>
                            <th width="176px">Status</th>
                            <th width="159px">Entry Time</th>
                            <th width="153px">Exit Time</th>
                            <th width="36px"></th>
                        </thead>
                        <tbody id="body_table">
						@foreach($all as  $key=>$a)
                            <tr class="c{{ $a->eid }}">
							    <td> <i>
                                    @if ($a->image==null)
                                    <img class="" src="/storage/employee/2122136.png" style="" alt="profile"></i>

                                    @else
                                    <img class="" src="/storage/employee/{{$a->image}}" style="" alt="profile"></i>
                                    @endif



                                    <span class="text-{{$a->style}}" >{{$key}}</span>
                                </td>

                                <td class="text-{{$a->style}}">{{$a->status}}</td>
                                <td class="text-{{$a->style}}">{{explode(" ",$a->array_start[0])[1]}}</td>
                                <td class="text-{{$a->style}}">
                                    @if ($a->array_end[count($a->array_end) - 1] !== null)
                                    {{explode(" ",$a->array_end[count($a->array_end) - 1])[1]}}
                                        @endif

								</td>
                                <td class="last"><img src="{{asset('icons/extend.svg')}}"></td>
                            </tr>
							<tr class="c{{$a->eid}} hidden" >
								<td></td>
								<td></td>
								<td>

								@foreach($a->array_start as  $d)
										<span style="color:#CBD4DB;">{{explode(" ",$d)[1]}}
										</span>
										</br>
								@endforeach
								</td>
								<td>
								@foreach($a->array_end as  $d)

								@if ($d !== null)
								<span style="color:#CBD4DB;">{{explode(" ",$d)[1]}}</span>
								@else
									-
								@endif
								</br>
								@endforeach
								</td>
										<td> </td>
								  </tr>
						@endforeach



                        </tbody>
                    </table>
                </div>

<script>


    $("#projecttbl").DataTable({

        });
$(document).ready(function(){
 $('#projecttbl_length label').html($('#projecttbl_length label').html().replace("entries", "Entries"));
$('input[name=today]').change(function() {

 window.location.replace('/admin/attendance/all?date_today='+$("#today").val());

});
    $('td.last').on('click', function(){
            var class_name = $(this).parent().attr("class").split(' ')[0];
			console.log(class_name);
            $('.'+class_name+'.hidden').insertAfter($(this).parent())
            $('.'+class_name+'.hidden').toggle();
            //$(this).parent().nextUntil(".stop").toggle();
            $(this).find('img').toggleClass( "rotate" )
        });

});
</script>
@endsection
