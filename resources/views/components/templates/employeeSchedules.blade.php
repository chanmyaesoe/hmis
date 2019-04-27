@if($employee)
    <div class="row bio-container employee-profile-template">
        <div class="header-box col-md-4 col-lg-3 col-xl-2">
            <header id="profile-header" class="profile-menu shadow">
                <div class="profile-sidebar">
                    <figure class="img-profile">
                        <img src="{{ $employee->user->photo_url }}" alt="">
                    </figure>
                    <nav id="main-nav" class="main-nav profile-nav clearfix tabbed">
                        <ul>
                            <li class="active"><a href="#" data-target="#scheduleList" class="active"><i class="fas fa-business-time"></i>Schedule List</a></li>
                            <li><a href="#" data-target="#scheduleHistory"><i class="fas fa-history"></i>Schedule History</a></li>
                        </ul>
                    </nav>
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

            <div id="employeeSchedules">
                <section id="scheduleList" class="shadow">
                    @component('components.molecules.title')
                        @slot('title')
                            Schedule List
                            <div class="top-btns">
                                <a href="#" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Add Schedule</a>
                            </div>
                        @endslot
                    @endcomponent
                    <div class="content schedule-list">
                        <div class="row">
                            <div class="col-xl-12">

                            </div>
                        </div>
                    </div>
                </section>
    
                <section id="scheduleHistory" style="display: none;" class="shadow">
                    @include('components.molecules.title', ['title' => 'Schedule History'])
                    <div class="content">
                        @if($employee->schedules->count() > 0)
                        <table>
                        </table>
                        @else
                        <h2 align="center">No data available</h2>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>

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