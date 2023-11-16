<style>
    .form-group:not(.has-radio):not(.has-checkbox):not(.no-min-h) {
        min-height: 60px;
    }

    /*.modal-dialog.modal-md {*/
    /*    !*margin: 365px 0px 0px 279px;*!*/
    /*}*/

    .modal-content {
        width: 90%;
    }
</style>
<form action="{{route('create.batch.assign')}}" method="POST">
    @csrf
    @method('POST')
    <div class="modal-content" id="assign-batch">
        <div class="modal-header">
            <button type="button" class="close btn btn-sm " data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-12 ">
                        <h2 class="">Assign Batch to Joey</h2>
                        <input type="hidden" value="{{$batchId}}" name="batch_id">
                        <label for="joey_id"></label>
                        <select name="joey_id" id="assign_joey_id"
                                class="form-control form-control-lg role-type assign-joeys-list"
                                required>
                            <option value="" disabled selected>Select a joey</option>
                            @foreach($joeys as $joey)
                                <option value="{{$joey->id}}"> {{$joey->full_name}}</option>
                            @endforeach
                        </select>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-confirm">Assign</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade assign-mi-modal" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="" id="myModalLabel">Confirmation</h4>
                    <p class="">Are you sure to assign this Batch ? </p>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-toggle="modal">
                            Confirm <i class="fa fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>

    $(document).ready(function () {
        $('.assign-joeys-list').select2({
            minimumInputLength: 2,
            placeholder: "Search a joey to assign",
            allowClear: true,
            sorter: function (data) {
                return data.sort(function (a, b) {
                    return a.text < b.text ? -1 : a.text > b.text ? 1 : 0;
                });
            }
        });

        var modalConfirm = function (callback) {
            $("#btn-confirm").on("click", function () {

                document.getElementById("assign-batch").style.display = "none"
                $(".assign-mi-modal").modal('show');

                $("#modal-btn-si").on("click", function () {
                    callback(true);
                    $(".assign-mi-modal").modal('none');

                });

                $("#modal-btn-no").on("click", function () {
                    callback(false);
                    $(".assign-mi-modal").modal('hide');
                });


            });


        };

        modalConfirm(function (confirm) {

        });

    });

</script>
