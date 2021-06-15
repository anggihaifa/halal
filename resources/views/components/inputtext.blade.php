
    <label for="{{$name ?? ''}}" class="col-lg-4 col-form-label">{{$label}}</label>

    <div class="col-lg-8">
        <input name="{{$name ?? ''}}" type="text" class="form-control" rows="1" id="{{$name ?? ''}}"
                {{ isset($required) && $required ? 'required' : '' }}
                {{ isset($disabled) && $disabled ? 'disabled' : '' }}
                {{ isset($readonly) && $readonly ? 'readonly' : '' }}
                {{ isset($hidden) && $hidden ? 'hidden' : '' }}
                {!! isset($placeholder) ? "placeholder='$placeholder'" : '' !!}
                {!! isset($value) ? "value='$value'" : '' !!}>

    </div>

