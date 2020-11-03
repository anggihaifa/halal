<button type="submit" class="btn btn-success" id="{{$id ?? 'submitButton'}}" {{ isset($name) ? "name=$name" : ""}} {{ isset($value) ? "value=$value" : ""}}>
    <i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;{{$label ?? 'Submit'}}</button>
