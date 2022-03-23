@extends('master.master')
@section('title','Data Role')
@section('content')

    {!! Form::open(array('class' => "needs_validation", 'novalidate')) !!}

    <div class="form-group col-xs-12">
      {!! Form::label('name','Nama Role') !!}
      {!! Form::text('name',isset($role)?$role->name:'',array("class" => "form-control", "placeholder" => "Masukan Nama Role", 'required'))!!}
      <div class="invalid-feedback">
        Masukan Nama Role Tidak Boleh Kosong
      </div>
    </div>

    <div class="form-group col-xs-12">
      {!! Form::label('display_name','Nama Role Publish') !!}
      {!! Form::text('display_name',isset($role)?$role->display_name:'',array("class" => "form-control", "placeholder" => "Masukan Nama Role Publish", 'name' => 'display_name'))!!}
    </div>

    <div class="form-group col-xs-12">
      {!! Form::label('description','Deskripsi') !!}
      {!! Form::text('description',isset($role)?$role->description:'',array("class" => "form-control", "placeholder" => "Masukan Deskripsi"))!!}
    </div>

    <div class="form-group col-xs-12">
      {!! Form::label('permission[]','Permission') !!}
      {!! Form::select('permission[]',$permission,isset($role)?$role->permission:'',array("class" => "form-control multipleSelect", 'multiple'=>'multiple'))!!}
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
