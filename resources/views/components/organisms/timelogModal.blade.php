<div class="modal fade" id="timelog_modal" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title text-danger"><strong><em>Timelog Entry</em></strong></h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid data-showcase">
                    <div class="col-sm-12">
                        <h3 class="day-type text-center ma-0">Working Day</h3>
                        <div class="form-group text-center">
                            <label class="schedule-box control-label">[Schedule: <span class="sched-in"></span> - <span class="sched-out"></span>]</label>
                            <label class="no-schedule-box control-label" style="display: none;">[No Schedule]</label>
                            <div class="control-data" style="position: relative;">
                                <button type="button" id="prevTimelogBtn" class="btn btn-link" onclick="prevTimeLog()"><i class="fas fa-angle-left"></i></button>
                                <div class="calendarbox" id="timelog-date" style="display: inline-block;">
                                    <div class="date-holder">
                                        <a href="javascript:void(0)" class="monthview-trigger">
                                            <i class="fas fa-calendar-alt"></i>
                                            <i class="fas fa-calendar-times" style="display:none;"></i>
                                        </a>
                                        <div class="dayofweek">{{ now()->format('l') }}</div>
                                        <div class="data-date">
                                            <div class="data-month">{{ now()->format('M') }}</div>
                                            <div class="data-day">{{ now()->format('d') }}</div> 
                                            <div class="data-year">{{ now()->format('Y') }}</div>
                                        </div>
                                    </div>
                                    <div class="calendar-holder" style="display:none;">
                                        <div class="datepicker-inline readonly" 
                                            data-date="{{ now()->format('m/d/Y') }}" 
                                            data-date-start-date="{{ now()->format('m/d/Y') }}"
                                            data-date-end-date="{{ now()->format('m/d/Y') }}"></div>
                                    </div>
                                </div>
                                <button type="button" id="nextTimelogBtn" class="btn btn-link" onclick="nextTimeLog()"><i class="fas fa-angle-right"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 time-entries">
                        <div class="col-sm-6">
                            <div class="form-group text-center">
                                <label class="control-label">Time-in</label>
                                <div class="control-data time-in" style="margin-left:30px;"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group text-center">
                                <label class="control-label">Time-out</label>
                                <div class="control-data time-out" style="margin-left:30px;"></div>
                            </div>
                        </div>
                        <div class="view-logs text-center">
                            <a href="javascript:void(0)" class="badge badge-primary btn-dark"><i class="fas fa-user-clock"></i> Timelogs</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="status-box panel panel-success ma-0">
                <div class="panel-heading">
                    <div class="form-group text-center ma-0">
                        <label class="control-label text-dark ma-0">Status</label>
                        <h3 class="status ma-0"></h3>
                        <div class="status-info"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                @if (request()->route()->getPrefix() == "")
                <a href="{{ url('/overtime/create') }}" target="_blank" id="apply-ot-btn" add-ot-url="{{ url('/overtime/create') }}" class="btn btn-primary" style="display: none;"><i class="glyphicon glyphicon-plus"></i> &nbsp;Apply Overtime</a>
                <a href="{{ url('/leaveform/create') }}" target="_blank" id="apply-leave-btn" add-leave-url="{{ url('/leaveform/create') }}" class="btn btn-primary" style="display: none;"><i class="glyphicon glyphicon-plus"></i> &nbsp;Apply Leave</a>
                @endif
            </div>
        </div>
    </div>
</div>