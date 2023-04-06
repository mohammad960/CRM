<div id="clientModal" class="modal">

    <div id="clientsModal" class="modal-content">
        <div class="modal_title">
            Add New Client
        </div>
        <form action="{{route('client.store')}}" method="post">
			@csrf
            <div class="modal_inputs" style="100%">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="compnay_name" id="company" placeholder="Company Name" required>
                            <label for="company">Company Name</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                               <input type="text" class="form-control" name="country" id="country" placeholder="Country" required>
                            <label for="country">Country</label>
                          </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="working_domain" id="domain" placeholder="Working Domain" required>
                            <label for="domain">Working Domain</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="company_phone" id="CompanyPhone" placeholder="Company Phone" required>
                            <label for="CompanyPhone">Company Phone</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="first_name" id="firstname" placeholder="FP First Name"required>
                            <label for="firstname">FP First Name</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="last_name" id="lastname" placeholder="FP Last Name" required>
                            <label for="lastname">FP Last Name</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="position" id="position" placeholder="FP Position" required>
                            <label for="position">FP Position</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="phone" id="fpphone" placeholder="FP Phone" required>
                            <label for="fpphone">FP Phone</label>
                        </div>
                    </div>


                </div>

            </div>
            <div class="modal_btns">
                <a id="modal_cancel" class="modal_btn close"><i><img src="{{asset('icons/x.svg')}}" style="width:12px; height:12px;"/></i> Cancel</a>
                <button id="modal_save" class="modal_btn btnsave"><i><img src="{{asset('icons/okmark.svg')}}" style="width:20px; height:20px;"/></i> Save </button>
            </div>

        </form>


    </div>

  </div>
