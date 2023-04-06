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
        top: -80%;
        right: 5px;

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
    #add_new_qout{
        font-family: 'Cairo';
        font-style: normal;
        font-weight: 400;
        font-size: 20px;
        line-height: 120%;
        /* identical to box height, or 24px */

        letter-spacing: 0.125em;

        color: #151B26;
        padding-bottom: 16px;
    }
    #edit_btn{
    width: 68px;
    height: 24px;
    background: #FFFFFF;
    /* Brand Colors */
    padding:0;
    border: 1px solid #003D6A;
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
    color: #003D6A;
    margin-right:8px;
    }
    #set_btn{
    width: 104px;
    height: 24px;
    /* Brand Colors */

    background: #003D6A;
    /* Brand Colors */

    border: 1px solid #003D6A;
    border-radius: 5px;
    font-family: 'Cairo';
    font-style: normal;
    font-weight: 400;
    font-size: 13.5177px;
    line-height: 25px;
    text-align: center;
    padding:0;
    /* White */

    color: #FFFFFF;
    }
    .btn-img{
        border-radius: 0px;
    }
     @media (max-width: 1090px){
        #emptbl{
            margin-top:10% !important;
        }
     }
     td button{
        height:30px !important;
     }
    @media (max-width: 950px){

        #emptbl{
            margin-top: 12% !important;
        }
    }
    @media (max-width: 500px){

        #emptbl{
            margin-top: 30% !important;
        }
        #add_new_qout{
            margin-top: 5% !important;
        }
    }
    @media (max-width: 400px){

        #emptbl{
            margin-top: 40% !important;
        }

    }
    @media (max-width: 350px){

        #emptbl{
            margin-top: 50% !important;
        }
        #add_new_qout{
            margin-top: 10% !important;
        }
    }
    @media (max-width: 300px){

        #emptbl{
            margin-top: 60% !important;
        }

    }
    </style>
<header class="dash-toolbar">

    <div class="main-label">
     Projects Calculator

    </div>

    <div class="tools">
    @include('notification')
		@include('admin.home.header')
    </div>
</header>
@endsection
@section('main')

                <div id="add_new_qout">
                Saved Quotations
            </div>

                <div class="tltbl">
                    <table class="tl-table" id="emptbl" style="margin-top:4%; margin-left:1%;">
                        <thead style="width: 1078px; height: 40px;">
                            <th width="314px">Project Nameee</th>
                            <th width="139px">Project Hours</th>
                            <th width="142px">Admin Hours</th>
                            <th width="149px">Expected Cost</th>
                            <th width="137px">Total Price</th>

                            <th style="width:200px"></th>
                        </thead>
                        <tbody>
                       @foreach ($quotations as $q)
					   <tr>

					   <td> <i>

                        @if ($q->image==null)
                        <img class="" src="/storage/quotation/2122136.png" style="" alt="profile"></i>

                        @else
                        <img class="" src="/storage/quotation/{{$q->image}}" style="" alt="profile"></i>
                        @endif





                       </i><span class='td_empname'> {{$q->project_name}} </span></td>
					   <td><span class='tl-text'>{{$q->expected_hours}} Hours</span> </td>
					   <td><span class='tl-text'>{{$q->admin_hours}} Hours</span> </td>
					   <td>
                            <i class="showPassword" style="float:right;"><img src="{{ asset('icons/eye-show.svg') }}"></i>
                            <i class="hidePassword" style="float:right; display:none"><img src="{{ asset('icons/eye-hide.svg') }}" style=""></i>
                            <span class='tl-text'> {{$q->cost}}  </span>
                            <span class="" style="display:none;"> * </span>
                        </td>

					   <td>
                            <i class="showPassword" style="float:right;"><img src="{{ asset('icons/eye-show.svg') }}"></i>
                            <i class="hidePassword" style="float:right; display:none"><img src="{{ asset('icons/eye-hide.svg') }}" style=""></i>
                            <span class='tl-text'>{{$q->price}} </span>
                            <span class="" style="display:none;"> * </span>
                       </td>
					   <td><button id='edit_btn'> <i><img class="btn-img" src="{{asset('icons/edit.svg')}}" style='width:12px; height:12px;'/></i><a href="quotation/{{$q->id}}/edit"> Edit</a></button>
					   @if($q->set_project==0)
						   <button id='set_btn' onclick="set_proj({{$q->id}})">
						   <i><img src="{{asset('icons/setproject2.svg')}}" style='width:12px; height:12px;'/></i> Set a Project</button>

					   @endif
					   </td>
					   </tr>
					   @endforeach
                        </tbody>
                    </table>
                </div>

<script>
$(document).ready(function(){

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
        $("#emptbl").DataTable({
        columnDefs: [
                            { orderable: false, targets: 5 }
                        ]
        });

        $("#emptbl_filter label").append("<i id='filter_icon'><img src='"+"{{asset('icons/search_icon.svg')}}" +"' style='width:17px; height:17px; ' alt=''></i>");
        $("#emptbl_filter input").attr("placeholder", "Search");


        $("#emptbl_length label").append( " of " + $("#emptbl").DataTable().column( 0 ).data().length );
        $("#clientsnum").html($("#emptbl").DataTable().column( 0 ).data().length);
});
function set_proj(id){
	 $.ajax({
        url: "{{route('setProject')}}",
        type:"POST",
       data: {
		   quotation_id:id,
	   },
        success:function(response){
          console.log(response);
		 window.location.href = "{{ route('quotation.index')}}";

        },
        error: function(error) {
         console.log(error);

        }
       });
};
</script>

@endsection
