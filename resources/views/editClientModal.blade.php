<div id="editClientModal" class="modal" style="display:block;">

    <div id="clientsModal" class="modal-content">
        <div class="modal_title">
            Edit Client
        </div>
        <form action="{{route('client.update',$client)}}" method="post">
 {{ csrf_field() }}
	{{ method_field('PATCH') }}
            <div class="modal_inputs">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="compnay_name"  value="{{$client->compnay_name}}" id="company" placeholder="Company Name">
                            <label for="company">Company Name</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                           <input type="text" class="form-control" name="country" value="{{$client->country}}" id="country" placeholder="Country">
                            <label for="country">Country</label>
                          </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="working_domain" value="{{$client->working_domain}}" id="domain" placeholder="Working Domain">
                            <label for="domain">Working Domain</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="company_phone" value="{{$client->company_phone}}" id="CompanyPhone" placeholder="">
                            <label for="CompanyPhone">Company Phone</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="first_name" value="{{$client->first_name}}" id="firstname" placeholder="FP First Name">
                            <label for="firstname">FP First Name</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="last_name" value="{{$client->last_name}}" id="lastname" placeholder="FP Last Name">
                            <label for="lastname">FP Last Name</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="position" value="{{$client->position}}" id="position" placeholder="FP Position">
                            <label for="position">FP Position</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="phone" value="{{$client->phone}}" id="fpphone" placeholder="FP Phone">
                            <label for="fpphone">FP Phone</label>
                        </div>
                    </div>


                </div>

            </div>
            <div class="modal_btns">
                <button id="modal_cancel" class="modal_btn close"><i><img src="{{asset('icons/x.svg')}}" style="width:12px; height:12px;"/></i> cancel</button>
                <button id="modal_save" class="modal_btn btnsave"><i><img src="{{asset('icons/okmark.svg')}}" style="width:20px; height:20px;"/></i> Save </button>
            </div>

        </form>


    </div>

  </div>
