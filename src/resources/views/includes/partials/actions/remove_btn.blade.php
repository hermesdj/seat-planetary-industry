@php
    if(!isset($cssClass)) {
        $cssClass = '';
    }
@endphp
<button
        type="button"
        data-toggle="modal"
        data-target="{{$dataTarget}}"
        class="btn btn-sm btn-link {{$cssClass}}"
        data-route="{{$route}}"
        @isset($title)
            data-modal-title="{{$title}}"
        @endisset
        @isset($notice)
            data-modal-notice="{{$notice}}"
        @endisset
>
    @isset($icon)
        <i class="fas {{$icon}}" data-toggle="tooltip" data-placement="top"
           title="{{ $tooltip }}"></i>
    @else
        <i class="fas fa-trash-alt text-danger" data-toggle="tooltip" data-placement="top"
           title="{{ $tooltip }}"></i>
    @endisset
</button>
