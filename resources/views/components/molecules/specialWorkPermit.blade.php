{{-- 
Parameters
$employee: Employee
$special_work_permit: SWP
--}}
<div class="passport-card special-work-permit">
    <div class="heading">
        <span class="passport-label text-right pull-right"><i class="passport-icon fas fa-id-card-alt"></i> Special Work Permit</span>
        @php
        $country = $employee->country;
        if ($employee->employee_type == 'alien') {
            $country = $employee->country_from;
        }
        @endphp
        <span class="country">
            <span class="bfh-countries" data-country="{{ $country }}" data-flags="true"></span>
            @if($special_work_permit->attachment)
                <a class="attachment" href="{{ asset('storage/' . $special_work_permit->attachment) }}" data-toggle="tooltip" title="Attached File" target="_blank"><i class="fas fa-paperclip"></i></a>
            @endif
            @if(request()->route()->getPrefix() == "/visatracker")
                @if($special_work_permit->total_cost)
                    <a href="javascript:void(0)" data-toggle="tooltip" title="₱ {{ number_format($special_work_permit->total_cost, 2) }} total cost"><i class="fas fa-money-bill-wave"></i></a>
                @endif
                {!! (now()->gt($special_work_permit->expiry_date))? 
                    ' <a href="javascript:void(0)" class="text-danger" data-toggle="tooltip" data-container="body" data- title="Expired"><i class="fas fa-exclamation-triangle"></i></a>':
                    ' <a href="javascript:void(0)" data-toggle="tooltip" data-container="body" data- title="'. now()->diffForHumans($special_work_permit->expiry_date) .' the expiry date"><i class="fas fa-exclamation-circle"></i></a>' !!}
            @endif
        </span>
    </div>
    <div class="passport-data">
        <div class="subheading">
            <span class="pull-right text-right">
                <small class="data-label">Serial no.</small>
                <span class="data-value passport-no data-control-font">{{ $special_work_permit->serial_number }}</span><br>
                <sup class="data-value passport-no-sm">{{ $special_work_permit->serial_number }}</sup>
            </span>
            
            <i class="globe-icon fas fa-globe-africa"></i> 
            <table class="passport-summary">
                <tr>
                    <td>
                        <small class="data-label">Valid Date</small>
                        <span class="data-value">{{ $special_work_permit->valid_date->format('d / m / Y') }}</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <small class="data-label">Date of Expiry</small>
                        <span class="data-value">{{ $special_work_permit->expiry_date->format('d / m / Y') }}</span>
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

            @if(request()->route()->getPrefix() == "/visatracker")
                <small class="data-label">Position</small>
                <span class="data-value text-uppercase">{{ $special_work_permit->position }}</span>
            @else
                <small class="data-label">Date of Birth</small>
                <span class="data-value text-uppercase">{{ $employee->birthdate->format('d / m / Y') }}</span>
            @endif
        </p>
        <p>
            <span class="pull-right text-right">
                <small class="data-label">Nationality</small>
                <span class="data-value text-uppercase">{{ $employee->nationality }}</span>
            </span>

            @if(request()->route()->getPrefix() == "/visatracker")
                <small class="data-label">Date of Birth</small>
                <span class="data-value text-uppercase">{{ $employee->birthdate->format('d / m / Y') }}</span>
            @else
                <small class="data-label">Place of Birth</small>
                <span class="data-value text-uppercase">{{ $employee->birthplace }}&nbsp;</span>
            @endif
        </p>
    </div>
</div>