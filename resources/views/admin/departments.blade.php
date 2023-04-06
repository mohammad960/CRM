@extends('admin.home.app')

@section('topnav')
<style>
    #deptbl_paginate{
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
    #deptbl_length{
        position: absolute;
        bottom:-60px;
        font-family: 'Cairo';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height:18px;

        color: #12171B;
    }
    #deptbl_info{
        display: none;
    }
    #deptbl_filter{
        position: absolute;
        top: -50px;
        right: 5px;

    }
    #deptbl_filter input{
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
    #deptbl_filter label{
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
    #deptbl_next , #deptbl_previous{
        width: 75px;
        background-color: white;
        margin-right: 0px;
        border-radius: 0 !important;
    }

</style>
<header class="dash-toolbar">


    <div class="main-label">
       <button id="add_new_btn">
        <i><img src="{{asset('icons/addbtn.svg')}}" style="width:20px; height:20px;"/></i> Add New Department
       </button>

    </div>
    <div class="tools">
        @include('notification')
        @include('admin.home.header')
    </div>
</header>
@endsection

@section('main')
                <p class="p1">Departments (<span id="usersnum">{{count($departments)}}</span>)</p>

                <div class="clients_table">
                    <table class="pro-table" id="deptbl" style="padding-top:3%;">
                        <thead>

                            <th width="165px">Department</th>

                            <th style="width: 20px; width=2%">Edit</th>
                            <th  style="width: 20px; width=2%">Delete</th>
                        </thead>
                        <a class="btn btn-danger" href="{{route('department.trashed')}}"> Trash <i class="fas fa-trash"></i></a>
                        <tbody>
                       @foreach ($departments as $d)
					   <tr>
					   <td>{{$d->name}}</td>
					   <td><a href='/admin/department/{{$d->id}}/edit' style='color:#377CDB;'><i class=''><img class="delete_img" src="{{ asset('icons/edit.svg') }}" ></i></a></td>
                       <td>  <a href="/admin/department/{{$d['id']}}/destroy" style='color:#DC3545;'><i> <img class="delete_img" src="{{ asset('icons/delete.svg') }}"> </i></a></td>
					   </tr>
					   @endforeach

                        </tbody>
                    </table>
                </div>
				@if(isset($department))
					@include('modal.department.depatrmentEdit')
				@endif
                @include('modal.department.depatrmentModal')

<script>



    $(document).ready(function(){



        $('#deptbl').DataTable({
            columnDefs: [
                            { orderable: false, targets: 1 }
                        ]
         });
        $('#deptbl_length label').html($('#deptbl_length label').html().replace("entries", "Entries"));
        $("#deptbl_filter label").append("<i id='filter_icon'><img src='"+"{{asset('icons/search_icon.svg')}}" +"' style='width:17px; height:17px; ' alt=''></i>");
        $("#deptbl_filter input").attr("placeholder", "Search");
        $("#deptbl_length label").append( " of " + $("#deptbl").DataTable().column( 0 ).data().length );




        var modal1 = document.getElementById("depatrmentModal");
        // Get the button that opens the modal
        var btn1 = document.getElementById("add_new_btn");
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




    /*
    var modal = document.getElementById("depatrmentModal");

    // Get the button that opens the modal
    var btn = document.getElementById("add_new_btn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
    modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
    modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    */


    function edit(){
        var modal1 = document.getElementById("depatrmentModal");
        var modal2 = document.getElementById("editProjectModal");

        var span2 = document.getElementsByClassName("close")[1];
        // When the user clicks the button, open the modal
        modal2.style.display = "block";
        // When the user clicks on <span> (x), close the modal
        span2.onclick = function() {
        modal2.style.display = "none";
        }
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {

            if(event.target == modal2) {
                modal2.style.display = "none";
            }
            else if(event.target == modal1) {
                modal1.style.display = "none";
            }
        }

        }



    var sdate = document.getElementById("start_date");
    var sdatelabel = document.getElementById("fstart_date");
    sdate.addEventListener('change', function(){
        if(sdate.value.length > 0){
            sdatelabel.classList.add("lfocused");
        }
        else{
            sdatelabel.classList.remove("lfocused");
        }
    });
    var ddate = document.getElementById("due_date");
    var ddatelabel = document.getElementById("fdue_date");
    ddate.addEventListener('change', function(){
        if(ddate.value.length > 0){
            ddatelabel.classList.add("lfocused");
        }
        else{
            ddatelabel.classList.remove("lfocused");
        }
    });

</script>
@endsection
