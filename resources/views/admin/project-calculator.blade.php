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
        right: 5px;

    }
    #emptbl_filter input{
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
    #emptbl_filter label{
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
        width:1078px;
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


    </style>
<header class="dash-toolbar">

    <div class="main-label" style="width:500px">
       <button id="add_new_btn" style="width:83px; height:41px">
        <i><img src="{{asset('icons/okmark.svg')}}" style="width:20px; height:20px;"/></i> Save
       </button>
       <button id="add_new_btn_set" style="width:118px; height:41px;color: #003D6A; background-color:white; border:1px solid #003D6A">
        <i><img src="{{asset('icons/setproject.svg')}}" style="width:20px; height:20px;"/></i> Set a Project
       </button>
       <button id="add_new_btn_print" style="width:83px; height:41px;color: #003D6A; background-color:white; border:1px solid #003D6A">
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
                Add New Quotation
            </div>
            <div class="modal_inputs" >
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="project_name" id="project_name" placeholder="Project Name">
                            <label for="pname">Project Name</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="client_id" name="client_id" aria-label="client" style="height: 40px;">
                          @foreach ($clients as $c)
						  <option value="{{$c->id}}">{{$c->compnay_name}}</option>
						  @endforeach

                        </select>

                    </div>

                    <div class="col-md-3">

                            <div class="form-floating">

                                <input type="text" class="form-control" name="start_date" id="start_date" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <label id="fstart_date" for="start_date">{{__('Start Date')}}</label>
                            </div>
                    </div>
                    <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="end_date" id="end_date" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <label id="fstart_date" for="start_date">{{__('Due Date')}}</label>
                            </div>
                    </div>



                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="expected_hours" id="expected_hours" placeholder="Expected Hours">
                            <label for="expected_hours">Expected Hours</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="admin_hours" id="admin_hours" placeholder="Backup Hours">
                            <label for="admin_hours">Admin Hours</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="price" id="price" placeholder="Price">
                                <label for="price">{{__('Price')}}</label>
                            </div>
                    </div>
					   <div class="col-md-3">
                        <select class="form-select" id="currency_id" name="currency_id" aria-label="client" style="height: 40px;">
                          @foreach ($currencies as $c)
						  <option value="{{$c->id}}">{{$c->sp_value}} s.p ({{$c->us_value}} $)</option>
						  @endforeach

                        </select>

                    </div>
                    <div class="col-md-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="admin_duedate" id="admin_duedate" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
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
            Expected Delivery Time :
        </div>
  <span id="myprice" hidden></span>
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
   const hours=[];
   const back=[];
   const formdata = new FormData();
    jQuery("#file-upload").on("change", function() {
		 var file = this.files[0];
		 formdata.append("image", file);
	});


	 $("#add_new_btn_set").click(function() {
	var project_name=document.getElementById("project_name").value;
	var start_date=document.getElementById("start_date").value;
	var select = document.getElementById('client_id');
	var client_id = select.options[select.selectedIndex].value;
	var end_date=document.getElementById("end_date").value;
	var expected_hours=document.getElementById("expected_hours").value;
	var admin_hours=document.getElementById("admin_hours").value;
	var price=document.getElementById("price").value;
	var admin_duedate=document.getElementById("admin_duedate").value;
	var set="1";

	var select = document.getElementById('currency_id');
	var currency_id = select.options[select.selectedIndex].value;
	let _token   = $('meta[name="csrf-token"]').attr('content');

	formdata.append("project_name", project_name);
	formdata.append("start_date", start_date);
	formdata.append("client_id", client_id);
	formdata.append("set", set);
	formdata.append("end_date", end_date);
	formdata.append("expected_hours", expected_hours);
	formdata.append("end_admin_date", admin_duedate);
    formdata.append("admin_hours", admin_hours);
	formdata.append("hours", JSON.stringify(hours));
	formdata.append("price", price);
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
         console.log(error);

        }
       });

		});
   $( "#add_new_btn" ).click(function() {
	var project_name=document.getElementById("project_name").value;
	var start_date=document.getElementById("start_date").value;
	var select = document.getElementById('client_id');
	var client_id = select.options[select.selectedIndex].value;
	var end_date=document.getElementById("end_date").value;
	var expected_hours=document.getElementById("expected_hours").value;
	var admin_hours=document.getElementById("admin_hours").value;
	var price=document.getElementById("price").value;
	var admin_duedate=document.getElementById("admin_duedate").value;
	var set="0";

	var select = document.getElementById('currency_id');
	var currency_id = select.options[select.selectedIndex].value;
	let _token   = $('meta[name="csrf-token"]').attr('content');

	formdata.append("project_name", project_name);
	formdata.append("start_date", start_date);
	formdata.append("client_id", client_id);
	formdata.append("set", set);
	formdata.append("end_date", end_date);
	formdata.append("expected_hours", expected_hours);
	formdata.append("end_admin_date", admin_duedate);
    formdata.append("admin_hours", admin_hours);
	formdata.append("hours", JSON.stringify(hours));
	formdata.append("price", price);
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
         console.log(error);

        }
       });

		});
    // When the user clicks anywhere outside of the modal, close it
    function EHM(id,image,first,last,price){

		document.getElementById("emp_id").innerHTML=id;
		document.getElementById("all_name").innerHTML=first+" "+last;
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
