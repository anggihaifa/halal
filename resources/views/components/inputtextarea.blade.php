
<label for="{{$name ?? ''}}" class="col-lg-4 col-form-label">{{$label}}</label>

<div class="col-lg-8">
    <textarea name="{{$name ?? ''}}" class="form-control"  id="{{$name ?? ''}}"
            {{ isset($required) && $required ? 'required' : '' }}
            {{ isset($disabled) && $disabled ? 'disabled' : '' }}
            {{ isset($readonly) && $readonly ? 'readonly' : '' }}>{!! isset($value) ? "$value" : '' !!}</textarea>        

</div>

