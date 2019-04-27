<li class="dropdown user-menu">
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button">
        <img class="img-circle user-photo" src="{{ Auth::user()->photo_url }}" />
        <div class="employee-nav-header">
            {{ Auth::user()->{($menutitle ?? 'first_name')} }}
            <sup class="user-role">
                @if(Auth::user()->isHr())
                    HR
                @elseif(Auth::user()->isPayroll())
                    Payroll
                @elseif(Auth::user()->isManager())
                    Manager
                @elseif(Auth::user()->isSupervisor())
                    Supervisor
                @elseif(Auth::user()->isEmployee())
                    Employee
                @else
                    Applicant
                @endif
            </sup>
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-right" role="menu">
        <a href="{{ url( \Request::route()->getPrefix() . '/profile') }}" class="dropdown-item">
            <i class="fas fa-id-card-alt mr-1"></i> View Profile
        </a>
        <a href="{{ url( \Request::route()->getPrefix() . '/account') }}" class="dropdown-item">
            <i class="fas fa-user-cog mr-1"></i> Account Settings
        </a>
        <a href="javascript:void(0);" onclick="confirmLogout()" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-1"></i> Sign-out
        </a>
        <form id="logout-form" action="/logout" method="POST" style="display: none;">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>
</li>