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

    }
    #projecttbl_filter input{
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
    #projecttbl_filter label{
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
    #projecttbl_next , #projecttbl_previous{
        width: 75px;
        background-color: white;
        margin-right: 0px;
        border-radius: 0 !important;
    }
    #projecttbl_previous{
    padding-right:85px !important;
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



    <div class="tools">
        @include('notification')
		@include('admin.home.header')
    </div>
</header>
@endsection

@section('main')

                <p class="p1">Projects (<span id="usersnum">{{count($projects)}}</span>)</p>

                <div class="clients_table">
                    <table class="pro-table" id="projecttbl" style="padding-top:3%;">
                        <thead>

                            <th width="165px">Project Name</th>
                            <th style="width:130px"> <i><img class="" src="{{ asset('icons/cone.svg') }}" style="margin-right:10%" alt=""></i>Client</th>
                            <th width="199px">Start Date</th>
                            <th width="157px">Due Date</th>
                            <th width="161px">Admin Hours</th>
							 <th width="161px">Project Hours</th>
                            <th width="145px">Total Price</th>
                            <th width="73px"></th>
                        </thead>
                        <tbody>
						@foreach($projects as $p)
                        <tr>

						<td><i><img class="" src="/storage/quotation/{{$p['image']}}" style="" alt=""></i><a href="project/{{$p['id']}}/show">{{$p['project_name']}}</a></td>
						<td>{{$p['client']}}</td>
						<td>{{$p['start_date']}}</td>
						<td>{{$p['end_date']}}</td>
						<td>{{$p['admin_hours']}}</td>
						<td>{{$p['expected_hours']}}</td>
						<td>{{$p['price']}} </td>
                        <td> <a href='/admin/project/{{$p["id"]}}/restore' style='color:#377CDB;'><i> <img class="delete_img" src="{{ asset('icons/edit.svg') }}"> </i></a>

						</tr>
						@endforeach

                        </tbody>
                    </table>
                </div>

				@if(isset($project))
					@include('editProjectModal')
				@endif

<script>



    $(document).ready(function(){

        $('#projecttbl').DataTable({
        initComplete: function () {
            this.api()
                .columns(1)
                .every(function () {
                    var column = this;
                    var select = $('<select class="sort_select" style="width:30%; border:none; background-color:#F1F1F1; margin-left:2px;"><option value=""></option>'
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
                            select.append('<option value="' + d + '">' + d + '</option>');
                        });
                });
            },
            "columns": [
                {"name": "1", "orderable": true},
                {"name": "2", "orderable": false},
                {"name": "3", "orderable": true},
                {"name": "4", "orderable": true},
                {"name": "5", "orderable": true},
                {"name": "6", "orderable": true},
                {"name": "7", "orderable": true},
                {"name": "8", "orderable": false}
                ],


        });

        //$("#usrtbl").DataTable();
        $('#projecttbl_length label').html($('#projecttbl_length label').html().replace("entries", "Entries"));
        $("#projecttbl_filter label").append("<i id='filter_icon'><img src='"+"{{asset('icons/search_icon.svg')}}" +"' style='width:17px; height:17px; ' alt=''></i>");
        $("#projecttbl_filter input").attr("placeholder", "Search");


        $("#projecttbl_length label").append( " of " + $("#projecttbl").DataTable().column( 0 ).data().length );





    });

    var modal1 = document.getElementById("projectModal");
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

/*
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
*/
</script>
@endsection
