{{-- 
Parameters
$employees: array/collection 
$name: string [checkbox name | default -> 'employees']
$columns: int [default -> 4]
$passport: boolean [default -> false]
$circleThumbs: boolean [default -> false]
$required: boolean [default -> true]
$selected: array of int (employee_ids)
$maximum: int [default -> 0]
--}}
@if ($employees)
<div class="employees-multiselector employee-selector">
    @php
    $name = isset($name) ? $name : 'employees';
    $numOfCols = isset($columns) ? $columns : 4;
    $showPassportInfo = isset($passport) ? $passport : 0;
    $isCircleThumbs = isset($circleThumbs) ? $circleThumbs : 0;
    $required = isset($required) ? $required : 0;
    $selectedEmployees = isset($selected) ? $selected : [];
    $selectionHeight = isset($maxHeight) ? $maxHeight: '348px';
    $maximum = isset($maximum) ? $maximum : 0;

    $rowCount = 0;
    $bootstrapColWidth = 12 / $numOfCols;

    $ctr = 0;
    $selectedCtr = 0;
    @endphp
    <div class="employee-search">
        <div class="form-group">
            <i class="search-icon fa fa-search"></i>
            <input class="form-control search-input" placeholder="Search Employee..." />
        </div>
    </div>
    <div class="employee-selections{{ ($required ? ' required' : '') }}" style="max-height: {{ $selectionHeight }};" data-maximum="{{ $maximum }}">
        <div class="selections-container">
        @foreach($employees as $employee)
            @php
                $ctr++;
                if (in_array($employee->id, $selectedEmployees)) {
                    $selectedCtr++;
                }
            @endphp
            <div class="col-sm-6 col-md-4 col-lg-{{ $bootstrapColWidth }} employee-item {{ (in_array($employee->id, $selectedEmployees)?'selected':'') }}">
                <label for="{{ $name }}_chk{{ $employee->id }}" class="media selector-box shadow">
                    <div class="media-left media-middle selector-image">
                        <img class="img-thumbnail {{ ($isCircleThumbs?'img-circle ':'') }}media-object shadow" src="{{ $employee->photo_url }}">
                    </div>
                    <div class="media-body selector-body">
                        <h4 class="media-heading employee-name">{{ $employee->full_name }}</h4>
                        <p class="employee-info">
                            <span class="field-data"><sup><strong class="employee-number">{{ $employee->employee_number }}</strong> <strong class="employee-nickname">({{ $employee->nickname }})</strong></sup></span>
                            <span class="field-data">
                                <sup class="hidden">
                                    <strong class="department-name">
                                    @if($employee->department)
                                        {{ $employee->department->name }}
                                    @endif
                                    </strong>
                                </sup>
                            </span>
                            @if($showPassportInfo)
                                <span class="field-data"><sup class="employee-passport-no">Passport Number: <b class="passport-number">{{ $employee->passport_no }}</b></sup></span>
                                <span class="field-data"><sup class="employee-passport-issued">Date Issued: <b class="date-issued">{{ $employee->passports()->latest('date_issue')->first()->date_issue->format('F j, Y') }}</b></sup></span>
                                <span class="field-data"><sup class="hidden employee-passport-exipry">Expiry Date: <b class="expiry-date">{{ $employee->passports()->latest('date_issue')->first()->expiry_date->format('F j, Y') }}</b></sup></span>
                            @else
                                <span class="field-data"><b class="department">{{ $employee->department->name }}</b></span>
                                <small class="field-data"><sup class="employee-position"><i class="postion">{{ $employee->position }}</i></sup></small>
                            @endif
                        </p>
                    </div>
                </label>
                <div class="form-group checkbox checkbox-primary">
                    <input type="checkbox" name="{{ $name }}[]" id="{{ $name }}_chk{{ $employee->id }}" value="{{ $employee->id }}" 
                        {{ (in_array($employee->id, $selectedEmployees)?' checked':'') }} {{ ($required && $ctr == 1? 'required' : '') }} />
                    <label for="{{ $name }}_chk{{ $employee->id }}" class="control-label"></label>
                </div>
            </div>
        @endforeach
        </div>
    </div>
    <div class="selection-summary">
        <button type="button" class="btn btn-link clear-selection-button"{!! ($selectedCtr == 0 ? ' style="display:none;"' : '') !!}>
            <i class="fa fa-times"></i>&nbsp; <small>Clear Selections</small>
        </button>
        <small class="visibility-info">Showing <span class="visible-count">{{ count($employees) }}</span> of {{ count($employees) }} Employees (<span class="selected-count">{{ $selectedCtr }}</span> Selected)</small>
        @if($maximum == 0)
        <button type="button" class="employees-check-all btn btn-sm btn-default">Check All</button>
        @else
        <button type="button" class="employees-check-limited btn btn-sm btn-default">Check First {{ $maximum }} Employees</button>
        @endif
        <button type="button" class="employees-uncheck-all btn btn-sm btn-default">Uncheck All</button>
    </div>
</div>
@endif