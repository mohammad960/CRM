@extends('admin.home.app')

@section('topnav')
    <style>

     .dataTables_paginate{

        position: absolute;
        bottom:-45px;
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
        bottom:-45px;
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
        display:none;
        float:right;
        margin-right: 25px;
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

    table th{
        font-family: 'Cairo';
        font-style: normal;
        font-weight: 700;
        font-size: 12px !important;
        line-height: 120%;
        /* identical to box height, or 17px */

        letter-spacing: 0.125em;

        color: #051626;
    }

    .expected{
        width:100%;
        height:46px;
        /* Black */

        border: 2px dashed rgba(5, 22, 38, 0.3);
        border-radius: 7px;
        margin-top:70px;

        font-family: 'Cairo';
        font-style: normal;
        font-weight: 500;
        font-size: 24px;
        line-height: 45px;
        /* identical to box height */
        padding-left:8px;

        /* Black */

        color: #051626;
    }
    .expected img{
        margin-top: -7px;
        margin-right: 15px;
    }
    #select_time{
        position: relative;
        float:right;
        top: -20px;
        /*left:80%;*/
        z-index:100;
    }

    #modaltable table td {

        padding-left:10px;
        height:30px;
    }
    table td {

    }
    table tr td{
    padding-left:5px !important;
    font-size:14px;
    }

    #modal_cancel{
        position: relative;
        left: 80px;
        margin-bottom: 20px;
        margin-top: 20px;
    }
    #modal_cancel{
        left:0px;
        margin-top:0px;
    }
    .task-list table thead th{
    position: sticky !important;
    top: 0px !important;
    z-index:100;

    }
    .task-list {
        height: 200px;
        overflow-y:auto;
    }
    table tr td:nth-of-type(4){
        font-size:14px;
    }
    table tr td{
        vertical-align: middle;
    }
    </style>
<header class="dash-toolbar">

    <div class="main-label">
       Salaries

    </div>
    <div class="tools">
       @include('notification')
	@include('admin.home.header')
    </div>
</header>
@endsection
@section('main')

    <div style="padding-bottom:12px; ">
        <p class="p1" style="width:60%;">Employees (<span id="usersnum">
            {{count($salary)}}</span>)
         <!--   <span style="padding-left:16px;"> {{$currency->us_value}}$ = {{$currency->sp_value}} SP </span> !-->
        </p>

        <div id="select_time">
            <i> <img src="{{ asset('icons/calendar.svg') }}"></i>
			<input type="month"  id="today" name="today" >
            <i style="margin-left:-20px"> <img width="8px" height="8px" src="{{ asset('icons/down.svg') }}"></i>

        </div>
    </div>

                <div class="tltbl">
                    <table class="tl-table" id="emptbl" style="width:100%; margin-top:4%; margin-left:1%;">
                        <thead style="width: 100%; height: 40px;">
                            <th style="width: 2%;"></th>
                            <th style="width: 20%;"> <i><img class="" src="{{ asset('icons/cone.svg') }}" style="margin-right:5%" alt=""></i>Employee Name</th>
                            <th style="width: 20%;">Completed Hours</th>
                            <th style="width: 12%;">Overtime Hours</th>
                            <th style="width: 24%;">Accepted Overtime Hours</th>
							<th style="width: 5%;">Bonus/Deduction </th>
                            <th style="width: 20%;">Salary</th>
                            <th style="width: 5%;">Status </th>
                            <th style="width: 5%;"> </th>
                        </thead>
                        <tbody>

						@foreach($salary as $s)
						<tr>
                                <td><i>
                                    @if ($s->employee->image==null)
                                    <img class="" src="/storage/employee/2122136.png" style="" alt="profile"></i>

                                    @else
                                    <img class="" src="/storage/employee/{{$s->employee->image}}" style="" alt="profile"></i>
                                    @endif





                                <td >
                                    {{$s->employee->first_name}} {{$s->employee->last_name}}
                                </td>
                                <td>
                                     <span class="text-14" > <span class="text-{{$s->style}} text-bold-16">{{$s->hours_minute}}</span>/{{$s->employee->target_hours}} </span>
                                </td>
                                <td><span class="text-14"> <span class="text-danger">{{$s->hours_minute_over}}</span> </span></td>
                                <td><span class="text-14">{{$s->hours_minute_over}}</span>
									 @if($s->status == "not paid")
                                    <button   style="width:20px; float:right; margin-right:24%; border:none"  onclick="add_salary({{$s->id}})" name="" class="modal_btn_add">
                                        <i><img class="" src="{{ asset('icons/edit.svg') }}" style="width:20px" alt=""></i>
                                    </button>
									@endif
                                </td>
								<td>
                                    <!--i class="showPassword" style="float:right;"><img src="{{ asset('icons/eye-show.svg') }}"></i>
                                    <i class="hidePassword" style="float:right; display:none"><img src="{{ asset('icons/eye-hide.svg') }}" style=""></i>
                                    <span class="text-14">300 SP </span>
                                    <span class="" style="display:none;"> * </span-->
									 @if($s->status == "not paid")
                                    <button style="width:90px;"  onclick="add_bonus({{$s->id}})" name="{{$s->id}}" class="modal_btn_add">
                                        Add
                                    </button>
									  @else
										  {{$s->bonus}} SP
								 @endif
                                </td>
                                <td>
                                    <i class="showPassword" style="float:right;"><img src="{{ asset('icons/eye-show.svg') }}"></i>
                                    <i class="hidePassword" style="float:right; display:none"><img src="{{ asset('icons/eye-hide.svg') }}" style=""></i>
                                    <span class="text-14">{{$s->amount}} SP </span>
                                    <span class="" style="display:none;"> * </span>
                                </td>
								<td>
                                    @if($s->status != "not paid")
                                    <i><img class="" src="{{ asset('icons/ok-green.svg') }}" style="" alt=""></i>
                                    <span class="td_empname" > Paid </span>
									 <button style="width:90px;" hidden name="{{$s->id}}" class="modal_btn_add">
                                        Pay Now
                                    </button>
                                @else
                                    <button style="width:90px;"  onclick="pay({{$s->id}})" name="{{$s->id}}" class="modal_btn_add">
                                        Pay Now
                                    </button>

                                @endif
                                </td>
                                <td>
                                    <button style="width:80px;" onclick="details({{$s->employee->id}},{{$s->id}})" name="{{$s->employee->id}}" class="modal_btn_add">
                                        Show
                                    </button>
                                </td>
                            </tr>
                         @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="expected" id="expected_cost">

                    <i class="showPassword2" style="float:right;"><img height="32px" src="{{ asset('icons/eye-show.svg') }}"></i>
                    <i class="hidePassword2" style="float:right; display:none"><img height="32px" src="{{ asset('icons/eye-hide.svg') }}" style=""></i>
                    Total Paid Salaries: <span id="all_cost">{{$all_amount}} sp = {{$all_amount/$currency->sp_value}} </span>
                    <span class="" style="display:none;"> * </span>
                </div>

                @include('details')
                @include('bonusModal')
                @include('admin.project-tasks')
                @include('confirmModal')
<script>
var modal1 = document.getElementById("Details");
var modal2 = document.getElementById("BonusModal");
var modal3 = document.getElementById("ptasks");
var modal4 = document.getElementById("mconfirm");
$('input[name=today]').change(function() {

 window.location.replace('/admin/salary?date='+$("#today").val());

});
 function pay(salary_id) {
				let _token   = $('meta[name="csrf-token"]').attr('content');

				  $.ajax({
					url: "{{route('salary.pay')}}",
					type:"post",
					data:{
					  salary_id:salary_id,
					  _token: _token
					}

				   });
				   window.location.href="/admin/salary";

        }
function add_salary(id){

	document.getElementById("salary_id_over").value=id;
	 modal4.style.display = "block";

}
function add_bonus(id) {

            modal2.style.display = "block";
			document.getElementById("id_v").value = id;
        }
function show_task(salary_id,project_id,employee_id) {
					let _token   = $('meta[name="csrf-token"]').attr('content');
					modal3.style.display = "block";
					$.ajax({
					url: "{{route('employee.project.task')}}",
					type:"post",
					data:{
					  project_id:project_id,
					  employee_id:employee_id,
					  salary_id:salary_id,
					  _token: _token
					},
				success:function(response){
					 document.getElementById("task_body").innerHTML="";
					 for(var i=0;i<response.length;i++){
					var start=response[i]['start_date'].split(" ");
					try {
					var end=response[i]['end_date'].split(" ");
					}
					catch(err) {
						var end=[];
						}
					var start_date="";
					var end_date="";
					var start_time="";
					var end_time="";
					if(start.length ==2){
						start_date=start[0];
						start_time=start[1];
					}
					if(end.length ==2){
						end_date=end[0];
						end_time=end[1];
					}
					 document.getElementById("task_body").innerHTML=document.getElementById("task_body").innerHTML+'<tr>'+
                               ' <td>'+
								response[i]['description']+
                               ' </td>'+

                              '  <td>'+
							 start_date+
                             '   </td>'+

                              '  <td>'+
						end_date+
                              '  </td>'+

                              '  <td>'+
							    start_time+

                             '   </td>'+
							'   <td>'+
						              end_time+
							 '  </td>'+
							'   <td>'+
						parseInt(response[i]['hours']/60)+"H : "+response[i]['hours']%60+
							 ' m</td>'+
                          '  </tr>';

					 }
					console.log(response);
				}
				   });

                            //console.log("1!!");
                        }


function details(employee_id,salary_id)  {

				let date =  document.getElementById("today").value;
				let _token   = $('meta[name="csrf-token"]').attr('content');

				  $.ajax({
					url: "{{route('salary.employee')}}",
					type:"post",
					data:{
					  employee_id:employee_id,
					  salary_id:salary_id,

					  date:date,
					  _token: _token
					},
					success:function(response){
					  if(response) {
						  document.getElementById("body_project").innerHTML="";
						document.getElementById("employee_name").innerHTML=response.employee.first_name+" "+response.employee.last_name;
						document.getElementById("target_hours").innerHTML=response.employee.target_hours;
						document.getElementById("all_hours").innerHTML=response.all_hours;
						document.getElementById("over_hours").innerHTML=response.over_hours;
						for(var i=0;i<response.projects.length;i++){
							document.getElementById("body_project").innerHTML=document.getElementById("body_project").innerHTML+'<tr>'
                               +' <td>'
                             +  '     <i><img class="" src="/storage/quotation/'+response.projects[i]["image"]+'" style="" alt=""></i>'
                            +    '     <span class="td_empname" ><a onclick="show_task('+response.salary.id+','+response.projects[i]["id"]+','+response.employee.id+')" name="'+response.projects[i]["id"]+'" href="#">'+response.projects[i]["project_name"]+'</a></p> </span>'
                           +  '   </td>'
                          +  '   <td>'
                          +  '        <span class="text-16" >'+response.projects[i]["work_hours"]+'</span>'
                          +  '    </td>'
                          +  '    <td>'
                          +  '        <span class="text-16 text-danger" >'+response.projects[i]["extra_hours"]+'</span>'
                         +  '     </td>'
                        +  '  </tr>';

						}

					  }
					},
					error: function(error) {
					 console.log(error);

					}
				   });
            modal1.style.display = "block";
        }

$(document).ready(function(){

        $("#emptbl").DataTable({
        order: [[6, 'asc']],
         initComplete: function () {
            this.api()
                .columns(1)
                .every(function () {
                    var column = this;
                    var select = $('<select class="sort_select" style="width:16%; border:none; background-color:#F1F1F1; margin-left:2px;"><option value=""></option>'
                                 +'</select>'
                    )
                        .appendTo($(column.header()))
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            //console.log($(this).val());
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
                {"name": "8", "orderable": true},
                {"name": "9", "orderable": true}
              ],

        });
        $('#emptbl_length label').html($('#emptbl_length label').html().replace("entries", "Entries"));



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


        $(".showPassword2").click(function() {
            $(this).toggle();
            $(this).next("i").toggle();
            $(this).next().next().toggle();
            $(this).next().next().next().toggle();
        });
        $(".hidePassword2").click(function() {
            $(this).toggle();
            $(this).prev("i").toggle();
            $(this).next().toggle();
            $(this).next().next().toggle();

        });



        // Get the button that opens the modal




        var btn2 = document.getElementById("modal_cancel");
        btn2.onclick = function() {
            modal1.style.display = "none";
        }

        var span1 = document.getElementsByClassName("close")[1];
        span1.onclick = function() {
            modal2.style.display = "none";
        }

////////////////////////////////////

        var span2 = document.getElementsByClassName("close")[2];
        span2.onclick = function() {
            modal4.style.display = "none";
        }

///////////////////////////////////

        window.onclick = function(event) {
        if (event.target == modal1) {
            modal1.style.display = "none";
        }
        if(event.target == modal2){
           modal2.style.display = "none";
        }
        if(event.target == modal3){
           modal3.style.display = "none";
        }
        if(event.target == modal4){
           modal4.style.display = "none";
        }
    }

});
</script>

@endsection
