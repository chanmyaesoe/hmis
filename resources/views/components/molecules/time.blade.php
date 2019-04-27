{{-- 
Parameters
$time: string <datetime>
$highlight_hours: boolean [default = false]
$highlight_minutes: boolean [default = false]
--}}
<div class="timebox">
    @php
        $carbon = \Carbon\Carbon::createFromTimeStamp(strtotime($time));
        $highlight_hours = isset($highlight_hours)? $highlight_hours : false;
        $highlight_minutes = isset($highlight_minutes)? $highlight_minutes : false;
    @endphp
    <span class="boxed-item{{ ($highlight_hours?' bg-dark text-white':'') }}">{{ $carbon->format($hoursFormat ?? 'h') }}</span> : 
    <span class="boxed-item{{ ($highlight_minutes?' bg-dark text-white':'') }}">{{ $carbon->format($minutesFormat ?? 'i') }}</span> 
    <span class="">{{ $carbon->format($meridianFormat ?? 'a') }}</span>
</div>