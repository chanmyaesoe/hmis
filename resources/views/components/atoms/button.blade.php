{{-- 
Parameters
$type: string ['button' | 'submit'] (default -> 'button')
$label: string (default -> 'Save') // accepts html
$submittingLabel: string [default -> '<span class="spinner"><span></span><span></span><span></span></span> Please wait...'] // accepts html * only for submit button
$class: string (default -> 'btn-primary')
$attrs: array of attributes (default -> [])
--}}
@php
    $type = isset($type) ? $type : 'button';
    $label = isset($label) ? $label : 'Save';
    $submittingLabel = isset($submittingLabel) ? $submittingLabel : '<span class="spinner"><span></span><span></span><span></span></span> Please wait...';
    $class = isset($class) ? $class : 'btn-primary';
    $attrs = isset($attrs) ? $attrs : [];
@endphp
<button type="{{ $type }}" data-submit-label="{{ htmlentities($label, ENT_QUOTES) }}" 
    {!! ($type == 'submit'? 'data-submitting-label="'. htmlentities($submittingLabel, ENT_QUOTES) .'"' : '') !!} 
    @if(count($attrs) > 0)
        @foreach($attrs as $key => $value)
        {!! $key . '="' . addslashes($value) . '" ' !!} 
        @endforeach
    @endif
    class="hris-btn btn {{ $class }}">{!! $label !!}</button>