
<label for="{{$name ?? ''}}" class="col-lg-4 col-form-label">{{$label}}</label>

<div class="col-lg-8">
    <textarea name="{{$name ?? ''}}" class="form-control"  id="{{$name ?? ''}}" readonly>{!! isset($value) ? "$value" : '' !!}</textarea>        

</div>

