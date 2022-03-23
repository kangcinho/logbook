@extends('master.master')
@section('title','Data User')
@section('content')

    {!! Form::open(array('class' => "needs_validation", 'novalidate')) !!}

    <div class="form-group col-xs-12">
      {!! Form::label('name','Nama User') !!}
      {!! Form::text('name',isset($user)?$user->name:'',array("class" => "form-control", "placeholder" => "Masukan Nama User", 'required'))!!}
      <div class="invalid-feedback">
        Masukan Nama User Tidak Boleh Kosong
      </div>
    </div>

    <div class="form-group col-xs-12">
      {!! Form::label('username','Username') !!}
      {!! Form::text('username',isset($user)?$user->username:'',array("class" => "form-control", "placeholder" => "Masukan Username", 'required'))!!}
    </div>

    <div class="form-group col-xs-12">
      {!! Form::label('password','Password') !!}
      {!! Form::password('password',array("class" => "form-control", "placeholder" => "Masukan Passowrd"))!!}
    </div>

    <div class="form-group col-xs-12">
      {!! Form::label('roles[]','Role') !!}
      {!! Form::select('roles[]',$roles,isset($user)?$user->roles:'',array("class" => "form-control multipleSelect", 'multiple'=>'multiple'))!!}
    </div>

    <div class="text-right">
      <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-ban"></span> Batal</button>
    </div>
  {!! Form::close() !!}
@endsection
@section('additionalJS')
  <script type="text/javascript">
    $(document).ready(function(){
      $('.multipleSelect').select2();
    })
  </script>
@endsection
