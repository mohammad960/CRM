@extends('admin.home.app')
  <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>

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

        <table class="notification-tbl">
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

</script>