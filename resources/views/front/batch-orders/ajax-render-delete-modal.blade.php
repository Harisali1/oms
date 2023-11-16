<style>
    .form-group:not(.has-radio):not(.has-checkbox):not(.no-min-h) {
        min-height: 60px;
    }

    .modal-content {
        width: 90%;
    }
</style>

<form action="{{ route('success.Unassigned.batch') }}" method="POST">
    @csrf
    @method('DELETE')
    <input type="hidden" id="" name="order_id" value="{{$order_id}}">


    <div class="modal-content">
        <div class=" modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-12 ">
                        <h2 class="" id="myModalLabel">Batch Delete</h2>
                        <p class="">Are you sure to Delete this Batch ? </p>
                        <div class="modal-footer col-sm-12">
                            <button type="submit" class="btn btn-primary" data-toggle="modal">
                                Confirm <i class="fa fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
