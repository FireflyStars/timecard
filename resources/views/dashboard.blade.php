<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Dashboard</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
                            <h5 class="secondary-text font-weight-bold text-capitalize m-0">time card entries</h5>
                            <a href="{{ route('show.add.timecard') }}" class="custom-btn primary-bg text-white text-uppercase font-weight-light pt-1 pb-1 pl-3 pr-3">+ add timecard</a>
                        </div>
                    </div>
                    @foreach($timecardsbyweek as $year_week => $timecards)
                        @php
                            $year = explode("-", $year_week)[0];
                            $week = explode("-", $year_week)[1];
                            $date = Carbon\Carbon::now();
                            $date->setISODate($year, $week+1);
                            $startDay = $date->startOfWeek(Carbon\Carbon::WEDNESDAY)->format('D m-d-Y');
                            $endDay = $date->endOfWeek(Carbon\Carbon::TUESDAY)->format('D m-d-Y');
                        @endphp
                    <div class="week-panel mt-3">
                        <div class="week-panel-header">
                            <strong>Week of <span class="start-date primary-text">{{ $startDay }}</span> - <span class="end-date primary-text">{{ $endDay }}</span></strong>
                            <a href="{{ route('print.work.week', $year_week) }}" class="custom-btn primary-bg text-white pt-1 pb-1 pr-3 pl-3 ml-2 text-uppercase">print</a>
                        </div>
                        <table class="table table-hover mt-3">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Project</th>
                                    <th>In</th>
                                    <th>Out</th>
                                    <th>Regular</th>
                                    <th>Night</th>
                                    <th>OT</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($timecards as $item)
                                    <tr>
                                        <td>@php echo date_format(date_create($item->date), 'D m-d-Y'); @endphp</td>
                                        <td>{{ $item->employee->fullname }} ({{ $item->employee->title }}, {{ $item->employee->level }})</td>
                                        <td>{{ $item->project->name }}</td>
                                        <td>{{ $item->time_in }}</td>
                                        <td>{{ $item->time_out }}</td>
                                        <td>{{ $item->regulartime }}</td>
                                        <td>{{ $item->nighttime }}</td>
                                        <td>{{ $item->overtime }}</td>
                                        <td>{{ $item->total_hours }}</td>
                                        <td>
                                            <a href="{{ route('show.edit.timecard', $item->id) }}">
                                                <img src="{{ asset('images/eye.svg') }}" alt="eye" width="20" class="cursor-pointer">
                                            </a>
                                            <a href="{{ route('delete.timecard', $item->id) }}" class="ml-2 delete-timecard">
                                                <img src="{{ asset('images/delete.svg') }}" alt="delete" width="20" class="cursor-pointer">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content pt-4">
                    <div class="modal-body p-4">
                        <form action="" method="get" id="deleteModalForm">
                            @csrf
                            <div class="text-center">
                                <img src="{{ asset('images/warning.svg') }}" width="50" alt="warning">
                            </div>
                            <h4 class="mt-3">Are you sure you want to delete this timecard?</h4>
                            <div class="text-center mt-4">
                                <input type="button" class="bg-custom-warning text-white text-uppercase pt-1 pb-1 pr-3 pl-3 border-0 cursor-pointer" data-dismiss="modal" value="Cancel">
                                <input type="submit" class="ml-2 text-custom-warning bg-transparent text-uppercase pt-1 pb-1 pr-3 pl-3 border-0 cursor-pointer" value="Delete">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>   
        <!-- JS -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/toastr.min.js') }}"></script>
        <script>
            $(document).ready(function(){
                $(".delete-timecard").click(function(e){
                    e.preventDefault();
                    $("#deleteModalForm").attr('action', $(this).attr('href'));
                    $("#deleteModal").modal({backdrop: false});
                })
            })
        </script>
        @if(session()->has('added'))
        <script>
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
            toastr["success"]("TimeCard Successfully Added!");
        </script>
        @endif
        @if(session()->has('updated'))
        <script>
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
            toastr["success"]("TimeCard Successfully updated!");
        </script>
        @endif
        @if(session()->has('deleted'))
        <script>
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
            toastr["success"]("TimeCard Successfully deleted!");
        </script>
        @endif
    </body>
</html>
