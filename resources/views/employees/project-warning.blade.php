@extends('employees.home.app')

@section('topnav')
<header class="dash-toolbar">

    <div class="main-label">
       ERP Project
       <div class="duedate-progress">
        <div class="progress" style="height: 6.34px; border-radius: 5px; width: 177px;">
            <div class="progress-bar bg-warning" role="progressbar" style="width: 50% ;border-radius: 5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>

        </div>
        <span class="duedatelabel">
            Due Date 22/7/2021
        </span>
       </div>
    </div>
    <div class="tools">
        @include('notification')
        @include('employees.home.header')
        
    </div>
</header>
@endsection
@section('main')
                @include('warning')
                <div class="collegues">
                    <i><img class="" src="../../images/profile.png" style="width:24px; height:24px; " alt="profile"></i>
                    <i><img class="" src="../../images/profile.png" style="width:24px; height:24px; " alt="profile"></i>
                    <i><img class="" src="../../images/profile.png" style="width:24px; height:24px; " alt="profile"></i>
                    <i><img class="" src="../../images/profile.png" style="width:24px; height:24px; " alt="profile"></i>
                    <i><img class="" src="../../images/profile.png" style="width:24px; height:24px; " alt="profile"></i>
                </div>
                <div id="search_bar">
                    <form action="" method="get">
                        <input type="text" class="" placeholder="Search">
                    </form>

                </div>
                <button type="submit" id="search_btn">
                    <i><img class="" src="{{asset('icons/search_icon.svg')}}" style="width:17px; height:17px; " alt=""></i>
                </button>
                <div class="tltbl">
                    <table class="tl-table">
                        <thead style="width: 1078px; height: 40px;">
                            <th width="634px">Timeline</th>
                            <th width="209px">Working Hours</th>
                            <th width="235px">Backup Hours</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                     <span class="tlprog_enddate">20/40</span>
                                    <center>
                                    <div class="progress tlprogress" style="height: 6.34px; border-radius: 5px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 50% ;border-radius: 5px;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div> </center>
                                </td>
                                <td><span class="tl-text">20/40</span></td>
                                <td><span class="tl-text">0/40</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="task-list">

                    <table class="tasks-table">
                        <thead  style="width: 1096; height: 40px;">
                            <tr>
                            <th width="660px">List of My Tasks</th>
                            <th width="120px">Start Date</th>
                            <th width="112px">End Date</th>
                            <th width="96px">Start Time</th>
                            <th width="108px">End Time</th>
                        </tr>
                        <tr style="height: 16px;"></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Example Task one
                                </td>
                                <td>
                                    2022/5/12
                                </td>
                                <td>
                                    2022/5/12
                                </td>
                                <td>
                                    10:00 AM
                                </td>
                                <td>
                                    4:00 PM
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Create a reminder, then look at it in your inbox
                                </td>
                                <td>
                                    2022/5/12
                                </td>
                                <td>
                                    2022/5/12
                                </td>
                                <td>
                                    10:00 AM
                                </td>
                                <td>
                                    4:00 PM
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Duplicate a view, then drag it to a different Location
                                </td>
                                <td>
                                    2022/5/12
                                </td>
                                <td>
                                    2022/5/12
                                </td>
                                <td>
                                    10:00 AM
                                </td>
                                <td>
                                    4:00 PM
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Create a reminder, then look at it in your inbox
                                </td>
                                <td>
                                    2022/5/12
                                </td>
                                <td>
                                    2022/5/12
                                </td>
                                <td>
                                    10:00 AM
                                </td>
                                <td>
                                    4:00 PM
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @include('reminder', ['c' => 0])
@endsection
