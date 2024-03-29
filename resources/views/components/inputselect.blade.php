<label for="{{$name ?? ''}}" class="col-lg-4 col-form-label">{{$label}}</label>

<div class="col-lg-8">
    <select id="{{$name}}" name="{{$name}}" class="form-control selectpicker" data-size="10" data-live-search="true" data-style="btn-white"
            {{ isset($required) ? 'required' : '' }}
            {{ isset($onchange) ? 'onchange=' . $onchange : '' }}
    >
        <option value="">--Pilih {{$label}}--</option>
        @if(isset($options))
            @foreach($options as $index => $value)
              
                <option value="{{$value[$key ?? 'id']}}" {{ isset($disabledOption) && $disabledOption == $value[$key ?? 'id'] ? 'disabled' : '' }}>{{$value[isset($labelKey) ? $labelKey : 'name']}}</option>
            @endforeach
        @endif
    </select>
</div>

