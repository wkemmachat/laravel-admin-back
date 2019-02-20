@extends('layouts.back.blank')


@section('title')
    User
@endsection

@section('content')

<div class="content-wrapper">

    {!! Toastr::render() !!}

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section class="content-header">
        <h1>
          Manage User
          <small>Add/Edit/List Users</small>
        </h1>
        {{--  <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="#">Examples</a></li>
          <li class="active">Blank page</li>
        </ol>  --}}
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
                    <div class="box box-primary" style="">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit User</h3>
                        </div>

                        <div class="box-body">
                                <div class="register-box-body">

                                        <form action="{{route('user.update',$userSelected->id)}}" method="post" enctype="multipart/form-data">
                                            @method('PATCH')
                                            @csrf

                                            <div style="margin-bottom: 25px;">
                                                <img src="{{$userSelected->photo ? $userSelected->photo->file : 'http://placehold.it/400x400'}}" alt="" class="img-responsive img-rounded"
                                                style="display: block;
                                                margin-left: auto;
                                                margin-right: auto;">
                                            </div>

                                            <div class="form-group has-feedback">
                                                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Full name" name="name" value="{{ $userSelected->name }}"  autofocus>
                                                <span class="glyphicon glyphicon-user form-control-feedback"></span>

                                                @if ($errors->has('name'))
                                                    <span class="text-red" role="alert">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>



                                            <div class="form-group has-feedback">
                                                <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" name="email" value="{{ $userSelected->email }}" >
                                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                                                @if ($errors->has('email'))
                                                    <span class="text-red" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group has-feedback">
                                                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password" >
                                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                                                @if ($errors->has('password'))
                                                    <span class="text-red" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group has-feedback">
                                                <input type="password" class="form-control" placeholder="Retype password" name="password_confirmation" >
                                                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                                            </div>


                                            <div class="form-group">
                                                <label for="InputFile">Image Upload</label>
                                                <input type="file" class="" id="InputFile" placeholder="" name="photo_id" >
                                            </div>

                                            <div class="form-group has-feedback">
                                                <select name="user_type" class="form-control select2" placeholder="USER_TYPE">
                                                    <option {{ ($userSelected->user_type =='user')?"selected":"" }} value="user">USER</option>
                                                    <option {{ ($userSelected->user_type =='admin')?"selected":"" }} value="admin">ADMIN</option>
                                                    <option {{ ($userSelected->user_type =='root')?"selected":"" }} value="root">ROOT</option>
                                                </select>
                                            </div>


                                            <div class="row">
                                                <div class="col-xs-8">
                                                    {{--  <div class="checkbox icheck">
                                                    <label>
                                                        <input type="checkbox"> I agree to the <a href="#">terms</a>
                                                    </label>
                                                    </div>  --}}
                                                </div>
                                            <!-- /.col -->
                                                <div class="col-xs-4">
                                                    <button type="submit" class="btn btn-warning btn-block btn-flat">Edit</button>
                                                </div>
                                            <!-- /.col -->
                                            </div>
                                        </form>

                                        {{--  <div class="social-auth-links text-center">
                                            <p>- OR -</p>
                                            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
                                            Facebook</a>
                                            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
                                            Google+</a>
                                        </div>  --}}

                                        {{--  <a href="{{ route('login') }}" class="text-center">I already have a membership</a>  --}}
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">User Type</h3>
                    </div>
                    <div class="box-body">
                        <p>1) User (No login allowed) </p>
                        <p>2) Admin (login allowed, can input data, uses EMAIL to login) </p>
                        <p>3) Root (login allowed and can manage user) </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- List User -->




      <!-- /.box -->


    </section>
    <!-- /.content -->


</div>



@endsection




