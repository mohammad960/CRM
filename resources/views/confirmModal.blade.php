<div id="mconfirm" class="modal" >
    <div id="depatrmentsModal" class="modal-content">
        <div class="modal_title">
            Confirm Accepted Overtime Hours
        </div>
         <form action="{{route('salary.overtime')}}" method="post">
          @csrf
            <div class="modal_inputs">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
							  <input type="text" id="salary_id_over" class="form-control" name="id" hidden />
                            <input type="text" class="form-control" name="c_hours"  placeholder="Accepted Overtime Hours"/>
                            <label for="c_hours">Accepted Overtime Hours</label>
                        </div>
                    </div>
                </div>
			</div>
				<div class="modal_btns">
					<a id="modal_cancel" class="modal_btn close"><i><img src="{{asset('icons/x.svg')}}" style="width:12px; height:12px;"/></i> cancel</a>
					<button id="modal_save" class="modal_btn btnsave"><i><img src="{{asset('icons/okmark.svg')}}" style="width:20px; height:20px;"/></i> Save </button>
				</div>
			
        </form>

 </div>

 </div>

