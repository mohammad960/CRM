@extends('employees.home.app')
   

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <style>
        
    </style>
@section('topnav')
<header class="dash-toolbar">

    <div class="main-label">
	    Notification
       
        
    </div>
    <div class="tools">
        @include('notification')
		@include('employees.home.header')
    </div>
</header>
@endsection
@section('main')

        <table class="notification-tbl" id="notif-tbl">
		@if(config('global.notifications') !==null && config('global.notifications')!="")
					@foreach (config('global.notifications') as $n)
            <tr>
                <td>
				{{$n->text}}
                </td>
                <td>
				{{$n->created_at}}
                </td>

            </tr>
        

            </tr>
				@endforeach
				@endif
        </table>
 
 
@endsection

<script>
/*
    $(document).ready(function(){
        $('#notif-tbl').DataTable({

        }); 
    });
*/
</script>