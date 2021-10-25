@extends('admin.layout.auth')

<!-- Main Content -->
@section('content')

<div class="">
    <div class="kt-login__head">
        <h3 class="kt-login__title">Forgotten Password ?</h3>
        <div class="kt-login__desc">Enter your email to reset your password:</div>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form class="kt-form" method="POST" action="{{ url('/admin/password/email') }}">
        {{ csrf_field() }}
        <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <input class="form-control" type="email" placeholder="Email" value="{{ old('email') }}" name="email" id="kt_email">
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="kt-login__actions">
            <button type="submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Request</button>&nbsp;&nbsp;
        <button class="btn btn-light btn-elevate kt-login__btn-secondary"><a href="{{url('admin/login')}}">Cancel</a></button>
        </div>
    </form>
</div>
@endsection
