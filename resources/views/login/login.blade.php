@extends('master.master')
@section('title','Login Form')
@section('content')
  <div class="row justify-content-center">
      <div class="col-md-8">
          <div class="card">
              <div class="card-header">Login Form</div>
              <div class="card-body">
                {!! Form::open() !!}
                <div class="form-group">
                  {!! Form::label('username', 'Username') !!}
                  {!! Form::text('username', '',['class' => 'form-control', 'required' => true]) !!}
                </div>
                <div class="form-group">
                  {!! Form::label('password', 'Password') !!}
                  {!! Form::password('password',['class' => 'form-control', 'required' => true]) !!}
                </div>
                {!! Form::submit('Login') !!}
                {!! Form::close() !!}
              </div>
          </div>
      </div>
  </div>
@endsection
