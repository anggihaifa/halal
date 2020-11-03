<label class="col-lg-4 col-form-label">{{$label}}</label>
<div id="sh" class="col-lg-8">
    <input type="text" class="form-control" {!! isset($value) ? "value='$value'" : '' !!} readonly/>
</div>