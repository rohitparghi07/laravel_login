@php
    $dashboard="Dashboard";
    $displayMasterName = "User";
    $routeFrom="user";
@endphp

@extends('admin.layout.app')

<script type="text/javascript">
    var isUserValidationError ="{{  $errors->any() ? true : false}}";
</script>

@section('content-header')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include('admin.layout.page-header')

        <!-- Main content -->
        <section class="content">

            <div id="headerMsg" class="error_msg">
                @if(session()->has("error") || session()->has("success"))
                    <div class="alert {{session()->has('error') ? 'alert-danger' : 'alert-success' }}">
                        <h4><i class='icon fa fa-check'></i>{{session()->has('error') ? 'Warning' : 'Success'}}</h4>
                        {{session()->has('error') ? session()->get('error') : session()->get('success') }}
                    </div>
                @endif
            </div><br>

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users</h3>
                    <div class="card-tools">
                        {{-- <button type="button" class="btn btn-xs" onClick="javascript:void(0);" id="adduser"><i class="fas fa-plus"></i> Add</button> --}}
                        <button type="button" class="btn btn-xs btn-default" onClick="javascript:void(0);" id="adduser" data-toggle="modal" data-target="#modal-default">
                            <i class="fas fa-plus"></i> Add New User
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="user-list table-responsive">
                        <table class="table table-bordered table-hover dataTable" id="userTable">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Date OF Birth</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{--  user list here load using datatable--}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('admin.user.models.user-form')
    @include('admin.user.models.delete-user')
@endsection
@section('js-footer')
    <script src="{{ asset('resources/js/admin/user/user.js')  }}" type="text/javascript"></script>
@endsection
