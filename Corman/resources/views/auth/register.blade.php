@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cognome') ? ' has-error' : '' }}">
                            <label for="cognome" class="col-md-4 control-label">Surname</label>

                            <div class="col-md-6">
                                <input id="cognome" type="text" class="form-control" name="cognome" value="{{ old('cognome') }}" required>

                                @if ($errors->has('cognome'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cognome') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('dataNascita') ? ' has-error' : '' }}">
                            <label for="dataNascita" class="col-md-4 control-label">Birthday</label>

                            <div class="col-md-6">
                                <input type="date" name="dataNascita" class="form-control" id="dataNascita">
                                @if ($errors->has('dataNascita'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dataNascita') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nazionalita') ? ' has-error' : '' }}">
                            <label for="nazionalita" class="col-md-4 control-label">Nationality</label>

                            <div class="col-md-6">
                                <input id="nazionalita" type="text" class="form-control" name="nazionalita" value="{{ old('nazionalita') }}" required>

                                @if ($errors->has('nazionalita'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nazionalita') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('affiliazione') ? ' has-error' : '' }}">
                            <label for="nazionalita" class="col-md-4 control-label">Affiliation</label>

                            <div class="col-md-6">
                                <input id="affiliazione" type="text" class="form-control" name="affiliazione" value="{{ old('affiliazione') }}" required>

                                @if ($errors->has('affiliazione'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('affiliazione') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('dipartimento') ? ' has-error' : '' }}">
                            <label for="dipartimento" class="col-md-4 control-label">Work Address</label>

                            <div class="col-md-6">
                                <input id="dipartimento" type="text" class="form-control" name="dipartimento" value="{{ old('dipartimento') }}" required>

                                @if ($errors->has('dipartimento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dipartimento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('linea_ricerca') ? ' has-error' : '' }}">
                            <label for="linea_ricerca" class="col-md-4 control-label">Research Field</label>

                            <div class="col-md-6">
                                <input id="linea_ricerca" type="text" class="form-control" name="linea_ricerca" value="{{ old('linea_ricerca') }}" required>

                                @if ($errors->has('linea_ricerca'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('linea_ricerca') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
                            <label for="telefono" class="col-md-4 control-label">Phone number</label>

                            <div class="col-md-6">
                                <input id="telefono" type="text" class="form-control" name="telefono" value="{{ old('telefono') }}" required>

                                @if ($errors->has('telefono'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telefono') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
