
<label for="{{$name ?? ''}}" class="col-lg-4 col-form-label">{{$label}}</label>

<div class="col-lg-8">
    <input name="{{$name}}" type="password" class="form-control" rows="1" id="{{$name}}" minlength="8" pattern=".{8,}" title="8 or more characters" required>
</div>

