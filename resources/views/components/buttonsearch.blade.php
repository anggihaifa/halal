<button type="submit" class="btn btn-lime" id="{{$id ?? 'submitButton'}}" {{ isset($name) ? "name=$name" : ""}} {{ isset($value) ? "value=$value" : ""}}>
    <i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;{{$label ?? 'Search'}}</button>
