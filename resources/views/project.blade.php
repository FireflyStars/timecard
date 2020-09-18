<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Projects</title>
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
                            <h5 class="secondary-text font-weight-bold text-capitalize m-0">projects</h5>
                            <button class="custom-btn primary-bg text-white text-uppercase font-weight-light pt-1 pb-1 pl-3 pr-3" id="addProject">+ add project</button>
                        </div>
                    </div>
                    <div class="week-panel mt-3">
                        <table class="table table-hover mt-3">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td><img src="{{ asset('images/edit.svg') }}" data-project-id="{{ $item->id }}" data-project-name="{{ $item->name }}" alt="edit icon" srcset="" width="20" class="cursor-pointer edit-project"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="projectModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content pt-4">
                    <div class="modal-body p-4">
                        <form action="{{ route('add.project') }}" method="post">
                            @csrf
                            <div class="modal-header text-capitalize primary-text font-weight-bold p-0 primary-border-bottom">
                                Add Project
                            </div>
                            <div class="d-flex mt-4">
                                <input type="text" name="name" id="name" class="primary-text custom-input p-1 border-gray w-100" value="" placeholder="Name">
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
        <div class="modal fade" id="editProjectModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content pt-4">
                    <div class="modal-body p-4">
                        <form action="{{ route('update.project') }}" method="post">
                            @csrf
                            <div class="modal-header text-capitalize primary-text font-weight-bold p-0 primary-border-bottom">
                                Edit Project
                            </div>
                            <input type="hidden" name="project_id" id="project_id">
                            <div class="d-flex mt-4">
                                <input type="text" name="project_name" id="project_name" class="primary-text custom-input p-1 border-gray w-100" value="" placeholder="Name">
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
            $("#addProject").click(function(){
                $("#projectModal").modal({backdrop: false});
            });
            $(".edit-project").click(function(){
                $("#editProjectModal #project_id").val($(this).data('project-id'));
                $("#editProjectModal #project_name").val($(this).data('project-name'));
                $("#editProjectModal").modal({backdrop: false});
            });
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
            toastr["success"]("Project Successfully Added!");
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
            toastr["success"]("Project Successfully Updated!");
        </script>
        @endif
    </body>
</html>
