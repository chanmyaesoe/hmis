{{-- 
Parameters
$employees: array/collection 
$name: string [checkbox name | default -> 'employee_id']
$columns: int [default -> 4]
$maxHeight: string [default -> '224px']
$passport: boolean [default -> false]
$circleThumbs: boolean [default -> false]
$required: boolean [default -> true]
$selected: int (employee_id) [default -> null]
$callback: string [default -> null] // function name
$callbackParams: string [default -> null] // (optional) can be comma separated values
$callbackNoID: boolean [defaul -> false] // upon callback the first param is the selected id, turn on to disable passing employeeID
$noedit: boolean [default -> false]
--}}
@if ($employees)
<div class="employees-singleselector employee-selector">
    @php
    $name = isset($name) ? $name : 'employees';
    $numOfCols = isset($columns) ? $columns : 4;
    $showPassportInfo = isset($passport) ? $passport : 0;
    $isCircleThumbs = isset($circleThumbs) ? $circleThumbs : 0;
    $editable = isset($noedit) ? !$noedit : 1;
    $required = isset($required) ? $required : 0;
    $selected = isset($selected) ? $selected : null;
    $callback = isset($callback) ? $callback : null;
    $callbackParams = isset($callbackParams) ? $callbackParams : null;
    $callbackNoID = isset($callbackNoID) ? $callbackNoID : null;
    $selectionHeight = isset($maxHeight) ? $maxHeight: '232px';

    $bootstrapColWidth = 12 / $numOfCols;
    $selected_employee = null;

    $ctr = 0;
    @endphp
    <div class="employee-search {{ (!$editable? 'hidden': '') }}" {!! $selected? ' style="display:none;"':'' !!}>
        <div class="form-group">
            <i class="search-icon fa fa-search"></i>
            <input id="{{ $name }}_search" class="form-control search-input" placeholder="Search Employee..." />
        </div>
    </div>
    <div class="employee-selections {{ (!$editable? 'hidden': '') }}" style="max-height: {{ $selectionHeight }}; {{ $selected? ' display: none;':'' }}" {!! $callback? ' data-callback="' . $callback . '"':'' !!} {!! $callbackParams? ' data-callback-params="' . $callbackParams . '"':'' !!} {!! $callbackNoID? ' data-callback-no-id="true"':'' !!}>
        <div class="selections-container">
        @foreach($employees as $employee)
            @php
                $ctr++;
                if($selected === $employee->id) {
                    $selected_employee = $employee;
                }
            @endphp
            <div class="col-md-{{ $bootstrapColWidth }} employee-item {{ ($selected == $employee->id?'selected':'') }}">
                <label for="{{ $name }}_rad{{ $employee->id }}" class="media selector-box shadow">
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
                <div class="form-group radio radio-primary">
                    <input type="radio" name="{{ $name }}" id="{{ $name }}_rad{{ $employee->id }}" value="{{ $employee->id }}" 
                        {{ ($selected == $employee->id?' checked':'') }} {{ ($required && $ctr == 1? 'required' : '') }} />
                    <label for="{{ $name }}_rad{{ $employee->id }}" class="control-label"></label>
                </div>
            </div>
        @endforeach
        </div>
    </div>
    <p class="selection-display-info" style="{{ $selected? ' display: none;':'' }}"><small>Showing <span class="visible-count">{{ count($employees) }}</span> of {{ count($employees) }} Employees</small></p>

    <div class="selection-summary {{ ($editable &&  !$selected? 'hidden': '') }}">
        @if ($editable)
            <div class="search-employee-toggle">
                <button type="button" class="btn btn-link search-employee-toggle-button">
                        @if ($selected)
                        <i class="fas fa-hand-pointer"></i>&nbsp; <small>Change Selection</small>
                        @else
                        <i class="fas fa-eye-slash"></i>&nbsp; <small>Hide Search</small>
                        @endif
                    </small>
                </button>
            </div>
            <div class="clear-employee-wrapper">
                <button type="button" class="btn btn-link clear-selection-button" title="Clear"><i class="fa fa-times"></i></button>
            </div>
        @endif
        <div class="employee-card">
            <div class="jumbotron shadow">
                    @if ($selected_employee)
                    <img class="media-object img-thumbnail img-circle shadow" src="{{ $selected_employee->photo_url }}">
                    @else
                    <img class="media-object img-thumbnail img-circle shadow" src="{{ url('/images/placeholder-male.png') }}">
                    @endif
                <div class="id-data">
                    <h2 class="name">{{ ($selected_employee? $selected_employee->full_name: '') }}</h2>
                    <p>
                        <b class="department">{{ ($selected_employee? $selected_employee->department->name: '') }}</b>
                        <br>
                        <small>
                            <sub>
                                <i class="employee_no">{{ ($selected_employee? $selected_employee->employee_number: '') }}</i> 
                                <i class="employee_nickname">({{ ($selected_employee? $selected_employee->nickname: '') }})</i>
                            </sub><br>
                            <sup><b class="employee_position">{{ ($selected_employee? $selected_employee->position: '') }}</b></sup>
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif