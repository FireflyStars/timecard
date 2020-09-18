<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Timecard Submit</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/materialize.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="wrapper">
            <div class="container-fulid d-flex">
                <div class="sidebar">
                    <div class="logo-blockd-flex justify-content-center pt-2 pb-2">
                        <img src="{{ asset('images/logo_blue.png') }}" alt="logo" width="200">
                    </div>
                    <ul class="nav flex-column sidebar-nav">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link text-capitalize font-weight-bold secondary-text {{ Request::segment(1) ==  'dashboard' ? 'active' : '' }}">dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('show.all.employee') }}" class="nav-link text-capitalize secondary-text font-weight-bold  {{ Request::segment(1) ==  'employees' ? 'active' : '' }}">employees</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('show.all.project') }}" class="nav-link text-capitalize secondary-text font-weight-bold  {{ Request::segment(1) ==  'projects' ? 'active' : '' }}">projects</a>
                        </li>
                        <li class="nav-item">
                        <a href="{{ route('archived.timecard') }}" class="nav-link text-capitalize  secondary-text font-weight-bold {{ Request::segment(1) ==  'archived-timecards' ? 'active' : '' }}">archived time cards</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link text-capitalize  secondary-text font-weight-bold">logout</a>
                        </li>                        
                        <li class="nav-item mt-2 text-center">
                            <span>v1.0</span>
                        </li>                           
                    </ul>
                </div>
                <div class="content-container">
                    <div class="content-header">
                        <div class="d-flex justify-content-between pb-2">
                            <h5 class="secondary-text font-weight-bold text-capitalize m-0">Add time Card</h5>
                        </div>
                    </div>                
                    <div class="timecard p-2 mt-4 text-left">
                        <form action="{{ route('add.timecard.by.admin') }}" id="timecardForm" method="post">
                            @csrf
                            <select name="user_id" id="user_id" class="custom-select primary-text" required>
                                <option selected disabled class="primary-text text-capitalize">Employee</option>
                                @foreach($employees as $item)
                                    <option value="{{ $item->id }}" class="primary-text text-capitalize">{{ $item->fullname }}</option>
                                @endforeach
                            </select>
                            <div class="d-flex mt-4 justify-content-between">
                                <button type="button" class="col-3 bg-white custom-input text-capitalize pr-3 pl-3 show-datepicker cursor-pointer">Date</button>
                                <input type="text" name="date" id="date" class="offset-1 col-8 primary-text datepicker boder-bottom-input p-1 m-0" required>
                            </div>
                            <select name="project_id" id="project_id" class="custom-select mt-4 primary-text" required>
                                <option selected disabled class="primary-text text-capitalize">Project</option>
                                @foreach($projects as $item)
                                    <option value="{{ $item->id }}" class="primary-text text-capitalize">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <div class="d-flex mt-4 justify-content-between">
                                <select name="time_in" class="custom-select primary-text time-period" id="timein" required>
                                    <option selected disabled class="primary-text text-capitalize">Time In</option>
                                    @for($hh = 0 ; $hh < 24 ; $hh++) 
                                        @for($mm = 0; $mm <= 45 ; $mm+= 15)
                                            @if($hh < 12)
                                                @if($mm == 0)
                                                    @if($hh < 10)
                                                        <option value="0{{$hh}}:00" class="primary-text text-uppercase">0{{ $hh }}:00 AM</option>
                                                    @else
                                                        <option value="{{$hh}}:00" class="primary-text text-uppercase">{{ $hh }}:00 AM</option>
                                                    @endif
                                                @else
                                                    @if($hh < 10)
                                                        <option value="0{{$hh}}:{{ $mm }}" class="primary-text text-uppercase">0{{ $hh }}:{{ $mm }} AM</option>
                                                    @else
                                                        <option value="{{$hh}}:{{ $mm }}" class="primary-text text-uppercase">{{ $hh }}:{{ $mm }} AM</option>
                                                    @endif
                                                @endif
                                            @else
                                                @if($mm == 0)
                                                    @if($hh < 22)
                                                        @if($hh == 12)
                                                            <option value="{{ $hh }}:00" class="primary-text text-uppercase">12:00 PM</option>
                                                        @else
                                                            <option value="{{ $hh }}:00" class="primary-text text-uppercase">0{{ $hh - 12 }}:00 PM</option>
                                                        @endif
                                                    @else
                                                        <option value="{{ $hh }}:00" class="primary-text text-uppercase">{{ $hh - 12 }}:00 PM</option>
                                                    @endif
                                                @else
                                                    @if($hh < 22)
                                                        @if($hh == 12)
                                                            <option value="{{ $hh }}:{{ $mm }}" class="primary-text text-uppercase">12:{{ $mm }} PM</option>
                                                        @else
                                                            <option value="{{ $hh }}:{{ $mm }}" class="primary-text text-uppercase">0{{ $hh - 12 }}:{{ $mm }} PM</option>
                                                        @endif
                                                    @else
                                                        <option value="{{ $hh }}:{{ $mm }}" class="primary-text text-uppercase">{{ $hh - 12 }}:{{ $mm }} PM</option>
                                                    @endif
                                                @endif
                                            @endif
                                        @endfor
                                    @endfor
                                </select>
                                <select name="time_out" class="custom-select primary-text time-period" id="timeout" required>
                                    <option selected disabled class="primary-text text-capitalize">Time Out</option>
                                    @for($hh = 0 ; $hh < 24 ; $hh++) 
                                        @for($mm = 0; $mm <= 45 ; $mm+= 15)
                                            @if($hh < 12)
                                                @if($mm == 0)
                                                    @if($hh < 10)
                                                        <option value="0{{$hh}}:00" class="primary-text text-uppercase">0{{ $hh }}:00 AM</option>
                                                    @else
                                                        <option value="{{$hh}}:00" class="primary-text text-uppercase">{{ $hh }}:00 AM</option>
                                                    @endif
                                                @else
                                                    @if($hh < 10)
                                                        <option value="0{{$hh}}:{{ $mm }}" class="primary-text text-uppercase">0{{ $hh }}:{{ $mm }} AM</option>
                                                    @else
                                                        <option value="{{$hh}}:{{ $mm }}" class="primary-text text-uppercase">{{ $hh }}:{{ $mm }} AM</option>
                                                    @endif
                                                @endif
                                            @else
                                                @if($mm == 0)
                                                    @if($hh < 22)
                                                        @if($hh == 12)
                                                            <option value="{{ $hh }}:00" class="primary-text text-uppercase">12:00 PM</option>
                                                        @else
                                                            <option value="{{ $hh }}:00" class="primary-text text-uppercase">0{{ $hh - 12 }}:00 PM</option>
                                                        @endif                                                    
                                                    @else
                                                        <option value="{{ $hh }}:00" class="primary-text text-uppercase">{{ $hh - 12 }}:00 PM</option>
                                                    @endif
                                                @else
                                                    @if($hh < 22)
                                                        @if($hh == 12)
                                                            <option value="{{ $hh }}:{{ $mm }}" class="primary-text text-uppercase">12:{{ $mm }} PM</option>
                                                        @else
                                                            <option value="{{ $hh }}:{{ $mm }}" class="primary-text text-uppercase">0{{ $hh - 12 }}:{{ $mm }} PM</option>
                                                        @endif                                                    
                                                    @else
                                                        <option value="{{ $hh }}:{{ $mm }}" class="primary-text text-uppercase">{{ $hh - 12 }}:{{ $mm }} PM</option>
                                                    @endif
                                                @endif
                                            @endif
                                        @endfor
                                    @endfor
                                </select>
                            </div>
                            <div class="d-flex mt-3 justify-content-between">
                                <div class="regular-time d-flex justify-content-between">
                                    <span class="primary-text text-capitalize text-nowrap p-0">Regular:</span> 
                                    <input type="text" class="time-input text-center m-0 boder-bottom-input" readonly name="regulartime" id="regulartime">
                                </div>
                                <div class="nighttime d-flex justify-content-between">
                                    <span class="d-block primary-text text-capitalize text-nowrap p-0">Night:</span> 
                                    <input type="text" class="time-input text-center m-0 boder-bottom-input p-0" name="nighttime" readonly id="nighttime">
                                </div>
                                <div class="overtime d-flex justify-content-between">
                                    <span class="d-block primary-text text-capitalize text-nowrap p-0">Overtime:</span> 
                                    <input type="text" class="time-input text-center m-0 boder-bottom-input p-0" name="overtime" readonly id="overtime">
                                </div>
                            </div>                        
                            <div class="mt-2">
                                <div class="total-hour d-flex">
                                    <span class="primary-text text-capitalize text-nowrap p-0">Total hours:</span> 
                                    <input type="text" class="time-input text-center m-0 boder-bottom-input" name="total_hours" readonly id="total_hours">
                                </div>
                            </div>
                            <div class="d-flex mt-5 justify-content-end border-0">
                                <input type="submit" class="ml-2 primary-bg text-white text-uppercase pt-2 pb-2 pr-3 pl-3 border-0 cursor-pointer" id="addtimecard" value="add">
                            </div>                        
                        </form>
                    </div>
                </div> 
            </div>
        </div>
        <!-- JS -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/materialize.min.js') }}"></script>
        <script src="{{ asset('js/toastr.min.js') }}"></script>
        <script>
            var selectedDate=0, timeIn=0, timeOut=0, theDay=0; totalHours = 0, overTime = 0, nightTime = 0, regularTime = 0;
            $(document).ready(function(){
                let date = $('.datepicker').datepicker({setDefaultDate: true, defaultDate: new Date(), format: "ddd mmm dd, yyyy"});
                selectedDate = $('#date').val();
                $('.show-datepicker').click(function(){
                    $('.datepicker').datepicker('open');
                })
                $("#date").change(function(){
                    selectedDate = $(this).val();
                    timeCalculation();
                })
                $("#timein").change(function(){
                    timeIn = $(this).val();
                    timeCalculation();
                })
                $("#timeout").change(function(){
                    timeOut = $(this).val();
                    timeCalculation();
                })
                $("#timecardForm").submit(function(e){
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": true,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "500",
                        "timeOut": "2000",
                        "extendedTimeOut": "500",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }                    
                    if($("#user_id").val() == null){
                        toastr["error"]("Please Select Employee");
                        e.preventDefault();
                    }
                    if($("#project_id").val() == null){
                        toastr["error"]("Please Select Project");
                        e.preventDefault();
                    }
                    if($("#timein").val() == null){
                        toastr["error"]("Please Select TimeIn");
                        e.preventDefault();
                    }
                    if($("#timeout").val() == null){
                        toastr["error"]("Please Select TimeOut");
                        e.preventDefault();
                    }
                });
            });

            function timeCalculation(){
                if(selectedDate && timeIn && timeOut){
                    today = new Date(selectedDate);
                    theDay = today.getDay();
                    console.log(theDay);
                    var date1 = new Date( selectedDate + " " + timeIn);
                    var date2 = new Date( selectedDate + " " + timeOut);
                    
                    var timeDiff = getTimeDiff(date1, date2);
                    // total hours calculation
                    if(timeDiff.mm == 0)
                        totalHours = timeDiff.hh;
                    else{
                        if (timeDiff.mm == "15") {
                            totalHours = timeDiff.hh + ".25";
                        }else if(timeDiff.mm == "30"){
                            totalHours = timeDiff.hh + ".5";
                        }else{
                            totalHours = timeDiff.hh + ".75";
                        }
                    }

                    $("#total_hours").val(totalHours);
                    regularTime = totalHours;
                    // overtime calculation
                    if(theDay == 0 || theDay == 6){
                        overTime = totalHours;
                        regularTime = 0;
                    }else{
                        // timediff > 8
                        if(timeDiff.hh > 8 || (timeDiff.hh == 8 && timeDiff.mm > 0)){
                            regularTime = 8;
                            if(timeDiff.mm > 0){
                                if (timeDiff.mm == "15") {
                                    overTime = (timeDiff.hh - 8) + ".25";
                                }else if(timeDiff.mm == "30"){
                                    overTime = (timeDiff.hh - 8) + ".5";
                                }else{
                                    overTime = (timeDiff.hh - 8) + ".75";
                                }
                            }else{
                                overTime = (timeDiff.hh - 8);
                            }
                        }else{
                            overTime = 0;
                        }
                    }
                    $("#overtime").val(overTime);

                    //night time calculation
                    if(timeOut > "17:00"){
                        var dateTmp;
                        if(timeIn >= "17:00")
                            dateTmp = new Date( selectedDate + " " + timeIn);
                        else
                            dateTmp = new Date( selectedDate + " 17:00");
                        timeDiff = getTimeDiff(dateTmp, date2);
                        if(timeDiff.mm == 0)
                            nightTime = timeDiff.hh;
                        else{
                            if (timeDiff.mm == "15") {
                                nightTime = timeDiff.hh + ".25";
                            }else if(timeDiff.mm == "30"){
                                nightTime = timeDiff.hh + ".5";
                            }else{
                                nightTime = timeDiff.hh + ".75";
                            }                            
                        }
                    }else{
                        nightTime = 0;
                    }
                    $("#regulartime").val(regularTime);
                    $("#nighttime").val(nightTime);
                }
            }
            function getTimeDiff(date1, date2){
                var diff = date2.getTime() - date1.getTime();
                var msec = diff;
                var hh = Math.floor(msec / 1000 / 60 / 60);
                msec -= hh * 1000 * 60 * 60;
                var mm = Math.floor(msec / 1000 / 60);
                msec -= mm * 1000 * 60;
                return { "hh": hh, "mm": mm};
            }
        </script>        
        <style>
            .modal-overlay{
                background: transparent;
            }
        </style>   
    </body>
</html>
