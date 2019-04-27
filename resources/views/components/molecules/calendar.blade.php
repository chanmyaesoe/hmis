{{-- 
Parameters
$date: string <datetime>
--}}
<div class="d-inline-block">
    <div class="calendarbox">
        @php
            $carbon = \Carbon\Carbon::createFromTimeStamp(strtotime($date));
        @endphp
        <div class="date-holder">
            <div class="dayofweek">{{ $carbon->format($dayOfWeekFormat ?? 'l') }}</div>
            <div class="data-date">
                <div class="data-month">{{ $carbon->format($monthFormat ?? 'M') }}</div>
                <div class="data-day">{{ $carbon->format($dayFormat ?? 'd') }}</div> 
                <div class="data-year">{{ $carbon->format($yearFormat ?? 'Y') }}</div>
            </div>
        </div>
    </div>
</div>