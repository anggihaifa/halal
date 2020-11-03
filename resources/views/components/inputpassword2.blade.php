
<label for="{{$name ?? ''}}" class="col-lg-4 col-form-label">{{$label}}</label>

<div class="col-lg-8">
    <input name="{{$name}}" type="password" class="form-control" rows="1" id="{{$name}}"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password harus terdiri dari huruf, huruf kapital, angka, dan minimal terdapat 8 karakter" required>
</div>

