
<label for="{{$name ?? ''}}" class="col-lg-4 col-form-label">{{$label}}</label>

<div class="col-lg-8">
    <input name="{{$name ?? ''}}" type="text" class="form-control" rows="1" id="{{$name ?? ''}}" placeholder="x.x.x.x.x"
            {{ isset($required) && $required ? 'required' : '' }}
            {{ isset($disabled) && $disabled ? 'disabled' : '' }}
            {{ isset($readonly) && $readonly ? 'readonly' : '' }}
            {!! isset($value) ? "value='$value'" : '' !!}>

</div>

