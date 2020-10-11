<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aizove</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script>
        base_url = "{{ url('/') }}";
        @auth
        storage_url = "{{ Storage::url('/') }}";
        @else
        storage_url = "";
        @endauth
    </script>
    <!-- <script src="https://wchat.freshchat.com/js/widget.js"></script> -->
</head>

<body class="hold-transition sidebar-mini theme-success theme-bg layout-navbar-fixed">

    <div class="wrapper" id="app">
        <!-- Navbar -->
        <nav class="main-header pl-0 navbar navbar-expand bg-white navbar-light border-bottom">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item menu-bar">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item pl-4">
                    <div @click="$backButton()" class="btn pl-0 history-button" title="Click to go back">
                        <i class="fas fa-arrow-left"></i>
                </li>
                <li class="nav-item">
                    <div  class="btn pl-0 history-button" title="Click to go forward"><i class="fas fa-arrow-right"></i>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="btn pl-0 history-button" title="Click to go forward">
                        <i class="fas fa-redo-alt"></i>
                    </div>
                </li>
            </ul>

            <!-- SEARCH FORM -->
            <form class="form-inline w-100 ml-auto" title="Search">
                <div class="input-group col-10 p-0 input-group-sm">
                    <input class="form-control bg-white form-control-navbar" type="search" placeholder="Type in to search ..." aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn bg-white btn-navbar" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Right navbar links -->
            <ul class="navbar-nav">

                <menu-count></menu-count>
                <li class="nav-item dropdown user user-menu" title="User">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="/image/user1-128x128.jpg" class="user-image img-circle" alt="User Image">
                        <i class="right fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                        <img src="/image/user1-128x128.jpg" class="img-circle elevation-2" alt="User Image">

                            <p>
                                {{Auth::user()->name}}
                                <small>Member since Nov. 2019</small>
                            </p>
                        </li>

                        <li class="user-footer">
                            <div class="float-left col-4">
                                <router-link  :to="{ name: 'myProfile', params: { id:{{Auth::user()->id}} } }" class="nav-link">
                                Profile
                                </router-link>
                            </div>
                            <div class="float-right col-4 text-right">
                                <a class="btn p-0 pt-2 pb-2 btn-flat" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <div class="d-flex">
            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-light-primary">
                <!-- Brand Logo -->
                <div class="row">
                    <div class="col-md-12 md-top-p-5">
                        <div class="">
                            <div class="card-body menu-width p-0">
                                <div class="row m-0">
                                    <div class="left-m-bar border-right-l-min p-0">
                                        <router-link to="/admin/dashboard" class="brand-link col-12 p-0 position-relative main-sidebar-brand p-0 text-center">
                                            <div class="both-center col-12 p-0">
                                                <div class="col-12">
                                                    <img src="/image/logo.jpg" alt="Aizove" class="aizov-eap-logo p-0 m-0" style="opacity: .8">
                                                    <!-- <img src="/file?name=logo/icon/{{ config('company_profile.profile.company_logo_icon') }}&disk=company_profile_uploads" alt="Aizov" class="aizov-eap-logo p-0 m-0" style="opacity: .8"> -->
                                                </div>
                                            </div>
                                        </router-link>
                                        @include('layouts.menu')
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper flex-grow-1">
                <main class="py-3">
                @yield('content')
                </main>
            </div>
            <!-- /.content-wrapper -->
        </div>
    </div>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->

    </aside>
    <!-- /.control-sidebar -->
    <!-- File View Modal Start-->
    <div class="modal fade" id="filepreview-common" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">File Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input id="rotateLeft" type="button" value="Left">
                        <input id="rotateRight" type="button" value="Right">
                        <div class="file-Preview-format w-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- File View Modal End -->
    <!-- Video Player Modal Start-->
    <div class="modal fade" id="videoplayer-common" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Video Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="video-Preview w-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video Player Modal End -->
    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2018-2019 <a href="https://aizov.com">Aizov.com</a>.</strong> All rights reserved.
    </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @javascript(['user' => \Auth::user()->toArray()])
    @javascript(['roles' => \Auth::user()->roles])
    @javascript(['VisitorsAPI' => config('app.vistors_api')])
    @javascript(['VisitorsUserName' => config('app.vistors_username')])
    @javascript(['VisitorsPassword' => config('app.vistors_password')])
    <script>
    var APP_URL = {!! json_encode(url('/')) !!}

        window.routes = {
            'rolePermissionIndex' : '{{ route('rolepermissionapi.index') }}',
            'rolePermissionStore' : '{{ route('rolepermissionapi.store') }}',
            'storeRole' : '{{ route('rolepermissionapi.storerole') }}',
            'showRolePermission' : '{{ route('rolepermissionapi.show', ['rolepermissionapi' => 0]) }}',
            'updateRole' : '{{ route('rolepermissionapi.updaterole', ['id' => 0]) }}',
            'destroyRole' : '{{ route('rolepermissionapi.destroyrole', ['id' => 0]) }}',
            'syncPermissionToRole' : '{{ route('rolepermissionapi.syncpermissiontorole') }}',
            'getUserPermissions' : '{{ route('rolepermissionapi.userpermissions') }}',
            'getAllRoles' : '{{ route('rolepermissionapi.getallroles') }}',
            'fileUpload' : '{{ route('fileapi.store') }}',
            'userManageIndex' : '{{ route('usermanageapi.index') }}',
        'userManageStore' : '{{ route('usermanageapi.store') }}',
        'showUserDetailsByUserId' : '{{ route('usermanageapi.showuserdetailsbyuserid', ['userId' => 0]) }}',
        'userMangeUpdate' : '{{ route('usermanageapi.update', ['usermanageapi' => 0]) }}',
        'updateMyProfile' : '{{ route('usermanageapi.updatemyprofile', ['id' => 0]) }}',
        'userManageDestroy' : '{{ route('usermanageapi.destroy', ['usermanageapi' => 0]) }}',
        'userManageShow' : '{{ route('usermanageapi.show', ['usermanageapi' => 0]) }}',
        'showMyProfile' : '{{ route('usermanageapi.showmyprofile', ['id' => 0]) }}',
        'viewMyProfile' : '{{ route('usermanageapi.viewmyprofile', ['id' => 0]) }}',
        'getUsers' : '{{ route('usermanageapi.getusers') }}',
        'getdelegates' : '{{ route('usermanageapi.getdelegates') }}',
        'userOptions' : '{{ route('usermanageapi.useroptions') }}',
        'blogStore' : '{{ route('blogapi.store') }}',
        'blogIndex' : '{{ route('blogapi.index') }}',
        'blogView' : '{{ route('blogapi.view', ['id' => 0]) }}',
        'blogDestroy' : '{{ route('blogapi.destroy', ['blogapi'=>"0"]) }}',
        'blogShow' : '{{ route('blogapi.show', ['blogapi' => 0]) }}',
        'blogUpdate' : '{{ route('blogapi.update', ['blogapi'=>"0"]) }}',
        'logreportIndex' : '{{ route('logreportapi.index') }}'
        }
    </script>

    <!-- <script>
      window.fcWidget.init({
        token: "a637fbec-68d6-47de-8599-a1cf922b5fe2",
        host: "https://wchat.freshchat.com"
      });
    </script> -->
</body>

</html>
