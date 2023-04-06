<div id="depatrmentEdit" class="modal" style="display:block;">
    <div id="depatrmentsEdit" class="modal-content">
        <div class="modal_title">
            Add New Depatrment
        </div>
         <form action="{{route('department.update',$department->id)}}" method="post">
          @csrf
		  	{{ method_field('PATCH') }}
            <div class="modal_inputs">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="name" value="{{$department->name}}" id="pname" placeholder="Depatrment Name"/>
                            <label for="pname">Depatrment Name</label>
                        </div>
                    </div>
                </div>
			</div>
				<div class="modal_btns">
					<a href="/admin/department" id="modal_cancel" class="modal_btn close"><i><img src="{{asset('icons/x.svg')}}" style="width:12px; height:12px;"/></i> cancel</a>
					<button id="modal_save" class="modal_btn btnsave"><i><img src="{{asset('icons/okmark.svg')}}" style="width:20px; height:20px;"/></i> Save </button>
				</div>

        </form>

 </div>

 </div>

