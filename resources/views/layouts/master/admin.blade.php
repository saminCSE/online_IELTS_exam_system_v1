<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="">
    <title>Wings Exam</title>
    @include('layouts.header')
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand" href="{{ route('AdminDashboard') }}">
                <div class="sidebar-brand-text mx-3">Wings Exam</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('AdminDashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Admin Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>


            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#types"
                    aria-expanded="true" aria-controls="collapseRole">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Types</span>
                </a>
                <div id="types" class="collapse" aria-labelledby="headingRole" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <a class="collapse-item" href="{{ route('types.create') }}">Create Types</a> -->
                        <a class="collapse-item" href="{{ route('types.index') }}">Show Types</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#courseRole"
                    aria-expanded="true" aria-controls="collapseRole">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Skills</span>
                </a>
                <div id="courseRole" class="collapse" aria-labelledby="headingRole" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <a class="collapse-item" href="{{ route('skills.create') }}">Create Skills</a> -->
                        <a class="collapse-item" href="{{ route('skills.index') }}">Show Skills</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#test"
                    aria-expanded="true" aria-controls="collapseRole">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Test Title</span>
                </a>
                <div id="test" class="collapse" aria-labelledby="headingRole" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('testTitle.create') }}">Create Test Title</a>
                        <a class="collapse-item" href="{{ route('testTitle.index') }}">Manage Title</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#questionSet"
                    aria-expanded="true" aria-controls="collapseRole">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Question Set</span>
                </a>
                <div id="questionSet" class="collapse" aria-labelledby="headingRole" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('questions_set.create') }}">Create Question Set</a>
                        <a class="collapse-item" href="{{ route('questions_set.index') }}">Manage Set</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#questionOption"
                    aria-expanded="true" aria-controls="collapseRole">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Questions</span>
                </a>
                <div id="questionOption" class="collapse" aria-labelledby="headingRole"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('questions.create') }}">Create Questions</a>
                        <a class="collapse-item" href="{{ route('questions.index') }}">Manage Questions</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#questionsgroup"
                    aria-expanded="true" aria-controls="collapseRole">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Questions Group</span>
                </a>
                <div id="questionsgroup" class="collapse" aria-labelledby="headingRole"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('questions_group.create') }}">Create Questions
                            Group</a>
                        <a class="collapse-item" href="{{ route('questions_group.index') }}">Manage Questions
                            Group</a>
                        <a class="collapse-item" href="{{ route('questions_group.question_group_list') }}">Questions
                            Group List</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#writtingtest"
                    aria-expanded="true" aria-controls="collapseRole">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Writting Test Review</span>
                </a>
                <div id="writtingtest" class="collapse" aria-labelledby="headingRole"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('writting_test') }}">Manage Writing Test</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#testScore"
                    aria-expanded="true" aria-controls="collapseRole">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Student Test Score</span>
                </a>
                <div id="testScore" class="collapse" aria-labelledby="headingRole" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('admin_test_score') }}">Manage Test Score</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsecandidate"
                    aria-expanded="true" aria-controls="collapseRole">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Candidate Management</span>
                </a>
                <div id="collapsecandidate" class="collapse" aria-labelledby="headingRole"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('add_candidatenumber') }}">Add Candidate Number</a>
                        <a class="collapse-item" href="{{ route('candidate_list') }}">Manage Candidate</a>
                    </div>
                </div>
            </li>
            <!-- Nav Item - Pages Collapse Menu -->
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="gh">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    {{-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> --}}
                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('assets/img/undraw_profile.svg') }}">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                {{-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a> --}}
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
            </div>

            @yield('content')

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Wings Learning Centre@2023</span>
                    </div>
                </div>
            </footer>
        </div>

    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('admin_logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer_script')
</body>

</html>
