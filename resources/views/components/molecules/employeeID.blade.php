{{-- 
Parameters
$employee: Employee
--}}
<div class="employee-card">
    <div class="jumbotron shadow">
        @php
            $employeeAccess = \App\Models\AccessLevel::where('menu_name', 'Employees')->first();
        @endphp
        @endphp
        @if (in_array(request()->route()->getPrefix(), ['/admin', '/visatracker'])
            || (request()->route()->getPrefix() == '/manager' && $employeeAccess->manager_read_access)
            || (request()->route()->getPrefix() == '/supervisor' && $employeeAccess->supervisor_read_access)
        )
        <div class="employee-actions">
            <a href="{{ url(request()->route()->getPrefix()) }}/employees/profile/{{ $employee->id }}" title="View Profile" data-toggle="tooltip" data-placement="left" data-container="body" target="_blank">
                <span class="fas fa-user-circle"></span>
            </a>
            @if (request()->route()->getPrefix() != '/visatracker')
            <a href="{{ url(request()->route()->getPrefix()) }}/employees/schedulesinfo/{{ $employee->id }}" title="View Schedules" data-toggle="tooltip" data-placement="left" data-container="body" target="_blank">
                <span class="far fa-calendar-alt"></span>
            </a>
            @endif
            @if (request()->route()->getPrefix() == '/admin')
            <a href="{{ url(request()->route()->getPrefix()) }}/employees/edit/{{ $employee->id }}" title="Edit Employee" data-toggle="tooltip" data-placement="left" data-container="body" target="_blank">
                <span class="fas fa-pencil-alt"></span>
            </a>
            @endif
        </div>
        @endif
        <img class="media-object img-thumbnail img-circle shadow" src="{{ $employee->photo_url }}">
        <div class="id-data">
            <h2 class="name">{{ $employee->full_name }}</h2>
            <p>
                <b class="department">{{ $employee->department->name }}</b>
                <br>
                <small>
                    <sub>
                        <i class="employee_no">{{ $employee->employee_number }}</i> 
                        <i class="employee_nickname">({{ $employee->nickname }})</i>
                    </sub><br>
                    <sup><b class="employee_position">{{ $employee->position }}</b></sup>
                </small>
            </p>
        </div>
    </div>
</div>