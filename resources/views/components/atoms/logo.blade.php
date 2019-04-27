{{-- 
Parameters
$width: string
$height: string
--}}
@php
    $attrs = isset($attrs) ? $attrs : [];
@endphp
<img src="{{ url('images/rpsgi-logo.png') }}" 
    @if(count($attrs) > 0)
        @foreach($attrs as $key => $value)
        {!! $key . '="' . addslashes($value) . '" ' !!} 
        @endforeach
    @endif
    width="{{ $width?:'' }}" height="{{ $height?:'' }}" />