{{-- 
Parameters
$employee: Employee
$working_visa: WorkingVisa
--}}

<div class="passport-card working-visa">
    <div class="heading">
        <span class="passport-label text-right pull-right"><i class="passport-icon fas fa-id-card"></i> Working Visa</span>
        @php
        $country = $employee->country;
        if ($employee->employee_type == 'alien') {
            $country = $employee->country_from;
        }
        @endphp
        <span class="country">
            <span class="bfh-countries" data-country="{{ $country }}" data-flags="true"></span>
            @if(request()->route()->getPrefix() == "/visatracker" && $working_visa->attachment)
                <a class="attachment" href="{{ asset('storage/' . $working_visa->attachment) }}" data-toggle="tooltip" title="Attached File" target="_blank"><i class="fas fa-paperclip"></i></a>
            @endif
            @if(request()->route()->getPrefix() == "/visatracker")
                @if($working_visa->total_cost)
                    <a href="javascript:void(0)" data-toggle="tooltip" title="₱ {{ number_format($working_visa->total_cost, 2) }} total cost"><i class="fas fa-money-bill-wave"></i></a>
                @endif
                {!! (now()->gt($working_visa->expiry_date))? 
                    ' <a href="javascript:void(0)" class="text-danger" data-toggle="tooltip" data-container="body" data- title="Expired"><i class="fas fa-exclamation-triangle"></i></a>':
                    ' <a href="javascript:void(0)" class="attachment" data-toggle="tooltip" data-container="body" data- title="'. now()->diffForHumans($working_visa->expiry_date) .' the expiry date"><i class="fas fa-exclamation-circle"></i></a>' !!}
            @endif
        </span>
    </div>
    <div class="passport-data">
        <div class="subheading">
            <span class="pull-right text-right">
                <small class="data-label">Visa no.</small>
                <span class="data-value passport-no data-control-font">{{ $working_visa->visa_number }}</span><br>
                <sup class="data-value passport-no-sm">{{ $working_visa->visa_number }}</sup>
            </span>
            
            <i class="globe-icon fas fa-globe"></i> 
            <table class="passport-summary">
                <tr>
                    <td>
                        <small class="data-label">Date of Issue</small>
                        <span class="data-value">{{ $working_visa->date_issue->format('d / m / Y') }}</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <small class="data-label">Validity</small>
                        <span class="data-value">{{ $working_visa->valid_date->format('d / m / Y') }}</span>
                    </td>
                    <td>
                        <small class="data-label">Date of Expiry</small>
                        <span class="data-value">{{ $working_visa->expiry_date->format('d / m / Y') }}</span>
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

            <small class="data-label">Position</small>
            <span class="data-value text-uppercase">{{ $working_visa->position }}</span>
        </p>
        <p>
            <span class="pull-right text-right">
                <small class="data-label">Nationality</small>
                <span class="data-value text-uppercase">{{ $employee->nationality }}</span>
            </span>

            @if(request()->route()->getPrefix() == "/visatracker")
            <small class="data-label">Declared Salary</small>
            <span class="data-value text-uppercase">₱ {{ number_format($working_visa->declared_salary, 2) }}&nbsp;</span>
            @else
            <small class="data-label">TIN</small>
            <span class="data-value text-uppercase">{{ $employee->tin }}&nbsp;</span>
            @endif
        </p>
    </div>
</div>