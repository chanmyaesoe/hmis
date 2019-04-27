@if (Auth::user()->isHr() || Auth::user()->isManager() || Auth::user()->isSupervisor() || Auth::user()->isPayroll())
@php
    $access_count = 1;
    if (Auth::user()->isHr()) {
        $access_count++;
    }
    if (Auth::user()->isManager()) {
        $access_count++;
    }
    if (Auth::user()->isSupervisor()) {
        $access_count++;
    }
    if (Auth::user()->isPayroll()) {
        $access_count++;
    }
@endphp
<li class="dropdown app-switcher">
    <a href="#" id="switcherTrigger" class="nav-link switcher" data-toggle="dropdown" role="button">
        <span class="switcher-icon {{ ($switcherIcon ?? 'fas fa-th') }}" data-toggle="tooltip" data-placement="bottom" title="{{ ($tooltipText ?? 'Select Role') }}"></span>
    </a>
    <ul class="dropdown-menu app-switcher-menu dropdown-menu-right" role="menu" {!! ($access_count > 2? 'style="width: 210px !important;"' : '') !!}>
        @if (Auth::user()->isRole('admin') && !Request::is('admin*'))
            <li>
                <a href="{{ url('/admin') }}">
                    <i class="fab fa-black-tie"></i>
                    Admin
                </a>
            </li>
        @endif
        @if (Auth::user()->isHr() && !Request::is('hr*'))
            <li>
                <a href="{{ url('/hr') }}">
                    <i class="fas fa-users-cog"></i>
                    HR
                </a>
            </li>
        @endif
        @if (Auth::user()->isManager() && !Request::is('manager*'))
            <li>
                <a href="{{ url('/manager') }}">
                    <i class="fas fa-sitemap"></i>
                    Manager
                </a>
            </li>
        @endif
        @if (Auth::user()->isSupervisor() && !Request::is('supervisor*'))
            <li>
                <a href="{{ url('/supervisor') }}">
                    <i class="fas fa-user-friends"></i>
                    Supervisor
                </a>
            </li>
        @endif
        @if (Auth::user()->isPayroll() && !Request::is('payroll*'))
            <li>
                <a href="{{ url('/payroll') }}">
                    <i class="fas fa-wallet"></i>
                    Payroll
                </a>
            </li>
        @endif
        @if (Auth::user()->isEmployee() && !Request::is('employee*'))
            <li>
                <a href="{{ url('/employee') }}">
                    <i class="hricon-profile"></i>
                    Employee
                </a>
            </li>
        @endif
        @if (Auth::user()->isApplicant() && !Request::is('applicant*'))
            <li>
                <a href="{{ url('/applicant') }}">
                    <i class="hricon-profile"></i>
                    Applicant
                </a>
            </li>
        @endif
    </ul>
</li>
@endif