<label for="{{$name ?? ''}}" class="col-lg-4 col-form-label">{{$label}}</label>

<div class="col-lg-8">
    <input name="{{$name ?? ''}}" type="file" accept="image/*" onchange="loadFile(event)" rows="1" id="{{$name ?? ''}}"
            {{ isset($required) && $required ? 'required' : '' }}
            {{ isset($disabled) && $disabled ? 'disabled' : '' }}
            {{ isset($readonly) && $readonly ? 'readonly' : '' }}
            {!! isset($placeholder) ? "placeholder='$placeholder'" : '' !!}
            {!! isset($value) ? "value='$value'" : '' !!}>
    
        
           
            <p><img id="output" width="100"/></p>
       

</div>

