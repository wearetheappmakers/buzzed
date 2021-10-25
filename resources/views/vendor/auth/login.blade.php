@extends('admin.layout.auth')

@section('content')
<form class="kt-form login_form" id="login_form"  role="form" method="POST" action="{{ url('/vendor/login') }}">
                        {{ csrf_field() }}
                        	<div class="kt-login__signin">
								<div class="kt-login__head">
									<h3 class="kt-login__title">Sign In To Vendor</h3>
								</div>
								</div>

                        <div class="input-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <input id="email" type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" autofocus>

                        </div>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password">

                                
                        </div>
@if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
	                        <div class="row kt-login__extra">
									<div class="col">
										<label class="kt-checkbox">
											<input type="checkbox" name="remember"> Remember me
											<span></span>
										</label>
									</div>
									<div class="col kt-align-right">
										<a href="{{ url('/vendor/password/reset') }}" class="kt-login__link">Forget Password ?</a>
									</div>
								</div>
								<div class="kt-login__actions">
									<button type="submit" id="submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Sign In</button>
									<!-- <a href="{{ url('/customer/register') }}"><button type="button" id="submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Register</button></a> -->
								</div>
                    </form>
@endsection
