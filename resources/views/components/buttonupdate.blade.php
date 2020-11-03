<button type="submit" class="btn btn-success" id="{{$id ?? 'submitButton'}}" {{ isset($name) ? "name=$name" : ""}} {{ isset($value) ? "value=$value" : ""}}>
    <i class="fa fa-arrow-up"></i>&nbsp;&nbsp;&nbsp;{{$label ?? 'Update'}}</button>
