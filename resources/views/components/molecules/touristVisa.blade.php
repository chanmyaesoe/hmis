{{-- 
Parameters
$employee: Employee
$tourist_visa: TouristVisa
--}}
<div class="passport-card tourist-visa">
    <div class="heading">
        <span class="passport-label text-right pull-right"><i class="passport-icon fas fa-plane-departure"></i> Tourist Visa</span>
        @php
        $country = $employee->country;
        if ($employee->employee_type == 'alien') {
            $country = $employee->country_from;
        }
        @endphp
        <span class="country">
            <span class="bfh-countries" data-country="{{ $country }}" data-flags="true"></span>
            @if(request()->route()->getPrefix() == "/visatracker" && $tourist_visa->attachment)
                <a class="attachment" href="{{ asset('storage/' . $tourist_visa->attachment) }}" target="_blank" data-toggle="tooltip" title="Attached File"><i class="fas fa-paperclip"></i></a>
            @endif
            @if(request()->route()->getPrefix() == "/visatracker")
                @if($tourist_visa->total_cost)
                    <a href="javascript:void(0)" data-toggle="tooltip" title="₱ {{ number_format($tourist_visa->total_cost, 2) }} total cost"><i class="fas fa-money-bill-wave"></i></a>
                @endif
                {!! (now()->gt($tourist_visa->expiry_date))? 
                    ' <a href="javascript:void(0)" class="text-danger" data-toggle="tooltip" data-container="body" data- title="Expired"><i class="fas fa-exclamation-triangle"></i></a>':
                    ' <a href="javascript:void(0)" data-toggle="tooltip" data-container="body" data- title="'. $tourist_visa->expiry_date->diff(now())->days .' '. str_plural('day', $tourist_visa->expiry_date->diff(now())->days) .' to expire"><i class="fas fa-exclamation-circle"></i></a>' !!}
            @endif
        </span>
    </div>
    <div class="passport-data">
        <div class="subheading">
            <span class="pull-right text-right">
                <small class="data-label">Card no.</small>
                <span class="data-value passport-no data-control-font">{{ $tourist_visa->card_number }}</span><br>
                <sup class="data-value passport-no-sm">{{ $tourist_visa->card_number }}</sup>
            </span>
            
            <i class="globe-icon fas fa-globe-americas"></i> 
            <table class="passport-summary">
                <tr>
                    <td>
                        <small class="data-label">Date of Issue</small>
                        <span class="data-value">{{ $tourist_visa->date_issue->format('d / m / Y') }}</span>
                    </td>
                    <td>
                        <small class="data-label">Date of Expiry</small>
                        <span class="data-value">{{ $tourist_visa->expiry_date->format('d / m / Y') }}</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <small class="data-label">Visa Issued On</small>
                        <span class="data-value">{{ $tourist_visa->visa_issued_on->format('d / m / Y') }}</span>
                    </td>
                    <td>
                        <small class="data-label">Visa Valid Until</small>
                        <span class="data-value">{{ $tourist_visa->visa_valid_until->format('d / m / Y') }}</span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="passport-photo pull-right" style="background-image: url('{{ $employee->photo_url }}');"></div>

        <p>
            <small class="data-label">Full name</small>
            <span class="data-value text-uppercase">{{ $employee->full_name }}</span>
        </p>

        <p>
            <span class="pull-right text-right">
                <small class="data-label">Gender</small>
                <span class="data-value text-uppercase">{{ $employee->gender == 'male' ? 'M' : 'F' }}</span>
            </span>

            <small class="data-label">Date of Birth</small>
            <span class="data-value text-uppercase">{{ $employee->birthdate->format('d / m / Y') }}</span>
        </p>
        <p>
            <span class="pull-right text-right">
                <small class="data-label">Nationality</small>
                <span class="data-value text-uppercase">{{ $employee->nationality }}</span>
            </span>

            <small class="data-label">Place of Birth</small>
            <span class="data-value text-uppercase">{{ $employee->birthplace }}&nbsp;</span>
        </p>
    </div>
</div>