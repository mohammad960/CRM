

        <div class="dropdown tools-item" >

            <a href="#" class="" id="notification_ring" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-left:-10px;">
                <i><img src="{{asset('icons/notification.svg')}}"/></i>
            </a>
			
            <div class="dropdown-menu dropdown-menu-notification" aria-labelledby="notification_ring">
              
				@if(config('global.notifications') !==null && config('global.notifications')!="")
					@foreach (config('global.notifications') as $n)
					<div class="notification-element" style="">

                    <a class="dropdown-item " href="{{$n->link}}">
                        <div class="dropdown-item-notification">{{$n->text}} 
                        </div>
                    </a>
                    <span class="notification-date">{{$n->created_at}}</span>
                </div>
                <hr class="notification-separator" style="" >
				@endforeach
				@endif
				@if(Auth::user()->role_id==1)
                <a class="dropdown-item " href="/admin/notifications">
			    @else
					     <a class="dropdown-item " href="/notifications">
				@endif
                        <div class="dropdown-item-notification">
                            View all 
                        </div>
                </a>
            </div>

        </div>

