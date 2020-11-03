
    <label for="{{$name ?? ''}}" class="col-lg-2 col-form-label">{{$label}}</label>

    <div class="col-lg-4">
        <input name="{{$name ?? ''}}" type="text" class="form-control" rows="1" id="{{$name ?? ''}}"
                {{ isset($required) && $required ? 'required' : '' }}
                {{ isset($disabled) && $disabled ? 'disabled' : '' }}
                {{ isset($readonly) && $readonly ? 'readonly' : '' }}
                {!! isset($placeholder) ? "placeholder='$placeholder'" : '' !!}
                {!! isset($value) ? "value='$value'" : '' !!}>

    </div>

