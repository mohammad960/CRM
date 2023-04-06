@extends('admin.home.app')

@section('topnav')
<style>

    #usrtbl_paginate{
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
    #usrtbl_length{
        position: absolute;
        bottom:-60px;
        font-family: 'Cairo';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height:18px;

        color: #12171B;
    }
    #usrtbl_info{
        display: none;
    }
    #usrtbl_filter{
        position: absolute;
        top: -50px;
        right: 5px;

    }
    #usrtbl_filter input{
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
    #usrtbl_filter label{
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
    #usrtbl_next , #usrtbl_previous{
        width: 75px;
        background-color: white;
        margin-right: 0px;
        border-radius: 0 !important;
    }

</style>

<style>

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
        margin-bottom:0px;
        font-family: 'Cairo';
        font-style: normal;
        font-weight: 400;
        font-size: 17px;
        line-height: 32px;
        /* identical to box height */
        color: #FFFFFF;
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


                <div class="users_table">
                    <table class="pro-table" id="usrtbl" style="padding-top:3%;">
                        <thead>

                            <th style="width:100px">Username</th>

                            <th style="width:150px"> <i><img class="" src="{{ asset('icons/cone.svg') }}" style="margin-right:5%" alt=""></i> Position</th>

                            <th  style="width: 20px; width=2%">Restore</th>


                        <tbody>

                   @foreach($user as $u)
				    <tr>
					<td><i>
                        @if ($u['image']==null)
                        <img class="" src="/storage/employee/2122136.png" style="" alt="profile"></i>

                        @else
                        <img class="" src="/storage/employee/{{$u['image']}}" style="" alt="profile"></i>
                        @endif

                        {{$u['user_name']}}</td>



					<td>{{$u['employee']['position']['part_project']}}</td>


                        <td> <a href='/admin/user/{{$u["id"]}}/restore' style='color:#377CDB;'><i> <img class="delete_img" src="{{ asset('icons/edit.svg') }}"> </i></a>
                    </td>
					</tr>
				   @endforeach
                </thead>
                        </tbody>
                    </table>
                </div>


                <script>
                    $(document).ready(function(){

                        $('#usrtbl').DataTable({
                        initComplete: function () {
                            this.api()
                                .columns(3)
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
                        columnDefs: [
                                            { orderable: false, targets: [1, 3, 7] }
                                        ]
                         });

                        //$("#usrtbl").DataTable();

                        $('#usrtbl_length label').html($('#usrtbl_length label').html().replace("entries", "Entries"));
                        $("#usrtbl_filter label").append("<i id='filter_icon'><img src='"+"{{asset('icons/search_icon.svg')}}" +"' style='width:17px; height:17px; ' alt=''></i>");
                        $("#usrtbl_filter input").attr("placeholder", "Search");


                        $("#usrtbl_length label").append( " of " + $("#usrtbl").DataTable().column( 0 ).data().length );
                        var old_text = "";
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

                    });
                    var modal = document.getElementById("userModal");

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

                    var date = document.getElementById("start_date");
                    var datelabel = document.getElementById("fstart_date");
                    date.addEventListener('change', function(){
                        if(date.value.length > 0){
                            datelabel.classList.add("lfocused");
                        }
                        else{
                            datelabel.classList.remove("lfocused");
                        }
                    });


                </script>
@endsection
