<style>
    .form-group:not(.has-radio):not(.has-checkbox):not(.no-min-h) {
        min-height: 60px;
    }

    .modal-content {
        width: 90%;
    }
</style>
<form action="{{route('create.batch')}}" method="post">
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
                        <div class="modal-body ">
                            <h2>Create Batch</h2>
                            <div class="form-group">

                                <label>Select Date</label>
                                <input class="form-control"
                                       value="{{ isset($_GET['datepicker'])?$_GET['datepicker']: date('Y-m-d') }}"
                                       type="date"
                                       id="date"
                                       name="sprint_order_dt">

                                <div class="" style="display: grid; grid-gap: 2%; grid-template-columns: 49% 49%;">
                                        <div class="form-group ">
                                            <label>Start Time </label>
                                            <input class="form-control col-12"
                                                   value="00:00"
                                                   type="time"
                                                   id="date"
                                                   name="sprint_order_dt_start">
                                        </div>
                                        <div class="form-group ">
                                            <label>End Time</label>
                                            <input class="form-control col-12"
                                                   value="23:59"
                                                   type="time"
                                                   id="date"
                                                   name="sprint_order_dt_end">
                                        </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Select Vendor</label>
                            <select name="store_num" id="store_num" class="form-control form-control-lg vendor-list"
                                    required>
                                <option value="" disabled selected>Select a Store</option>
                                @foreach($Vendor_name as $vendor)
                                    <option value="{{$vendor->id}}"> {{$vendor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class=" modal-body col-sm-12">
                        <button type="submit" class="btn btn-primary" data-toggle="modal">
                            Create <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>

<script>

    $(document).ready(function () {
        $('.vendor-list').select2({
            minimumInputLength: 2,
            placeholder: "Search a Vendor",
            allowClear: true,

            sorter: function (data) {

                return data.sort(function (a, b) {
                    return a.text < b.text ? -1 : a.text > b.text ? 1 : 0;
                });
            }
        });

    });
</script>

