@if($employee)
    @if(session()->has('message')) 
    <div class="alert alert-info alert-dismissible"> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {!! session()->get('message') !!}
    </div>
    @endif
    @php
    $countries = session()->get('countries', '');
    if ($countries == '') {
        $countries = json_decode(file_get_contents("http://country.io/names.json"), true);
        session()->put('countries',$countries);
    }
    @endphp
    <div class="row bio-container employee-profile-template">
        <div class="header-box col-md-4 col-lg-3 col-xl-2">
            <header id="profile-header" class="profile-menu shadow">
                <div class="profile-sidebar">
                    <figure class="img-profile">
                        <img src="{{ $employee->user->photo_url }}" alt="">
                    </figure>
                    <nav id="main-nav" class="main-nav profile-nav clearfix tabbed">
                        <ul>
                            <li class="active"><a href="#" data-target="#personal" class="active"><i class="fas fa-id-card"></i>Personal</a></li>
                            <li><a href="#" data-target="#work"><i class="fas fa-city"></i>Career</a></li>
                            <li><a href="#" data-target="#academics"><i class="fas fa-school"></i>Education</a></li>
                            <li><a href="#" data-target="#miscellaneous"><i class="fas fa-plus"></i>Miscellaneous</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="bottom-header d-none">
                    <ul class="profile-actions">
                        @if(request()->route()->getPrefix() != "/employee")
                        <li><a href="{{ url(request()->route()->getPrefix() . '/employees') }}" data-toggle="tooltip" data-placement="bottom" data-container="body" title="Employee List"><i class="fas fa-users"></i></a></li>
                        <li><a href="{{ url(request()->route()->getPrefix() . '/employees/' . $employee->employee_no) }}" data-toggle="tooltip" data-placement="bottom" data-container="body" title="Profile" class="active"><i class="fas fa-user"></i></a></li>
                        @if(request()->route()->getPrefix() != "/payroll")
                        <li><a href="{{ url(request()->route()->getPrefix() . '/employee/' . $employee->employee_no . '/schedules') }}" data-toggle="tooltip" data-container="body" data-placement="bottom" title="Schedules"><i class="fas fa-user-clock"></i></a></li>
                        @endif
                        @endif
                        @if(request()->route()->getPrefix() == "/hr")
                        <li><a href="{{ route('hr.employee.edit', ['employee_no' => $employee->employee_no]) }}" data-toggle="tooltip" data-placement="bottom" data-container="body" title="Edit"><i class="fas fa-pencil-alt"></i></a></li>
                        @elseif(request()->route()->getPrefix() == "/employee")
                        <li><a href="{{ route('employee.profile.show') }}" data-toggle="tooltip" data-placement="bottom" data-container="body" title="Profile" class="active"><i class="fas fa-user"></i></a></li>
                        <li><a href="{{ route('employee.profile.edit') }}" data-toggle="tooltip" data-placement="bottom" data-container="body" title="Edit Profile"><i class="fas fa-pencil-alt"></i></a></li>
                        @endif
                    <ul>
                </div>
            </header>
        </div>

        <div class="col-md-8 col-lg-9 col-xl-10">
            <div class="profile-header shadow">
                <div class="content">
                    <div class="profile">
                        <h1>
                            {{ $employee->user->full_name }} 
                            <small>
                            @if(isset($employee->user->address->city) || isset($employee->user->address->state))
                                <sup><i class="fas fa-map-marker-alt"></i> 
                                {{ $employee->user->address->city . (isset($employee->user->address->city) && isset($employee->user->address->state)? ', ':'') . $employee->user->address->state }}</sup></small>
                            @endif
                            </small>
                        </h1>
                        @php
                        $department = $employee->departments()->where('from_date', '<=', now()->format('Y-m-d'))->where(function ($query) {
                                $query->where('to_date', '>=', now()->format('Y-m-d'))->orWhereNull('to_date');
                            })->first();
                        $position = $employee->positions()->where('from_date', '<=', now()->format('Y-m-d'))->where(function ($query) {
                            $query->where('to_date', '>=', now()->format('Y-m-d'))->orWhereNull('to_date');
                        })->first();
                        @endphp
                        <h3><b>{{ $department->name }}</b> | {{ $position->title }}</h3>
                        <div class="tags">
                            <span class="tag badge badge-primary bg-dark"><i class="fas fa-clock"></i> {{ $employee->user->birthdate->diffInYears(now()) }} years old</span>
                            <span class="tag tag-gender badge badge-primary bg-dark"><i class="fas fa-{{ ($employee->user->gender == 'male')? 'mars' : 'venus'}}"></i> {{ ucfirst($employee->user->gender) }}</span>
                            <span class="tag badge badge-primary bg-dark"><i class="fas fa-heart"></i> {{ ucfirst($employee->user->marital_status) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="employeeProfile">
                <section id="personal" class="shadow">
                    @include('components.molecules.title', ['title' => 'About'])
                    <div class="content about">
                        <div class="row">
                            <div class="col-xl-6 col-lg-12">
                                <div class="info-holder">
                                    <div class="address-info">
                                        <i class="info-icon fas fa-map-marker-alt"></i>
                                        <p>
                                            <sub class="text-secondary">Permanent Address</sub><br>
                                            {{ $employee->user->permanent_address ?? 'none' }}
                                        </p>
                                    </div>
                                    <div class="contact-info">
                                        <ul class="row">
                                            <li class="col-sm-12 col-lg-6">
                                                <div class="ico" data-toggle="tooltip" data-placement="bottom" title="Phone"><i class="fas fa-phone"></i></div>
                                                <p><b class="d-none">Tel:</b> {!! $employee->getMeta('phone') ? '<a href="tel:'. $employee->getMeta('phone') .'">'. $employee->getMeta('phone') .'</a>' : 'none' !!}</p>
                                            </li>
                                            <li class="col-sm-12 col-lg-6">
                                                <div class="ico" data-toggle="tooltip" data-placement="bottom" title="Email"><i class="fas fa-envelope"></i></div>
                                                <p><b class="d-none">Email:</b> {!! $employee->user->email ? '<a href="mailto:'. $employee->user->email .'">'. $employee->user->email .'</a>' : 'none' !!} </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <div class="info-holder">    
                                    <div class="address-info">
                                        <i class="info-icon fas fa-map-marker-alt"></i>
                                        <p>
                                            <sub class="text-secondary">Temporary Address</sub><br>
                                            {{ $employee->user->temporary_address ?? 'none' }}
                                        </p>
                                    </div>
                                    <div class="contact-info">
                                        <ul class="row">
                                            <li class="col-sm-12 col-lg-6">
                                                <div class="ico" data-toggle="tooltip" data-placement="bottom" title="Phone"><i class="fas fa-phone"></i></div>
                                                <p><b class="d-none">Tel:</b> {!! $employee->getMeta('temp_phone') ? '<a href="tel:'. $employee->getMeta('temp_phone') .'">'. $employee->getMeta('temp_phone') .'</a>' : 'none' !!}</p></li>
                                            </li>
                                            <li class="col-sm-12 col-lg-6">
                                                <div class="ico" data-toggle="tooltip" data-placement="bottom" title="Skype"><i class="fab fa-skype"></i></div>
                                                <p><b class="d-none">Skype:</b> {!! $employee->getMeta('skype') ? '<a href="skype:'. $employee->getMeta('skype') .'?call">'. $employee->getMeta('skype') .'</a>' : 'none' !!}</p></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <ul class="info-list">
                                    <li><span class="inf">First Name</span>  <span class="value">{{ $employee->user->first_name ?? 'none' }}</span></li>
                                    <li><span class="inf">Last Name</span>  <span class="value">{{ $employee->user->last_name ?? 'none' }}</span></li>
                                    <li><span class="inf">Middle Name</span>  <span class="value">{{ $employee->user->middle_name ?? 'none' }}</span></li>
                                    <li><span class="inf">Extension</span>  <span class="value">{{ $employee->user->extension ?? 'none' }}</span></li>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <ul class="info-list">
                                    <li><span class="inf">Date of Birth</span>  <span class="value">{{ $employee->user->birthdate->format('F d, Y') }}</span></li>
                                    <li><span class="inf">Place of Birth</span>  <span class="value">{{ $employee->user->birthplace ?? 'none' }}</span></li>
                                    <li><span class="inf">Height</span>  <span class="value">{!! $employee->getMeta('height')? "<small>" . $employee->getMeta('height') . " cm</small>" : "none"  !!}</span></li>
                                    <li><span class="inf">Weight</span>  <span class="value">{!! $employee->getMeta('weight')? "<small>" . $employee->getMeta('weight') . " kg</small>" : "none"  !!}</span></li>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <ul class="info-list">
                                    <li><span class="inf">Country</span>  
                                        <span class="value py-0">
                                            @if($employee->user->country_from)
                                            <img src="/images/blank.gif" class="flag flag-{{ strtolower($employee->user->country_from) }} mt-2" title="{{ $countries[$employee->user->country_from] }}" />
                                            @else
                                            none
                                            @endif
                                        </span>
                                    </li>
                                    <li><span class="inf">Nationality</span>  <span class="value">{{ $employee->user->nationality ?? 'none' }}</span></li>
                                    <li><span class="inf">Writing</span>  <span class="value">{!! $employee->getMeta('language_written')? taggify($employee->getMeta('language_written')) : 'none' !!}</span></li>
                                    <li><span class="inf">Speaking</span>  <span class="value">{!! $employee->getMeta('language_spoken')? taggify($employee->getMeta('language_spoken')) : 'none' !!}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
    
                    
                    @if($employee->marital_status == 'married')
                        @include('components.molecules.title', ['title' => 'Family'])
                        <div class="content family">
                            @if($employee->spouse_name || $employee->children->count() > 0)
                                @if($employee->spouse_name)
                                    <h5><b>Spouse:</b></h5>
                                    <div class="box-container">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6">
                                                <div class="box">
                                                    <div class="box-info">
                                                        @if($employee->user->wedding_date)
                                                        <span class="box-right badge badge-success bg-secondary">{{ $employee->user->wedding_date->diffInYears(now()) }} {{ str_plural('year', $employee->user->wedding_date->diffInYears(now())) }}</span>
                                                        @endif
                                                        <i class="box-icon fas fa-heart"></i>
                                                        <h4 class="box-title">{{ $employee->user->spouse_name }}</h4>
                                                        <p class="box-data"><small><i class="fa fa-church"></i> {{ $employee->user->wedding_date ? $employee->user->wedding_date->format('F j, Y') : 'none' }}</small></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="clearfix"></div>
                                @if($employee->children->count() > 0)
                                    <h5><b>{{ str_plural('Child', $employee->children->count() ) }}:</b></h5>
                                    <div class="box-container">
                                        <div class="row">
                                            @php
                                            $children = $employee->children()->orderBy('birthdate', 'asc')->get();
                                            @endphp
                                            @foreach($children as $i => $child)
                                                @php
                                                    $childBirthdate = \Carbon\Carbon::createFromTimestamp(strtotime($child->birthdate));
                                                @endphp
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="child-box box">
                                                        <div class="box-info">
                                                            <span class="box-left badge badge-primary bg-dark">{{ str_ordinal($i + 1) }}</span>
                                                            <span class="box-right badge badge-success bg-secondary">{{ $childBirthdate->diffInYears(now()) }} y/o</span>
                                                            <i class="box-icon fas fa-child"></i>
                                                            <h4 class="box-title">{{ $child->name }}</h4>
                                                            <p class="box-data"><small><i class="fas fa-birthday-cake"></i> {{ $childBirthdate->format('F j, Y') }}</small></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @else
                                <h2 align="center">No data available</h2>
                            @endif
                        </div>
                    @endif
                </section>
    
                <section id="academics" style="display: none;" class="shadow">
                    @include('components.molecules.title', ['title' => 'Educational Attainment'])
                    <div class="content">
                        @if($employee->schools->count() > 0)
                        <div class="timeline education experience">
                            <div class="event-holder">
                                @php
                                    $schools = $employee->schools()->orderBy('graduation_year', 'desc')->orderBy('graduation_month', 'desc')->get();
                                @endphp
                                @foreach($schools as $school)
                                <div class="event">
                                    <div class="hgroup">
                                        <h4>{{ $school->education_level }} – {{ $school->name }}</h4>
                                        @if($school->course)
                                            <h6>{{ $school->course }}</h6>
                                        @endif
                                        @if($school->location)
                                            <small><i>{{ $school->location }}</i></small>
                                        @endif
                                        <h6><i class="fas fa-user-graduate"></i>{{ date("F", mktime(0, 0, 0, $school->graduation_month, 1)) }} {{ $school->graduation_year }}</h6>
                                    </div>
                                    <p>{{ $school->awards }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <h2 align="center">No data available</h2>
                        @endif
                    </div>
    
                    @include('components.molecules.title', ['title' => 'Skill Sets'])
                    <div class="content">
                        @if($employee->skillSets->count() > 0)
                        <ul class="skills-list clearfix">
                            @foreach($employee->skillSets as $skill)
                            <li>
                                <h4>{{ $skill->name }}</h4>
                                <div class="progress">
                                    <div class="percentage{{ ($skill->rating * 10 == 100 ? ' full':'') }}" title="{{ $skill->rating * 10 }}%" data-toggle="tooltip" style="width: {{ $skill->rating * 10 }}%;"></div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <h2 align="center">No data available</h2>
                        @endif
                    </div>
                </section>
    
                <section id="work" style="display: none;" class="shadow">
                    @include('components.molecules.title', ['title' => 'Job Details'])
                    <div class="content">
                        <div class="row">
                            <div class="col-lg-12">
                                <p>{{ $position->job_description }}</p>
                            </div>
                            @php
                                $country_code = strtolower($employee->user->country_from);
                                $country_name = $countries[$employee->user->country_from];
                                $department = $employee->departments()->where('from_date', '<=', now()->format('Y-m-d'))->where(function ($query) {
                                    $query->where('to_date', '>=', now()->format('Y-m-d'))->orWhereNull('to_date');
                                })->first();
                                $position = $employee->positions()->where('from_date', '<=', now()->format('Y-m-d'))->where(function ($query) {
                                    $query->where('to_date', '>=', now()->format('Y-m-d'))->orWhereNull('to_date');
                                })->first();
                            @endphp
                            <div class="col-lg-6">
                                <ul class="info-list">
                                    <li><span class="inf">Employee No.</span>  <span class="value">{{ $employee->employee_no ?? 'none' }}</span></li>
                                    <li><span class="inf">Job Status</span>  <span class="value">{{ ucfirst($employee->employment_status) }}</span></li>
                                    <li><span class="inf">Type</span>  <span class="value">{{ ucfirst($employee->employee_type) }}</span></li>
                                    <li><span class="inf">Local</span>  <span class="value">{!! $employee->local ? 'Yes' : "<img src=\"/images/blank.gif\" class=\"flag flag-{$country_code}\" title=\"{$country_name}\" />" !!}</span></li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="info-list">
                                    <li><span class="inf">Department</span>  <span class="value">{{ $department ? $department->name : 'none' }}</span></li>
                                    <li><span class="inf">Position</span>  <span class="value">{{ $position ? $position->title : 'none' }}</span></li>
                                    <li><span class="inf">Office</span>  <span class="value">{{ $employee->office ? $employee->office->name : 'none' }}</span></li>
                                    <li><span class="inf">Payroll Group</span>  <span class="value">{{ $employee->paygroup ? $employee->paygroup->name : 'none' }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @include('components.molecules.title', ['title' => 'Work Experience'])
                    <div class="content">
                        @if($employee->workExperiences->count() > 0)
                        <div class="timeline experience">
                            <div class="event-holder">
                                @php
                                    $work_experiences = $employee->workExperiences()->orderBy('year_started', 'desc')->orderBy('month_started', 'desc')->get();
                                @endphp
                                @foreach($work_experiences as $exp)
                                <div class="event">
                                    <div class="hgroup">
                                        <h4>{{ $exp->position }} – {{ $exp->company_name }}</h4>
                                        @if($exp->location)
                                            <small><i>{{ $exp->location }}</i></small>
                                        @endif
                                        <h6><i class="fas fa-calendar"></i>{{ date("F", mktime(0, 0, 0, $exp->month_started, 1)) }} {{ $exp->year_started }} - 
                                        @if($exp->working)
                                            <span class="current">Current</span>
                                        @else
                                            {{ date("F", mktime(0, 0, 0, $exp->month_ended, 1)) }} {{ $exp->year_ended }}
                                        @endif
                                        </h6>
                                    </div>
                                    <p>{{ $exp->job_description }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <h2 align="center">No data available</h2>
                        @endif
                    </div>
                </section>
    
                {{-- 
                <section id="visa" style="display: none;" class="shadow">
                    @component('components.molecules.title')
                        @slot('title')
                            Passports
                            @if(request()->route()->getPrefix() == "/visatracker")
                            <div class="top-btns">
                                <a href="{{ url('/visatracker/passport/create/?selected_employee='.$employee->id) }}" class="btn btn-info btn-sm">Add Passport</a>
                            </div>
                            @endif
                        @endslot
                    @endcomponent
                    <div class="content">
                        @if ($employee->passports->count() > 0)
                        <div class="row">
                            @foreach($employee->passports as $passport)
                            <div class="col-lg-6">
                                @include('components.molecules.passportCard', ['employee' => $employee, 'passport' => $passport])
                            </div>
                            @endforeach
                        </div>
                        @else
                        <h2 align="center">No data available</h2>
                        @endif
                    </div>
    
                    @if(count($employee->touristVisas))
                        @component('components.molecules.title')
                            @slot('title')
                                Tourist Visa
                                @if(request()->route()->getPrefix() == "/visatracker")
                                <div class="top-btns">
                                    <a href="{{ url('/visatracker/tourist_visa/create/?selected_employee='.$employee->id) }}" class="btn btn-info btn-sm">Add Tourist Visa</a>
                                </div>
                                @endif
                            @endslot
                        @endcomponent
                        <div class="content">
                            @if ($employee->touristVisas->count() > 0)
                            <div class="row">
                                @foreach($employee->touristVisas as $tourist_visa)
                                <div class="col-lg-6">
                                    @include('components.molecules.touristVisa', ['employee' => $employee, 'tourist_visa' => $tourist_visa])
                                </div>
                                @endforeach
                            </div>
                            @else
                            <h2 align="center">No data available</h2>
                            @endif
                        </div>
                    @endif
    
                    @if(count($employee->specialWorkPermits))
                        @component('components.molecules.title')
                            @slot('title')
                                Special Working Permits
                                @if(request()->route()->getPrefix() == "/visatracker")
                                <div class="top-btns">
                                    <a href="{{ url('/visatracker/swp/create/?selected_employee='.$employee->id) }}" class="btn btn-info btn-sm">Add Special Work Permit</a>
                                </div>
                                @endif
                            @endslot
                        @endcomponent
                        <div class="content">
                            @if ($employee->specialWorkPermits->count() > 0)
                            <div class="row">
                                @foreach($employee->specialWorkPermits as $special_work_permit)
                                <div class="col-lg-6">
                                    @include('components.molecules.specialWorkPermit', ['employee' => $employee, 'special_work_permit' => $special_work_permit])
                                </div>
                                @endforeach
                            </div>
                            @else
                            <h2 align="center">No data available</h2>
                            @endif
                        </div>
                    @endif
    
                    @if(count($employee->alienEmploymentPermits))
                        @component('components.molecules.title')
                            @slot('title')
                                Alien Employment Permits
                                @if(request()->route()->getPrefix() == "/visatracker")
                                <div class="top-btns">
                                    <a href="{{ url('/visatracker/aep/create/?selected_employee='.$employee->id) }}" class="btn btn-info btn-sm">Add Alien Employment Permit</a>
                                </div>
                                @endif
                            @endslot
                        @endcomponent
                        <div class="content">
                            @if ($employee->alienEmploymentPermits->count() > 0)
                            <div class="row">
                                @foreach($employee->alienEmploymentPermits as $alien_employment_permit)
                                <div class="col-lg-6">
                                    @include('components.molecules.alienEmploymentPermit', ['employee' => $employee, 'alien_employment_permit' => $alien_employment_permit])
                                </div>
                                @endforeach
                            </div>
                            @else
                            <h2 align="center">No data available</h2>
                            @endif
                        </div>
                    @endif
    
                    @if(count($employee->workingVisas))
                        @component('components.molecules.title')
                            @slot('title')
                                Working Visa
                                @if(request()->route()->getPrefix() == "/visatracker")
                                <div class="top-btns">
                                    <a href="{{ url('/visatracker/working_visa/create/?selected_employee='.$employee->id) }}" class="btn btn-info btn-sm">Add Working Visa</a>
                                </div>
                                @endif
                            @endslot
                        @endcomponent
                        <div class="content">
                            @if ($employee->workingVisas->count() > 0)
                            <div class="row">
                                @foreach($employee->workingVisas as $working_visa)
                                <div class="col-lg-6">
                                    @include('components.molecules.workingVisa', ['employee' => $employee, 'working_visa' => $working_visa])
                                </div>
                                @endforeach
                            </div>
                            @else
                            <h2 align="center">No data available</h2>
                            @endif
                        </div>
                    @endif
                </section>
                --}}
    
                <section id="miscellaneous" style="display: none;" class="shadow">
                    @include('components.molecules.title', ['title' => 'Government information'])
                    <div class="content government-requirements">
                        <div class="government-files">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="ico"><i class="fas fa-user-shield"></i></div>
                                    <div class="det">
                                        <h4>Social Security System</h4>
                                        <p>SSS Number: <span class="employee-data">{{ $employee->sss_no ?? "none" }}</span></p>
                                    </div>
                                </div>
    
                                <div class="col-md-4">
                                    <div class="ico"><i class="fas fa-money-bill-alt"></i></div>
                                    <div class="det">
                                        <h4>Bureau of Internal Revenue</h4>
                                        <p>TIN: <span class="employee-data">{{ $employee->tin ?? "none" }}</span></p>
                                    </div>                                    
                                </div>
    
                                <div class="col-md-4">
                                    <div class="ico"><i class="fas fa-ambulance"></i></div>
                                    <div class="det">
                                        <h4>PhilHealth Insurance</h4>
                                        <p>PhilHealth Number: <span class="employee-data">{{ $employee->philhealth_no ?? "none" }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="ico"><i class="fas fa-piggy-bank"></i></div>
                                    <div class="det">
                                        <h4>Pag-ibig Fund</h4>
                                        <p>Pag-ibig Number: <span class="employee-data">{{ $employee->pagibig_no ?? "none" }}</span></p>
                                    </div>
                                </div>
    
                                <div class="col-md-4">
                                    <div class="ico"><i class="fas fa-passport"></i></div>
                                    <div class="det">
                                        <h4>Department of Foreign Affairs</h4>
                                        <p>Passport Number: <span class="employee-data">{{ $employee->getMeta('passport_no') ?? "none" }}</span></p>
                                    </div>
                                </div>
    
                                <div class="col-md-4">
                                    <div class="ico"><i class="fas fa-car"></i></div>
                                    <div class="det">
                                        <h4>Land Transportation Office</h4>
                                        <p>License Number: <span class="employee-data">{{ $employee->getMeta('driver_license') ?? "none" }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 offset-md-2">
                                    <div class="ico"><i class="fas fa-universal-access"></i></div>
                                    <div class="det">
                                        <h4>Unified Multi-Purpose ID</h4>
                                        <p>CRN: <span class="employee-data">{{ $employee->getMeta('unify_id') ?? "none" }}</span></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="ico"><i class="fas fa-balance-scale"></i></div>
                                    <div class="det">
                                        <h4>Police Clearance</h4>
                                        @if($employee->getMeta('police_clearance'))
                                        <div class="file-attachments">
                                            <a class="attachment-sm" href="{{ url("/storage/police_clearance_attached/{$employee->getMeta('police_clearance')}")}}" target="_blank">
                                                <h6><span class="download-icon"><i class="fas fa-arrow-down"></i></span> Download</h6>
                                            </a>
                                        </div>
                                        @else
                                        <p><i>No record found</i></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    @include('components.molecules.title', ['title' => 'Emergency Contact'])
                    <div class="content emergency">
                        <div class="info-holder">
                            <div class="address-info">
                                <i class="info-icon fas fa-phone"></i>
                                <h3 class="mt-50 mb-0">{{ $employee->getMeta('emergency_person') }}</h3>
                                <small>{{ $employee->getMeta('emergency_relation') }}</small>
                                <p class="pt-0">
                                    {{ $employee->getMeta('emergency_address') }}<br />
                                    <small>
                                        <i class="glyphicon glyphicon-phone-alt icon-field"></i> 
                                        {!! $employee->getMeta('emergency_number') ? '<a href="tel:'. $employee->getMeta('emergency_number') .'">'. $employee->getMeta('emergency_number') .'</a>' : 'none' !!}
                                    </small>
                                </p>
                            </div>
                            <div class="contact-info">
                                <b class="friends-label">Friends or relatives in Company</b>
                                <ul class="row">
                                    <li class="col-lg-12 pb-8">
                                        <div class="ico"><i class="fas fa-user-friends"></i></div>
                                        <p>{!! $employee->getMeta('contact_in_company') ? taggify($employee->getMeta('contact_in_company')) : 'none' !!}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="/vendor/gosquared/flags-sm/flags.min.css">
    @endpush

    @push('scripts')
    <script type="text/javascript">
    $(document).ready(function () {
        $(".profile-nav a").on('click', function() {
            var target = $(this).attr('data-target');
            $(this).addClass('active');
            $(this).closest('li').addClass('active');
            $(this).closest('li').siblings('li').removeClass('active');
            $(this).closest('li').siblings('li').find('a').removeClass('active');

            $('.bio-container section').hide();
            $(target).fadeIn();
        });
    });
    </script>
    @endpush
@endif