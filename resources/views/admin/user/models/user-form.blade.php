<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        {{-- <form class="form-horizontal" method="post" action="{{route('save-user')}}" id="user-form"> --}}
        <form class="form-horizontal"  id="user-form">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">User Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    @csrf
                    <div class="form-group row">
                        <label for="fname" class="col-sm-3 col-form-label">First Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" value="{{ old('fname',isset($user['fname'])?$user['fname']:'')}}">
                            {{-- @if ($errors->has('fname'))
                                <label><span class="error  text-danger">{{ $errors->first('fname') }}</span></label>
                            @endif --}}
                            <label><span class="error text-danger" id="fname-error"></span></label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 col-form-label">Last Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="{{ old('lname',isset($user['lname'])?$user['lname']:'')}}">
                            {{-- @if ($errors->has('lname'))
                                <label><span class="error text-danger">{{ $errors->first('lname') }}</span></label>
                            @endif --}}
                            <label><span class="error text-danger" id="lname-error"></span></label>
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <label for="dob" class="col-sm-3 col-form-label">Date Of Birth</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="dob" name="dob" placeholder="Date Of Birth" value="{{ old('dob',isset($user['dob']) ? date("dd/mm/YYYYY", strtotime($user['dob'])):'')}}">
                            {{-- @if ($errors->has('dob'))
                                <label><span class="error text-danger">{{ $errors->first('dob') }}</span></label>
                            @endif --}}
                            <label><span class="error text-danger" id="dob-error"></span></label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="username" class="col-sm-3 col-form-label">User Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="username" name="username" placeholder="User Name" value="{{ old('username',isset($user['user_name']) ? $user['user_name']:'')}}">
                            {{-- @if ($errors->has('username'))
                                <label><span class="error text-danger">{{ $errors->first('username') }}</span></label>
                            @endif --}}
                            <label><span class="error text-danger" id="username-error"></span></label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email',isset($user['email'])?$user['email']:'')}}">
                            {{-- @if ($errors->has('email'))
                                <label><span class="error text-danger">{{ $errors->first('email') }}</span></label>
                            @endif --}}
                            <label><span class="error text-danger" id="email-error"></span></label>
                        </div>
                    </div>
                        
                    <div class="form-group row">
                        <label for="inputName2" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="">
                            {{-- @if ($errors->has('password'))
                                <label><span class="error text-danger">{{ $errors->first('password') }}</span></label>
                            @endif --}}
                            <label><span class="error text-danger" id="password-error"></span></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="confirmPassword" class="col-sm-3 col-form-label">Confirm Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" value="">
                            {{-- @if ($errors->has('confirmPassword'))
                                <label><span class="error text-danger">{{ $errors->first('confirmPassword') }}</span></label>
                            @endif --}}
                            <label><span class="error text-danger" id="confirmPassword-error"></span></label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->