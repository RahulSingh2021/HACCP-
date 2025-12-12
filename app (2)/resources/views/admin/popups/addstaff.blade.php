<div class="modal fade" id="addnewstaff" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                         <form></form>
                        <form method="post" action="{{route('add_staff')}}">
                            @csrf
                    <div class="row">
                        
          
                        <div class="mb-12 col-md-12">
                            <label class="form-label">Name:</label>
                            <input type="text" class="form-control"  name="name" placeholder="" required="">
                            @if($errors->has('name'))
    <div class="error">{{ $errors->first('name') }}</div>
@endif
                        </div>
                        <div class="mb-3 col-md-12 text-center">
                            <hr>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>