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
 #edit_btn{
    width: 68px;
    height: 24px;
    background: #FFFFFF;
    /* Brand Colors */
    padding:0;
    border: 1px solid red;
    border-radius: 5px;
    font-family: 'Cairo';
    font-style: normal;
    font-weight: 400;
    font-size: 13.5177px;
    line-height: 25px;
    text-align: center;

    /* Brand Colors */
    flex: none;
    order: 1;
    flex-grow: 0;
    padding-left:0;
    color: red;
    margin-right:8px;
    }
    input[type="file"] {
    display: none;
    }
    .custom-file-upload {
        width:205px;
        height:40px;
        background: #4495F1;
        border-radius: 8px;
        border: 1px solid #4495F1 ;
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
        color: #FFFFFF;
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
    </style>
<header class="dash-toolbar">

    <div class="main-label" style="width:500px" id="all_button">
       <button id="add_new_btn" class="new_btn" style="width:83px; height:41px">
        <i><img src="{{asset('icons/okmark.svg')}}" style="width:20px; height:20px;"/></i> Save
       </button>
	   @if(!$quotation->set_project)
       <button id="add_new_btn_set"  class="new_btn" style="width:118px; height:41px;color: #003D6A; background-color:white; border:1px solid #003D6A">
        <i><img src="{{asset('icons/setproject.svg')}}" style="width:20px; height:20px;"/></i> Set a Project
       </button>
	   @endif
       <button id="add_new_btn_print"  class="new_btn" onclick="myprint()" style="width:83px; height:41px;color: #003D6A; background-color:white; border:1px solid #003D6A">
        <i><img src="{{asset('icons/print.svg')}}" style="width:20px; height:20px;"/></i> Print
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
               Edit Quotation
            </div>
            <div class="modal_inputs">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="project_name" value="{{$quotation->project_name}}" id="projectname" placeholder="Project Name">
                            <label for="pname">Project Name</label>
                        </div>
                    </div>
                    <div class="col-md-3">
				<div class="sform-floating">
                        <select class="form-select" id="client_id" name="client_id"  aria-label="client" style="height: 40px;">
                            <option value="{{$selectedClients->id}}">{{$selectedClients->compnay_name}}</option>

                            @foreach ($clients as $c)
						  <option value="{{$c->id}}">{{$c->compnay_name}}</option>
						  @endforeach

                        </select>
					<label class="select_label" for="client_id">Client</label>
                    </div>
					  </div>
                    <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="start_date" value="{{$quotation->start_date}}"  id="start_date" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <label id="fstart_date" for="start_date">{{__('Start Date')}}</label>
                            </div>
                    </div>
                    <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="end_date" disabled value="{{$quotation->end_date}}"  id="end_date" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <label id="fstart_date" for="start_date">{{__('Due Date')}}</label>
                            </div>
                    </div>



                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="expected_hours" value="{{$quotation->expected_hours}}"  id="expected_hours" placeholder="Expected Hours">
                            <label for="expected_hours">Project Hours</label>
                        </div>
                    </div>

                    <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="price" value="{{$quotation->price}}"  id="price" placeholder="Price">
                                <label for="price">{{__('Total Price')}}</label>
                            </div>
                    </div>
				   <div class="col-md-3">
                       <div class="sform-floating">
                        <select class="form-select" id="currency_id" name="currency_id" aria-label="client" style="height: 40px;">
						  <option id="{{$quotation->currency->sp_value}}"  value="{{$quotation->currency->id}}">{{$quotation->currency->sp_value}} s.p ({{$quotation->currency->us_value}} $)</option>
                          @foreach ($currencies as $c)
						    @if($c->id != $quotation->currency->id)
							<option id="{{$c->sp_value}}"  value="{{$c->id}}">{{$c->sp_value}} s.p ({{$c->us_value}} $)</option>
							@endif
						  @endforeach
                        </select>
                        <label class="select_label" for="currency_id">Currency</label>
                   </div>
                    </div>
					 <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="admin_hours" value="{{$quotation->admin_hours}}" id="admin_hours" placeholder="Backup Hours">
                            <label for="admin_hours">Admin Hours</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" value="{{$quotation->end_admin_date}}"  name="admin_duedate" id="admin_duedate" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <label id="aduedate" for="start_date">{{__('Due Date By Admin')}}</label>
                            </div>
                    </div>



                </div>
                <div class="row">
                    <div class="col-md-4">
                                <label for="file-upload" class="custom-file-upload">
                                    <i><img src="{{asset('icons/attach.svg')}}" style="width:20px; height:20px;"/></i>
                                     Attach Project Image
                                </label>
                                <input class="" name="image" id="file-upload" type="file"/>
                        </div>

                </div>
            </div>

                <div id ="" class="collegues">
			         <div id="colleage2"></div>
                    <button id="assign" class="assign" style="background-color:white; border: 1px solid white;">
					@foreach($my_employees as $e)
					 <i><img class='' src='/storage/employee/{{$e->image}}' style='width:24px; height:24px; ' alt=profile></i>

					@endforeach
                       <i><img class="" src="{{ asset('icons/plus.svg')}}" style="width:10px; height:10px; " alt="profile"></i> Assign Employee
                    </button>
                </div>
                <div>

                </div>
                <!--div id="search_bar">
                    <form action="" method="get">
                        <input type="text" class="" placeholder="Search">
                    </form>

                </div>
                <button type="submit" id="search_btn">
                    <i><img class="" src="{{asset('icons/search_icon.svg')}}" style="width:17px; height:17px; " alt=""></i>
                </button-->

                <div class="tltbl">
                    <table class="tl-table" id="emptbl" style="margin-top:6%; margin-left:1%;">
                        <thead style="width: 1078px; height: 40px;">
                            <th width="446px">Employee Name</th>
                            <th width="273px">Timeline</th>
                            <th width="174px">Working Hours</th>
                            <th width="185px">Backup Hours</th>

                        </thead>
                        <tbody id="mytbody">
						@foreach($my_employees as $e)
							<tr>
								<td><i><img class='' src='/storage/employee/{{$e->image}}' style='' alt='profile'></i><span class='td_empname'>					{{$e->first_name}} {{$e->last_name}} </span></td>
								<td><span class='empprog_enddate'>0</span><center><div class='progress empprogress' style='height: 6.34px; border-radius: 5px;'><div class='progress-bar bg-warning' role='progressbar' style='width: 0% ;border-radius: 5px;' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div></div> </center></td>
								<td><span class='tl-text'>0/{{$e->expected_hours}}</span></td>
								<td><span class='tl-text'>0/{{$e->backup_hours}}</span></td>


						</tr>
						@endforeach
                        </tbody>
                    </table>
                </div>
        <div class="expected" id="expected_cost">
            Expected Cost : <span id="all_cost">{{$quotation->price}}</span> 
        </div>
        <div class="expected" id="expected_time">
            Expected Delivery Time :<span id="time_until"> {{$quotation->end_date}}</span>
        </div>
  <span id="myprice" hidden>0</span>
    <span id="spvalue" hidden>{{$quotation->priceSY}}</span>
   <input type="number" id="quotation_id" value="{{$quotation->id}}" hidden />
        @include('assignEModal')
        @include('employeeHoursModal')
<script>
$(document).ready(function(){
        $("#emptbl").DataTable();

        $("#emptbl_filter label").append("<i id='filter_icon'><img src='"+"{{asset('icons/search_icon.svg')}}" +"' style='width:17px; height:17px; ' alt=''></i>");
        $("#emptbl_filter input").attr("placeholder", "Search");


        $("#emptbl_length label").append( " of " + $("#emptbl").DataTable().column( 0 ).data().length );
        $("#clientsnum").html($("#emptbl").DataTable().column( 0 ).data().length);
});

const employees=[];
 <?php foreach($my_employees as $e){ ?>
        employees.push('<?php echo $e->id; ?>');
    <?php } ?>
   const hours=[];
  <?php foreach($my_employees as $e){ ?>
        hours.push('<?php echo $e->expected_hours; ?>');
    <?php } ?>
   const back=[];
   <?php foreach($my_employees as $e){ ?>
        back.push('<?php echo $e->backup_hours; ?>');
    <?php } ?>

   $( "#start_date" ).change(function() {
		  let sum_hours = 0;
		for (let x in hours) {

		  sum_hours = parseInt(sum_hours)+parseInt(hours[x]);
		}

		for (let x in back) {
		  sum_hours =parseInt(sum_hours)+ parseInt(back[x]);
		}
		document.getElementById("expected_hours").value=sum_hours;

		try{
			var dt = new Date(document.getElementById("start_date").value);
			var start_date = new Date(document.getElementById("start_date").value);
		}
		catch{
			dt= new Date();
			var start_date = new Date(document.getElementById("start_date").value);
		}
		var numOfHours = (sum_hours/8)*24+sum_hours%8; /// 8 hours full time
		var old_dt=dt;
		dt.setTime(dt.getTime() + numOfHours * 60 * 60 * 1000);
		var newdate=dt.getFullYear()+"/"+(dt.getMonth()+1)+"/"+dt.getDate();
		var fridy=getWeeksDiff(
				start_date, new Date(newdate)
			  );
		dt.setTime(dt.getTime() + fridy*24* 60 * 60 * 1000);

		newdate=dt.getFullYear()+"/"+(dt.getMonth()+1)+"/"+dt.getDate();

		document.getElementById("end_date").value=newdate;
        document.getElementById("time_until").innerHTML=newdate+" ("+parseInt(sum_hours/8)+" work day  and "+sum_hours%8+" hours)";
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
	var expected_hours=document.getElementById("expected_hours").value;
	var admin_hours=document.getElementById("admin_hours").value;
	var price=document.getElementById("price").value;
	var admin_duedate=document.getElementById("admin_duedate").value;
	var quotation_id=document.getElementById("quotation_id").value;

	var select = document.getElementById('currency_id');
	var currency_id = select.options[select.selectedIndex].value;
	let _token   = $('meta[name="csrf-token"]').attr('content');

	formdata.append("project_name", project_name);
	formdata.append("start_date", start_date);
	formdata.append("client_id", client_id);
	formdata.append("end_date", end_date);
	formdata.append("expected_hours", expected_hours);
	formdata.append("end_admin_date", admin_duedate);
    formdata.append("admin_hours", admin_hours);
	formdata.append("hours", JSON.stringify(hours));
	formdata.append("price", price);
	formdata.append("back", JSON.stringify(back));
	formdata.append("employees", JSON.stringify(employees));
	formdata.append("currency_id", currency_id);
	formdata.append("quotation_id", quotation_id);
	formdata.append("set", "0");
	formdata.append("_token", _token);


	 $.ajax({
        url: "{{route('quotation.myupdate')}}",
        type:"POST",
       data: formdata,
        processData: false,
        contentType: false,
        success:function(response){
          console.log(response);
		 window.location.href = "{{ route('quotation.index')}}";

        },
        error: function(error) {
         console.log(error);

        }
       });

		});


 $( "#add_new_btn_set" ).click(function() {
	var project_name=document.getElementById("projectname").value;
	var start_date=document.getElementById("start_date").value;
	var select = document.getElementById('client_id');
	var client_id = select.options[select.selectedIndex].value;
	var end_date=document.getElementById("end_date").value;
	var expected_hours=document.getElementById("expected_hours").value;
	var admin_hours=document.getElementById("admin_hours").value;
	var price=document.getElementById("price").value;
	var admin_duedate=document.getElementById("admin_duedate").value;
	var quotation_id=document.getElementById("quotation_id").value;

	var select = document.getElementById('currency_id');
	var currency_id = select.options[select.selectedIndex].value;
	let _token   = $('meta[name="csrf-token"]').attr('content');

	formdata.append("project_name", project_name);
	formdata.append("start_date", start_date);
	formdata.append("client_id", client_id);
	formdata.append("end_date", end_date);
	formdata.append("expected_hours", expected_hours);
	formdata.append("end_admin_date", admin_duedate);
    formdata.append("admin_hours", admin_hours);
	formdata.append("hours", JSON.stringify(hours));
	formdata.append("price", price);
	formdata.append("back", JSON.stringify(back));
	formdata.append("employees", JSON.stringify(employees));
	formdata.append("currency_id", currency_id);
	formdata.append("quotation_id", quotation_id);
	formdata.append("set", "1");
	formdata.append("_token", _token);


	 $.ajax({
        url: "{{route('quotation.myupdate')}}",
        type:"POST",
       data: formdata,
        processData: false,
        contentType: false,
        success:function(response){
          console.log(response);
		 window.location.href = "{{ route('quotation.index')}}";

        },
        error: function(error) {
         console.log(error);

        }
       });

		});


	function myprint(){
		document.getElementById("all_button").hidden=true;
		window.print();
	}
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
