@if($delta < 0)
    <span class="text-danger">{{number_format($delta, 2)}}</span>
@else
    <span class="text-success">{{number_format($delta, 2)}}</span>
@endif