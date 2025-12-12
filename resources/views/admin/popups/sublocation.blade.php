 <div class="modal fade" id="add_sublocation" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Sub Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                         <form></form>
                        <form method="post" action="{{route('locationform')}}">
                            @csrf

                            <input type="hidden" name="location_id" id="location_id" value="">
                    <div class="row">
                        <div class="mb-12 col-md-12">
                            <label class="form-label"> New Sub Location:</label>
                            <input type="text" class="form-control"   name="name" placeholder="" required="">
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