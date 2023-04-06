
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
        right: -10px;

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

    input[type="file"] {
    display: none;
    }
    .custom-img-upload {
        width:130px;
        height:40px;
        background: #CBD4DB;
        border-radius: 8px;
        border: 1px solid #CBD4DB ;
        display: inline-block;
        padding: 4px 12px;
        cursor: pointer;
        margin-bottom:10px;
        font-family: 'Cairo';
        font-style: normal;
        font-weight: 400;
        font-size: 17px;
        line-height: 32px;
        /* identical to box height */
        color: #000;
    }
    #add_new_qout{
        font-family: 'Cairo';
        font-style: normal;
        font-weight: 400;
        font-size: 20px;
        line-height: 120%;
        /* identical to box height, or 24px */

        letter-spacing: 0.125em;

        color: #151B26;
    }
    .expected{
        width:100%;
        height:46px;
        /* Black */

        border: 2px dashed rgba(5, 22, 38, 0.3);
        border-radius: 7px;
        margin-bottom:8px;

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
    .modal_inputs{
    padding-left:0px;
    }
    .calendar{
        position:absolute;
        margin-top:5px;
        margin-left:68%;
        z-index:10;
    }
    #searcharea{
        height:180px;
        overflow-y:auto;
        overflow-x:hidden
    }

    @media (max-width:400px){
        #add_new_qout{
            margin-top:8%;
        }
    }
    .en_btns{
        border:none;
        width:40px;
        background-color:white;
    }
    .enable_list{
        display:none;
        width: 100px;
        height: 35px;
        border: 1px solid #CBD4DB;
        z-index: 100;
        position: absolute;
        margin-top: -10px;
        margin-left: -78px;
        border-radius: 4px;
        background-color: white;
        padding-left: 1%;
        padding-top: 5px;
        padding-bottom: 5px;

    }
    /* Project ->show*/
    </style>
	 <ul id="error" style="background-color:red;width:50%;margin-left:2%;margin-top:2%;" hidden></ul>
<header class="dash-toolbar">

    <div class="main-label" style="width:500px; margin-top:2%;">
       <button id="add_new_btn" class="new_btn" style="width:83px; height:41px">
        <i><img src="{{asset('icons/okmark.svg')}}" style="width:20px; height:20px;"/></i> Save
       </button>

    </div>
    <div class="tools">
    @include('notification')
	@include('admin.home.header')
    </div>
</header>
@endsection
@section('main')

            <div id="add_new_qout">
                INFO
            </div>

            <div class="modal_inputs">


                <div class="row">
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="project_name" value="{{$project->project_name}}" id="projectname" placeholder="Project Name" disabled>
                            <label for="projectname">Project Name</label>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="sform-floating">
                            <select class="form-select" id="client_id" name="client_id"  aria-label="client" style="height: 40px;"disabled>

						  <option value="{{$clients->id}}">{{$clients->compnay_name}}</option>


                        </select>
                        <label class="select_label" for="client_id">Client</label>
                        </div>
                    </div>

                    <div class="col-md-3">
                            <i class="calendar"> <img src="{{ asset('icons/calendar.svg') }}"></i>
                            <div class="form-floating">
                                <input type="text" class="form-control" name="start_date" id="start_date" value="{{$project->start_date}}" placeholder="Start Date" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'"disabled>
                                <label class="date_label" id="fstart_date" for="start_date">{{__('Start Date')}}</label>
                            </div>
                    </div>
                    <div class="col-md-3">
                    <i class="calendar"> <img src="{{ asset('icons/calendar.svg') }}"></i>
                            <div class="form-floating">
                                <input type="text" class="form-control" name="end_date" value="{{$project->end_date}}" disabled id="end_date" placeholder="Due Date" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <label class="date_label" id="fstart_date" for="start_date">{{__('Due Date')}}</label>
                            </div>
                    </div>



                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="expected_hours" value="{{$project->expected_hours}}" id="expected_hours" placeholder="Expected Hours"disabled>
                            <label for="expected_hours">Project Hours</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="admin_hours" value="{{$project->admin_hours}}" id="admin_hours" placeholder="Backup Hours"disabled>
                            <label for="admin_hours">Admin Hours</label>
                        </div>
                    </div>
					    <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" value="{{$project->end_admin_date}}"  name="admin_duedate" id="admin_duedate" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'"disabled>
                                <label id="aduedate" for="start_date">{{__('Due Date By Admin')}}</label>
                            </div>
                    </div>
                    <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="price" value="{{$project->price}}"  id="price" placeholder="Price"disabled>
                                <label for="price">{{__('Price')}}</label>
                            </div>
                    </div>
					   <div class="col-md-3">
                       <div class="sform-floating">
                        <select class="form-select" id="currency_id" name="currency_id" aria-label="client" style="height: 40px;"disabled>
                          @foreach ($currencies as $c)
						  <option id="{{$c->sp_value}}" value="{{$c->id}}">{{$c->sp_value}} s.p ({{$c->us_value}} $)</option>
						  @endforeach
                        </select>
                        <label class="select_label" for="currency_id">Currency</label>
                   </div>
                    </div>
                    <div class="col-md-3">

                    </div>



                </div>



            </div>

                <div id ="" class="collegues">

			         <div id="colleage2"></div>
                    <button id="assign" class="assign" style="background-color:white; border: 1px solid white;">
                       <i><img class="" src="{{ asset('icons/plus.svg')}}" style="width:10px; height:10px; " alt="profile"></i> Assign Employee
                    </button>
                </div>
                <div>

                </div>
                <div>
                <div id="search_bar">
                    <form action="" method="get">
                        <input type="text" class="" placeholder="Search">
                    </form>

                </div>

                     </div>


                <div class="tltbl">
                    <table class="tl-table" id="emptbl" style="margin-top:6%; margin-left:1%;">
                        <thead style="width: 1078px; height: 40px;">
                            <th style="width:200px">Employee Name</th>
                            <th style="width:180px">Position</th>
                            <th style="width:120px">Timeline</th>
                            <th style="width:120px">Working Hours</th>
                            <th style="width:120px">Backup Hours</th>
                            <th >Current Cost</th>
                           <th width="18px"></th>
                        </thead>
                    <tbody ID="mytbody">
                       	@foreach ($project->employee_details as $p)
						<tr>
                                <td>
                                    <i><img class="" src="/storage/employee/{{$p->image}}" style="" alt="profile"></i>
                                    <span style="font-size:16px" class="td_empname"> {{$p->first_name}} {{$p->last_name}}</span>
                                </td>
								 <td>

                                    <span > {{$p->position}}</span>
                                </td>
                                <td>
                                     <span class="empprog_enddate">{{$p->work_hours}}/{{$p->expected_hours}}</span>
                                    <center>
                                    <div class="progress empprogress" style="height: 6.34px; border-radius: 5px;">
                                        <div class="progress-bar bg-{{$p->style}}" role="progressbar" style="width: {{$p->timeline}}% ;border-radius: 5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div> </center>
                                </td>
                                <td><span class="tl-text">{{$p->work_hours}}/{{$p->expected_hours}}</span></td>
                                <td><span class="tl-text">{{$p->back_work_hours}}/{{$p->backup_hours}}</span></td>
								<td><span class="tl-text">{{$p->cost}}</span></td>
								<td>
								<form method="post" action="{{route('project.drop')}}">
								@csrf
								<input type="number" name="employee_id" value="{{$p->id}}" hidden />
								<input type="number" name="project_id" value="{{$project->id}}" hidden />
								@if ($p->enable==1)
								 <i class="enables"><img class="" src="{{ asset('icons/MoreCircle.svg') }}" style="" alt=""></i>
                                    <div class="enable_list"> <button class='en_btns' id="enable_button"  type="submit"> Enable</button> </div>
							  @else
								<i class="enables"><img class="" src="{{ asset('icons/MoreCircle.svg') }}" style="" alt=""></i>
                                    <div class="enable_list"> <button class='en_btns' id="disable_button" type="submit"> Disable </button> </div>
							@endif
								</form>

						</tr>
                           	@endforeach
                        </tbody>
                    </table>
                </div>
        <div class="expected" id="expected_cost">
            Expected Cost : <span id="all_cost">{{$project->cost}}</span>
        </div>
        <div class="expected" id="expected_time">
            Expected Delivery Time :<span id="time_until"> {{$project->end_date}}</span>
        </div>
  <span id="myprice" hidden></span>
  <input type="number" id="project_id" value="{{$project->id}}" hidden />
  <span id="spvalue" hidden>{{$project->priceSY}}</span>
        @include('assignEModal')
        @include('employeeProjectUpdate')
<script>
 $( "#enable_button" ).click(function() {
	 document.getElementById("enable_button").hidden=true;
	document.getElementById("disable_button").hidden=false;
 });
  $( "#disable_button" ).click(function() {
	 document.getElementById("disable_button").hidden=true;
	 document.getElementById("enable_button").hidden=false;
 });
$(document).ready(function(){


        $(".enables").click(function() {
            $(this).next().toggle();

        });
        $("#emptbl").DataTable();

        $("#emptbl_filter label").append("<i id='filter_icon'><img src='"+"{{asset('icons/search_icon.svg')}}" +"' style='width:17px; height:17px; ' alt=''></i>");
        $("#emptbl_filter input").attr("placeholder", "Search Employee");


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
    btn.onclick = function() {
    modal1.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    //span.onclick = function() {
    //modal.style.display = "none";
    //}

const employees=[];
 <?php foreach($project->employee_details  as $e){ ?>
        employees.push('<?php echo $e->id; ?>');
    <?php } ?>
   const hours=[];
  <?php foreach($project->employee_details  as $e){ ?>
        hours.push('<?php echo $e->expected_hours; ?>');
    <?php } ?>
   const back=[];
   <?php foreach($project->employee_details  as $e){ ?>
        back.push('<?php echo $e->backup_hours; ?>');
    <?php } ?>
   const formdata = new FormData();
    jQuery("#file-upload").on("change", function() {
		 var file = this.files[0];
		 formdata.append("image", file);
	});
   $( "#add_new_btn" ).click(function() {
	var project_name=document.getElementById("projectname").value;
	var start_date=document.getElementById("start_date").value;
	var select = document.getElementById('client_id');
	var client_id = select.options[select.selectedIndex].value;
	var end_date=document.getElementById("end_date").value;
	var set="0";
	var expected_hours=document.getElementById("expected_hours").value;
	var admin_hours=document.getElementById("admin_hours").value;
	var price=document.getElementById("price").value;
	var admin_duedate=document.getElementById("admin_duedate").value;
	var select = document.getElementById('currency_id');
	var currency_id = select.options[select.selectedIndex].value;
	var cost = document.getElementById("all_cost").innerHTML;
	var project_id=document.getElementById("project_id").value;
	let _token   = $('meta[name="csrf-token"]').attr('content');
	if(project_name==""){
		document.getElementById("error").innerHTML="<li>Enter Project Name</li>";
		document.getElementById("error").hidden=false;
		return 0;
	}
	if(start_date==""){
		document.getElementById("error").innerHTML="<li>Enter Start Date</li>";
		document.getElementById("error").hidden=false;
		return 0;
	}
	if(end_date==""){
		document.getElementById("error").innerHTML="<li>Enter End Date</li>";
		document.getElementById("error").hidden=false;
		return 0;
	}

	if(expected_hours==""){
		document.getElementById("error").innerHTML="<li>Enter Expected Hours</li>";
		document.getElementById("error").hidden=false;
		return 0;
	}
	if(admin_hours==""){
		document.getElementById("error").innerHTML="<li>Enter Admin Hours</li>";
		document.getElementById("error").hidden=false;
		return 0;
	}
  if(price==""){
		document.getElementById("error").innerHTML="<li>Enter Price</li>";
		document.getElementById("error").hidden=false;
		return 0;
	}
	formdata.append("project_name", project_name);
	formdata.append("start_date", start_date);
	formdata.append("client_id", client_id);
	formdata.append("end_date", end_date);
	formdata.append("expected_hours", expected_hours);
	formdata.append("end_admin_date", admin_duedate);
    formdata.append("admin_hours", admin_hours);
	formdata.append("hours", JSON.stringify(hours));
	formdata.append("price", price);
	formdata.append("set", set);
	formdata.append("back", JSON.stringify(back));
	formdata.append("employees", JSON.stringify(employees));
	formdata.append("currency_id", currency_id);
	formdata.append("cost", cost);
	formdata.append("project_id", project_id);
	formdata.append("_token", _token);


	 $.ajax({
        url: "{{route('project.myupdate')}}",
        type:"POST",
       data: formdata,
        processData: false,
        contentType: false,
        success:function(response){
          console.log(response);
		 window.location.href = "{{ route('project.index')}}";

        },
        error: function(error) {

         	document.getElementById("error").innerHTML="<li>"+error.responseJSON.message+"</li>";
			document.getElementById("error").hidden=false;

        }
       });

		});


$( "#add_new_btn_set" ).click(function() {
	var project_name=document.getElementById("projectname").value;
	var start_date=document.getElementById("start_date").value;
	var select = document.getElementById('client_id');
	var client_id = select.options[select.selectedIndex].value;
	var end_date=document.getElementById("end_date").value;
	var set="1";
	var expected_hours=document.getElementById("expected_hours").value;
	var admin_hours=document.getElementById("admin_hours").value;
	var price=document.getElementById("price").value;
	var admin_duedate=document.getElementById("admin_duedate").value;
	var select = document.getElementById('currency_id');
	var currency_id = select.options[select.selectedIndex].value;
	var project_id=document.getElementById("project_id").value;

	let _token   = $('meta[name="csrf-token"]').attr('content');
	if(project_name==""){
		document.getElementById("error").innerHTML="<li>Enter Project Name</li>";
		document.getElementById("error").hidden=false;
		return 0;
	}
	if(start_date==""){
		document.getElementById("error").innerHTML="<li>Enter Start Date</li>";
		document.getElementById("error").hidden=false;
		return 0;
	}
	if(end_date==""){
		document.getElementById("error").innerHTML="<li>Enter End Date</li>";
		document.getElementById("error").hidden=false;
		return 0;
	}

	if(expected_hours==""){
		document.getElementById("error").innerHTML="<li>Enter Expected Hours</li>";
		document.getElementById("error").hidden=false;
		return 0;
	}
	if(admin_hours==""){
		document.getElementById("error").innerHTML="<li>Enter Admin Hours</li>";
		document.getElementById("error").hidden=false;
		return 0;
	}
  if(price==""){
		document.getElementById("error").innerHTML="<li>Enter Price</li>";
		document.getElementById("error").hidden=false;
		return 0;
	}
	formdata.append("project_name", project_name);
	formdata.append("start_date", start_date);
	formdata.append("client_id", client_id);
	formdata.append("end_date", end_date);
	formdata.append("expected_hours", expected_hours);
	formdata.append("end_admin_date", admin_duedate);
    formdata.append("admin_hours", admin_hours);
	formdata.append("hours", JSON.stringify(hours));
	formdata.append("price", price);
	formdata.append("set", set);
	formdata.append("back", JSON.stringify(back));
	formdata.append("employees", JSON.stringify(employees));
	formdata.append("currency_id", currency_id);
	formdata.append("_token", _token);


	 $.ajax({
        url: "{{route('quotation.store')}}",
        type:"POST",
       data: formdata,
        processData: false,
        contentType: false,
        success:function(response){
          console.log(response);
		 window.location.href = "{{ route('quotation.index')}}";

        },
        error: function(error) {

         	document.getElementById("error").innerHTML="<li>"+error.responseJSON.message+"</li>";
			document.getElementById("error").hidden=false;

        }
       });

		});
    // When the user clicks anywhere outside of the modal, close it
    function EHM(id,image,first,last,price,position,cost_hour,over_hour){

		document.getElementById("emp_id").innerHTML=id;
		document.getElementById("cost_hour").innerHTML=cost_hour;
		document.getElementById("over_hour").innerHTML=over_hour;
		document.getElementById("all_name").innerHTML=first+" "+last;
		document.getElementById("position_all").innerHTML="("+position+")";

		document.getElementById("myprice").innerHTML=price;

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
