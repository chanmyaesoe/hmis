{{-- 
Parameters
$employee: Employee
$passport: Passport
--}}
<div class="passport-card">
    <div class="heading">
        <span class="passport-label text-right pull-right"><i class="passport-icon fas fa-passport"></i> Passport</span>
        @php
        $country = $employee->country;
        if ($employee->employee_type == 'alien') {
            $country = $employee->country_from;
        }
        @endphp
        <span class="country">
            <span class="bfh-countries" data-country="{{ $country }}" data-flags="true"></span>
            @if($passport->attachment)
                <a class="attachment" href="{{ asset('storage/' . $passport->attachment) }}" data-toggle="tooltip" title="Attached File" target="_blank"><i class="fas fa-paperclip"></i></a>
            @endif
            @if(request()->route()->getPrefix() == "/visatracker")
                @if($passport->total_cost_spend)
                    <a href="javascript:void(0)" data-toggle="tooltip" title="₱ {{ number_format($passport->total_cost_spend, 2) }} total cost"><i class="fas fa-money-bill-wave"></i></a>
                @endif
                {!! (now()->gt($passport->expiry_date))? 
                    ' <a href="javascript:void(0)" class="text-danger" data-toggle="tooltip" data- title="Expired"><i class="fas fa-exclamation-triangle"></i></a>':
                    ' <a href="javascript:void(0)" data-toggle="tooltip" data-container="body" title="'. $passport->expiry_date->diff(now())->days .' '. str_plural('day', $passport->expiry_date->diff(now())->days) .' to expire"><i class="fas fa-exclamation-circle"></i></a>' !!}
            @endif
        </span>
    </div>
    <div class="passport-data">
        <div class="subheading">
            <span class="pull-right text-right">
                <span class="passport-photo-sm" style="background-image: url('{{ $employee->photo_url }}');"></span>
                <small class="data-label">Passport no.</small>
                <span class="data-value passport-no data-control-font">{{ $passport->passport_number }}</span>
                <sup class="data-value passport-no-sm">{{ $passport->passport_number }}</sup>
            </span>
            
            <i class="globe-icon fas fa-globe-asia"></i> 
            <table class="passport-summary">
                <tr>
                    <td>
                        <small class="data-label">Date of Issue</small>
                        <span class="data-value">{{ $passport->date_issue->format('d / m / Y') }}</span>
                    </td>
                    <td>
                        <small class="data-label">Date of Expiry</small>
                        <span class="data-value">{{ $passport->expiry_date->format('d / m / Y') }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <small class="data-label">Place of Issue</small>
                        <span class="data-value">{{ $passport->issue_place }}</span>
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