<style>
    /*.custom-alert-wrap {*/
        /*z-index: 999;*/
        /*position: fixed;*/
        /*top: 0px;*/
        /*width: 100%;*/
        /*margin: 0px;*/
        /*border-radius: 0px;*/
    /*}*/
</style>

@if (isset($errors) && count($errors) > 0)
    <div class="alert alert-danger custom-alert-wrap">
        <button type="button" class="close"  data-dismiss="alert" aria-hidden="true">X</button>
        @foreach ($errors->all() as $error)
            {{ $error }}<br />
        @endforeach
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger custom-alert-wrap">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
        {!! Session::pull('error') !!}
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success custom-alert-wrap">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        {!! Session::pull('success') !!}
    </div>
@endif