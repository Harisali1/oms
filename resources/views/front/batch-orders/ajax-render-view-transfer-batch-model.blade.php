<style>
    .form-group:not(.has-radio):not(.has-checkbox):not(.no-min-h) {
        min-height: 60px;
    }

    /*.modal-dialog.modal-md {*/
    /*    margin: 365px 0px 0px 279px;*/
    /*}*/

    .modal-content {
        width: 90%;
    }
</style>
<form action="{{route('transfer.batch')}}" method="POST">
    @csrf
    @method('POST')
    <div class="modal-content" id="transfer-batch">
        <div class="modal-header">
            <button type="button" class="close btn btn-sm " data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-12 ">
                        <h2 class="">Transfer Batch to Joey</h2>
                        <input type="hidden" value="{{$batchId}}" name="batch_id">
                        <label for="joey_id"></label>
                        <select name="joey_id" id="transfer_joey_id" class="form-control form-control-lg role-type transfer-joeys-list"
                                required>
                            @foreach($joeys as $joey)
                                <option value="" disabled selected></option>
                                <option value="{{$joey->id}}"> {{$joey->full_name}}</option>
                            @endforeach
                        </select>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-confirm-transfer">Transfer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade " tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
         aria-hidden="true"
         id="transfer-mi-modal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="" id="myModalLabel">Confirmation</h4>
                    <p class="">Are you sure to Transfer this Batch ? </p>
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
        $('.transfer-joeys-list').select2({
            minimumInputLength: 2,
            placeholder: "Search a joey to transfer",
            allowClear: true,

            sorter: function (data) {
                return data.sort(function (a, b) {
                    return a.text < b.text ? -1 : a.text > b.text ? 1 : 0;
                });
            }
        });
        var modalConfirm = function (callback) {

            $("#btn-confirm-transfer").on("click", function () {
                document.getElementById("transfer-batch").style.display = "none"

                $("#transfer-mi-modal").modal('show');
            });

            $("#T-modal-btn-yes").on("click", function () {
                callback(true);
                $("#transfer-mi-modal").modal('hide');
            });

            $("#T-modal-btn-no").on("click", function () {
                callback(false);
                $("#transfer-mi-modal").modal('hide');
            });
        };

        modalConfirm(function (confirm) {

        });

    });
</script>
