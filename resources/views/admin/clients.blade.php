@extends('admin.home.app')

@section('topnav')
<style>
    #cltbl_paginate{
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
    #cltbl_length{
        position: absolute;
        bottom:-60px;
        font-family: 'Cairo';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height:18px;

        color: #12171B;
    }
    #cltbl_info{
        display: none;
    }
    #cltbl_filter{
        position: absolute;
        top: -50px;
        right: 5px;

    }
    #cltbl_filter input{
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
    #cltbl_filter label{
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
    #cltbl_next , #cltbl_previous{
        width: 75px;
        background-color: white;
        margin-right: 0px;
        border-radius: 0 !important;
    }
    #cltbl_previous{
        padding-right:85px !important;
    }


    @media (max-width: 650px){

        #cltbl_filter{
            margin-top:-5%;
        }

    }
    @media (max-width: 350px){

        #cltbl{
            margin-top:20%;
        }

    }
</style>
<header class="dash-toolbar">


    <div class="main-label">
       <button id="add_new_btn">
        <i><img src="{{asset('icons/addbtn.svg')}}" style="width:20px; height:20px;"/></i> Add New Client
       </button>
    </div>
    <div class="tools">
        @include('notification')

       @include('admin.home.header')
    </div>
</header>
@endsection

@section('main')

                <p class="p1">Clients (<span id="clientsnum">{{count($clients)}}</span>)</p>

                <div class="clients_table">
                    <table class="pro-table" id="cltbl" style="padding-top:3%;">
                        <thead>
                            <th width="181px">Company Name</th>
                            <th width="170px">Domain</th>
                            <th width="132px">Country</th>
                            <th width="219px">FP Name</th>
                            <th width="167px">FP Phone</th>
                            <th width="136px">FP Position</th>
                            <th width="73px"></th>
                        </thead>
                        <tbody>
                          @foreach($clients as $p)
                        <tr>
						<td>{{$p['compnay_name']}}</td>
						<td>{{$p['working_domain']}}</td>
						<td>{{$p['country']}}</td>
						<td>{{$p['name']}}</td>
						<td>{{$p['company_phone']}}</td>
						<td>{{$p['position']}}</td>





						<td> <a href='client/{{$p["id"]}}/edit' style='color:#377CDB;'><i> <img class="delete_img" src="{{ asset('icons/edit.svg') }}"> </i></a>
							<a href='client/{{$p["id"]}}/destroy' style='color:#DC3545;'><i> <img class="delete_img" src="{{ asset('icons/delete.svg') }}"> </i></a></td>
						</tr>
						@endforeach
                        <a class="btn btn-danger" href="{{route('client.trashed')}}"> Trash <i class="fas fa-trash"></i></a>
                        </tbody>
                    </table>
                </div>
                @include('clientModal')
				@if(isset($client))
					@include('editClientModal')
				@endif
<script>
    $(document).ready(function(){
        $("#cltbl").DataTable({
            columnDefs: [
                            { orderable: false, targets: 4 },
                            { orderable: false, targets: 5 },
                            { orderable: false, targets: 6 }
                        ]
               });

        $('#cltbl_length label').html($('#cltbl_length label').html().replace("entries", "Entries"));
        $("#cltbl_filter label").append("<i id='filter_icon'><img src='"+"{{asset('icons/search_icon.svg')}}" +"' style='width:17px; height:17px; ' alt=''></i>");
        $("#cltbl_filter input").attr("placeholder", "Search");


        $("#cltbl_length label").append( " of " + $("#cltbl").DataTable().column( 0 ).data().length );
        //$("#clientsnum").html($("#cltbl").DataTable().column( 0 ).data().length);

    });
    var modal = document.getElementById("clientModal");

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

</script>
@endsection
