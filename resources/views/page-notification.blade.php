
<div id="notification-box-success">
@if(config('global.notifications') !==null && config('global.notifications')!="")
					@foreach (config('global.notifications') as $n)
    <div>
        notification Box notification Box notification Box notification Box notification Box
    </div>
	@endforeach
				@endif
</div>

