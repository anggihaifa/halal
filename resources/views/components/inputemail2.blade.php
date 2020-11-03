<label for="{{$name ?? ''}}" class="col-lg-4 col-form-label">{{$label}} <span id="{{$labelid}}" style="padding-left: 7px;"></span></label>

<div class="col-lg-8">
    <input name="{{$name}}" type="email" class="form-control" rows="1" id="{{$name}}" {{ isset($required) ? 'required' : '' }} {!! isset($value) ? "value='$value'" : '' !!}>
</div>

