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
    @media (max-width: 720px){
        .main-label{
            margin-top:20%;
        }
        #add_new_qout{
            margin-top:15%;
        }
    }
    @media (max-width: 275px){
        .main-label{
            margin-top:30%;
        }
        #add_new_qout{
            margin-top:50%;
        }
    }
    .form-error{
        border: 1px solid #F06A6A !important;
        color: #F06A6A !important;
    }
    .error-message{
        color: #F06A6A;
        font-size:12px !important;
        margin-left:5%;
        font-family: 'Cairo';
        font-style: normal;
        font-weight: 400;
    }
    .error{
        color: #F06A6A !important;
    }
    </style>
	 <ul id="error" style="background-color:red;width:50%;margin-left:2%;margin-top:2%;" hidden></ul>
	<header class="dash-toolbar">

    <div class="main-label" style="width:500px">
       <button id="add_new_btn" class="new_btn" style="width:83px; height:41px">
        <i><img src="{{asset('icons/okmark.svg')}}" style="width:20px; height:20px;"/></i> Save
       </button>
       <button id="add_new_btn_set" class="new_btn" style="width:118px; height:41px;color: #003D6A; background-color:white; border:1px solid #003D6A">
        <i><img src="{{asset('icons/setproject.svg')}}" style="width:20px; height:20px;"/></i> Set a Project
       </button>
       <button id="add_new_btn"  class="new_btn" style="width:83px; height:41px;color: #003D6A; background-color:white; border:1px solid #003D6A">
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
              <?php $table_employees=[];?>
            <div id="add_new_qout">
                Add New Quotation
            </div>

            <div class="modal_inputs">


                <div class="row">
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="project_name" id="projectname" placeholder="Project Name">
                            <label for="projectname">Project Name</label>
                            <p class="error-message"></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="sform-floating">
                        <select class="form-select" id="client_id" name="client_id" aria-label="Floating label select example" style="height: 40px;">
                          @foreach ($clients as $c)
						  <option value="{{$c->id}}">{{$c->compnay_name}}</option>
						  @endforeach

                        </select>
                        <label class="select_label" for="client_id">Client</label>
                        <p class="error-message"></p>
                        </div>
                    </div>

                    <div class="col-md-3">
                            <i class="calendar"> <img src="{{ asset('icons/calendar.svg') }}"></i>
                            <div class="form-floating">
                                <input type="text" class="form-control" name="start_date" id="start_date" placeholder="Start Date" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <label class="date_label" id="fstart_date" for="start_date">{{__('Start Date')}}</label>
                                <p class="error-message"></p>
                            </div>
                    </div>
                    <div class="col-md-3">
                    <i class="calendar"> <img src="{{ asset('icons/calendar.svg') }}"></i>
                            <div class="form-floating">
                                <input type="text" class="form-control" name="end_date" disabled id="end_date" placeholder="Due Date" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <label class="date_label" id="fstart_date" for="start_date">{{__('Due Date')}}</label>
                                <p class="error-message"></p>
                            </div>
                    </div>



                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="expected_hours" id="expected_hours" placeholder="Expected Hours">
                            <label for="expected_hours">Project Hours</label>
                            <p class="error-message"></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="admin_hours" id="admin_hours" placeholder="Backup Hours">
                            <label for="admin_hours">Admin Hours</label>
                            <p class="error-message"></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="price" id="price" placeholder="Price">
                                <label for="price">{{__('Total Price')}}</label>
                                <p class="error-message"></p>
                            </div>
                    </div>
					   <div class="col-md-3">
                       <div class="sform-floating">
                        <select class="form-select" id="currency_id" name="currency_id" aria-label="client" style="height: 40px;">
                          @foreach ($currencies as $c)
						  <option id="{{$c->sp_value}}" value="{{$c->id}}">{{$c->sp_value}} s.p ({{$c->us_value}} $)</option>
						  @endforeach
                        </select>
                        <label class="select_label" for="currency_id">Currency</label>
                        <p class="error-message"></p>
                   </div>
                    </div>
                    <div class="col-md-3">
                            <i class="calendar"> <img src="{{ asset('icons/calendar.svg') }}"></i>
                            <div class="form-floating">
                                <input type="text" class="form-control" name="admin_duedate" id="admin_duedate" placeholder="Due Date By Admin" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <label class="date_label" id="aduedate" for="admin_duedate">{{__('Due Date By Admin')}}</label>
                                <p class="error-message"></p>
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
                                <p class="error-message"></p>
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



                        </tbody>
                    </table>
                </div>
        <div class="expected" id="expected_cost">
            Expected Cost : <span id="all_cost">0</span> 
        </div>
        <div class="expected" id="expected_time">
            Expected Delivery Time :<span id="time_until"> </span>
        </div>
  <span id="myprice" hidden>0</span>
  <span id="spvalue" hidden>0</span>
        @include('assignEModal')
        @include('employeeHoursModal')
<script>
$(document).ready(function(){
        $("#emptbl").DataTable();

        $("#emptbl_filter label").append("<i id='filter_icon'><img src='"+"{{asset('icons/search_icon.svg')}}" +"' style='width:17px; height:17px; ' alt=''></i>");
        $("#emptbl_filter input").attr("placeholder", "Search");


        $("#emptbl_length label").append( " of " + $("#emptbl").DataTable().column( 0 ).data().length );
        $("#clientsnum").html($("#emptbl").DataTable().column( 0 ).data().length);
		var today=new Date();
		today=today.getFullYear()+"/"+(today.getMonth()+1)+"/"+today.getDate();
		document.getElementById("start_date").value=today;
		document.getElementById("mytbody").innerHTML="";
});
	const employees=[];
	const hours=[];
	const back=[];
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
	var set="0";
	var expected_hours=document.getElementById("expected_hours").value;
	var admin_hours=document.getElementById("admin_hours").value;
	var price=document.getElementById("price").value;
	var admin_duedate=document.getElementById("admin_duedate").value;
	var select = document.getElementById('currency_id');
	var currency_id = select.options[select.selectedIndex].value;
	var cost = document.getElementById("all_cost").innerHTML;
    ///// reset validation //////
	$('.error-message').html("");
    $('.form-error').toggleClass('form-error');
    $('.error').toggleClass('error');
    ///////////////////////////////


	let _token   = $('meta[name="csrf-token"]').attr('content');
	if(project_name==""){
        $('#projectname').toggleClass('form-error');
        $('#projectname').next().toggleClass('error');
        $('#projectname').next().next().html("Enter Project Name");
        /*
		document.getElementById("error").innerHTML="<li>Enter Project Name</li>";
		document.getElementById("error").hidden=false;
        */
		return 0;
	}
	if(start_date==""){
        $('#start_date').toggleClass('form-error');
        $('#start_date').next().toggleClass('error');
        $('#start_date').next().next().html("Enter Start Date");
        /*
		document.getElementById("error").innerHTML="<li>Enter Start Date</li>";
		document.getElementById("error").hidden=false;*/
		return 0;
	}
	if(end_date==""){
        $('#end_date').toggleClass('form-error');
        $('#end_date').next().toggleClass('error');
        $('#end_date').next().next().html("Enter End Date");
        /*
		document.getElementById("error").innerHTML="<li>Enter End Date</li>";
		document.getElementById("error").hidden=false;*/
		return 0;
	}

	if(expected_hours==""){
        $('#expected_hours').toggleClass('form-error');
        $('#expected_hours').next().toggleClass('error');
        $('#expected_hours').next().next().html("Enter Expected Hours");
        /*
		document.getElementById("error").innerHTML="<li>Enter Expected Hours</li>";
		document.getElementById("error").hidden=false;*/
		return 0;
	}
	if(admin_hours==""){
        $('#admin_hours').toggleClass('form-error');
        $('#admin_hours').next().toggleClass('error');
        $('#admin_hours').next().next().html("Enter Admin Hours");
        /*
		document.getElementById("error").innerHTML="<li>Enter Admin Hours</li>";
		document.getElementById("error").hidden=false;*/
		return 0;
	}
  if(price==""){
        $('#price').toggleClass('form-error');
        $('#price').next().toggleClass('error');
        $('#price').next().next().html("Enter Price");
        /*
		document.getElementById("error").innerHTML="<li>Enter Price</li>";
		document.getElementById("error").hidden=false;*/
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
        //console.log();

			//console.log(error.responseJSON);
        /*  document.getElementById("error").innerHTML="<li>"+error.responseJSON.message+"</li>";
			document.getElementById("error").hidden=false;
         */
         if("project_name" in error.responseJSON.errors){
            var msg = error.responseJSON.errors["project_name"][0];
            //console.log(''+msg);
            $('#projectname').toggleClass('form-error');
            $('#projectname').next().toggleClass('error');
            $('#projectname').next().next().html(''+error.responseJSON.errors["project_name"][0]);
         }
         if("start_date" in error.responseJSON.errors){

            $('#start_date').toggleClass('form-error');
            $('#start_date').next().toggleClass('error');
            $('#start_date').next().next().html(error.responseJSON.errors["start_date"][0]);
         }
         if("end_date" in error.responseJSON.errors){
            $('#end_date').toggleClass('form-error');
            $('#end_date').next().toggleClass('error');
            $('#end_date').next().next().html(error.responseJSON.errors["end_date"][0]);
         }
         if("expected_hours" in error.responseJSON.errors){
            $('#expected_hours').toggleClass('form-error');
            $('#expected_hours').next().toggleClass('error');
            $('#expected_hours').next().next().html(error.responseJSON.errors["expected_hours"][0]);
         }
         if("admin_hours" in error.responseJSON.errors){
            $('#admin_hours').toggleClass('form-error');
            $('#admin_hours').next().toggleClass('error');
            $('#admin_hours').next().next().html(error.responseJSON.errors["admin_hours"][0]);
         }
         if("price" in error.responseJSON.errors){
            $('#price').toggleClass('form-error');
            $('#price').next().toggleClass('error');
            $('#price').next().next().html(error.responseJSON.errors["price"][0]);
         }


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
	formdata.append("projectname", project_name);
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
