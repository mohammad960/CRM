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
    display:none;
        position: absolute;
        top: -50px;
        right: 5px;

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
    .dash-app{
        overflow-y:scroll;
        width:100%;
    }
    table tr td{
    margin-top:5px;
    padding-top:5px;
    }
    .hidden{
        display:none;
    }
    .rotate{
        transform:rotate(90deg);
    }
    .last img{
        float:right; 
        margin-right:20px;
        margin-top:4px;
    }
     .calendar{
        position:relative;
        top:30px;
        left: 80%;
        z-index:10;
    }
    </style>
<header class="dash-toolbar">
    
    <div class="main-label">
        <button class="btn-Report" id="addreport"> 
            <i><img src="{{asset('icons/setproject2.svg')}}" style="width:16px; height:20px;margin-right:4px;"/></i> Create New Reports
        </button>
    </div>
    <div class="tools">
   @include('notification')
	@include('admin.home.header')
    </div>
</header>
@endsection
@section('main')
                
                

               <div class="modal_inputs" style="padding-top:0; margin-bottom:2%;width:80%;">
                <div class="date-from-to">
                    <div class="date-from" style="margin-left:-2%;" >
                            <i class="calendar"> <img src="{{ asset('icons/calendar.svg') }}"></i>
                            <div class="form-floating">
                                
                                <input type="text" class="form-control" name="end_date" id="status_due_date" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <label class="date_label" id="fdue_date" for="due_date">{{__('From Date of')}}</label>
                            </div>
                    </div>
                    <div class="text-to" style="">
                        {{__('To')}}
                    </div>
                    <div class="date-to" style="position:relative; margin-left:-100px">
                            <i class="calendar"> <img src="{{ asset('icons/calendar.svg') }}"></i>
                            <div class="form-floating">
                                
                                <input type="text" class="form-control" name="end_date" id="due_date" placeholder=""onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                                <label class="date_label" id="fdue_date" for="due_date">{{__('To Date')}}</label>
                            </div>
                    </div>
                    
                </div>
                
                </div>

                <div style="width:25%; float:right; margin-top:-10%;padding-top:4%; z-index:1000;">
                    <div class="sform-floating">
                        <select class="form-select" id="employee_id" name="employee_id" aria-label="client" style="height: 40px;">
                          @foreach ($employees as $emp)
						  <option value="{{$emp->id}}">{{$emp->first_name}} </option>
						  @endforeach
                        </select>
                        <label class="select_label" for="employee_id">Employee</label>
                   </div>
                </div>
                </br>
                <div class="tltbl" style="margin-bottom:24px">
                    <table class="tl-table" id="report_tbl1" style="width:100%;margin-top:2%; margin-left:1%;">
                        <thead style="height: 40px;">
                            <th >Employee Name</th>
                            <th >Start Date</th>
                            <th >End date</th>

                        </thead>
                        <tbody>
                       	    <tr>
                                <td><img src="{{asset('images/company_logo_client.svg')}}" style=""/>  Mohamad Njeeb Shbib</td>
                                <td>1/1/2020</td>
                                <td>1/1/2020</td>


                            </tr>
                                <!--tr class="hidden" >
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                </tr-->

                            <tr>
                                <td><img src="{{asset('images/company_logo_client.svg')}}" style=""/>  Mohamad Njeeb Shbib</td>
                                <td>1/1/2020</td>
                                <td>1/1/2020</td>

                                <!--td class="last">VRoad Team <img style="" src="{{asset('icons/extend.svg')}}"></td-->

                            </tr>
                                <!--tr class="hidden" >
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>--</td>
                                    <td>
                                        --
                                    </td>                                    
                                    <td></td>
                                </tr-->
                        </tbody>
                    </table>

                    
                </div>
                
                @include('EreportModal')

                
<script>
$(document).ready(function(){

        $('td.last').on('click', function(){
            $(this).parent().next('tr').toggle();
            $(this).find('img').toggleClass( "rotate" )
        });

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

        $(".showPassword1").click(function() {
            $(this).toggle();
            $(this).next().toggle();
            $(this).next().next().toggle();
            $(this).next().next().next().toggle();
        });
        $(".hidePassword1").click(function() {
            $(this).toggle();
            $(this).prev().toggle();
            $(this).next().toggle();
            $(this).next().next().toggle();

        });

        var modal1 = document.getElementById("EreportModal");
        // Get the button that opens the modal
        var btn1 = document.getElementById("addreport");
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
</script>

@endsection
