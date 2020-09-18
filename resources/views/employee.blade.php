<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Employees</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <!-- Styles -->
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
                            <h5 class="secondary-text font-weight-bold text-capitalize m-0">employees</h5>
                            <button class="custom-btn primary-bg text-white text-uppercase font-weight-light pt-1 pb-1 pl-3 pr-3" id="addEmployee">+ add employee</button>
                        </div>
                    </div>
                    <table class="table table-hover mt-3">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>User ID</th>
                                <th>Title</th>
                                <th>Access Level</th>
                                <th>Level</th>
                                <!-- <th></th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $item)
                                <tr>
                                    <td>{{ $item->fullname }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->role }}</td>
                                    <td>{{ $item->level }}</td>
                                    <!-- <td><img src="{{ asset('images/edit.svg') }}" data-project-id="{{ $item->id }}" data-project-name="{{ $item->name }}" alt="edit icon" srcset="" width="20" class="cursor-pointer edit-employee"></td> -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!-- Modal -->
        <div class="modal fade" id="employeeModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content pt-4">
                    <div class="modal-body p-4">
                        <form action="{{ route('add.employee') }}" method="post">
                            @csrf
                            <div class="modal-header text-capitalize primary-text font-weight-bold p-0 primary-border-bottom">
                                Add Employee
                            </div>
                            <div class="d-flex mt-4">
                                <input type="text" name="fullname" id="fullname" class="primary-text custom-input p-1 border-gray w-100" required value="" placeholder="Full Name">
                            </div>
                            <div class="d-flex mt-4">
                                <input type="text" name="username" id="date" class="primary-text custom-input p-1 border-gray w-100" required value="" placeholder="UserID">
                            </div>
                            <div class="d-flex mt-4">
                                <input type="password" name="password" id="date" class="primary-text custom-input p-1 border-gray w-100" required value="" placeholder="Password">
                            </div>
                            <select name="role" id="user-role" class="custom-select mt-4 primary-text" required>
                                <option selected class="primary-text text-capitalize">Access Level</option>
                                <option class="primary-text text-capitalize" value="1">Admin (level 1)</option>
                                <option class="primary-text text-capitalize" value="2">Employee (level 2)</option>
                            </select>                            
                            <div class="d-flex mt-4 justify-content-between">
                                <select name="title" class="custom-select primary-text time-period" required>
                                    <option selected class="primary-text text-capitalize">Title</option>
                                    <option value="1" class="primary-text text-capitalize">Admin</option>
                                    <option value="2" class="primary-text text-capitalize">Merchanic</option>
                                    <option value="3" class="primary-text text-capitalize">Finisher</option>
                                </select>
                                <select name="level" id="employee-level" class="custom-select primary-text time-period" required>
                                    <option selected disabled class="primary-text text-capitalize">Level</option>
                                    <option value="1" class="primary-text text-capitalize">Apprentice</option>
                                    <option value="2" class="primary-text text-capitalize">Journeyman</option>
                                </select>
                            </div>
                            <div class="d-flex mt-5 justify-content-end modal-footer border-0">
                                <input type="button" class="bg-white primary-text text-uppercase pt-1 pb-1 pr-3 pl-3 border-0 cursor-pointer" data-dismiss="modal" value="cancel">
                                <input type="submit" class="ml-2 primary-bg text-white text-uppercase pt-1 pb-1 pr-3 pl-3 border-0 cursor-pointer" value="save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="editEmployeeModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content pt-4">
                    <div class="modal-body p-4">
                        <form action="{{ route('add.employee') }}" method="post">
                            @csrf
                            <div class="modal-header text-capitalize primary-text font-weight-bold p-0 primary-border-bottom">
                                Edit Employee
                            </div>
                            <div class="d-flex mt-4">
                                <input type="text" name="fullname" id="fullname" class="primary-text custom-input p-1 border-gray w-100" required value="" placeholder="Full Name">
                            </div>
                            <div class="d-flex mt-4">
                                <input type="text" name="username" id="date" class="primary-text custom-input p-1 border-gray w-100" required value="" placeholder="UserID">
                            </div>
                            <div class="d-flex mt-4">
                                <input type="password" name="password" id="date" class="primary-text custom-input p-1 border-gray w-100" required value="" placeholder="Password">
                            </div>
                            <div class="d-flex mt-4 justify-content-between">
                                <select name="title" class="custom-select primary-text time-period" required>
                                    <option selected class="primary-text text-capitalize">Title</option>
                                    <option value="1" class="primary-text text-capitalize">Merchanic</option>
                                    <option value="2" class="primary-text text-capitalize">Finisher</option>
                                </select>
                                <select name="level" class="custom-select primary-text time-period" required>
                                    <option selected disabled class="primary-text text-capitalize">Level</option>
                                    <option value="1" class="primary-text text-capitalize">Apprentice</option>
                                    <option value="2" class="primary-text text-capitalize">Journeyman</option>
                                </select>
                            </div>
                            <div class="d-flex mt-5 justify-content-end modal-footer border-0">
                                <input type="button" class="bg-white primary-text text-uppercase pt-1 pb-1 pr-3 pl-3 border-0 cursor-pointer" data-dismiss="modal" value="cancel">
                                <input type="submit" class="ml-2 primary-bg text-white text-uppercase pt-1 pb-1 pr-3 pl-3 border-0 cursor-pointer" value="save">
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
            $("#addEmployee").click(function(){
                $("#employeeModal").modal({backdrop: false});
            });
            // $(".edit-employee").click(function(){
            //     $("#editEmployeeModal").modal({backdrop: false});
            // });
            $("#user-role").change(function(){
                if($(this).val() == 1)
                    $("#employeeModal #employee-level").addClass('d-none');
                else
                    $("#employeeModal #employee-level").removeClass('d-none');
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
            toastr["success"]("Employee Successfully Added!");
        </script>
        @endif
    </body>
</html>
