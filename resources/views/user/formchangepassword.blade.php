@extends('master.master')
@section('title','Data User')
@section('content')
  <div id="statusMsg">
    @if(session('status'))
      <div class="alert alert-danger alert-dissmisible fade show" role="alert" >
        {{ session('status') }}
        <button data-dismiss="alert" class="close" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
  </div>

    {!! Form::open(array('class' => "needs_validation", 'novalidate', 'id'=>'changePassword')) !!}

    <div class="form-group col-xs-12">
      {!! Form::label('password','Password Lama') !!}
      {!! Form::password('password',array("class" => "form-control", "placeholder" => "Masukan Password Lama", 'required'))!!}
      <div class="invalid-feedback">
        Masukan Password Lama Tidak Boleh Kosong
      </div>
    </div>

    <div class="form-group col-xs-12">
      {!! Form::label('password_new','Password Baru') !!}
      {!! Form::password('password_new',array("class" => "form-control", "placeholder" => "Masukan Password Baru", 'required'))!!}
      <div class="invalid-feedback">
        Masukan Password Baru Tidak Boleh Kosong
      </div>
    </div>

    <div class="form-group col-xs-12">
      {!! Form::label('password_new_confirm','Ulangi Password Baru') !!}
      {!! Form::password('password_new_confirm',array("class" => "form-control", "placeholder" => "Ulangi Masukan Password Baru", 'required'))!!}
      <div class="invalid-feedback">
        Masukan Ulangi Password Baru Tidak Boleh Kosong
      </div>
    </div>

    <div class="text-right">
      <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-ban"></span> Batal</button>
    </div>
  {!! Form::close() !!}
@endsection
@section('additionalJS')
  <script>
    $('#changePassword').on('submit',function(e){
      if($('#password_new').val() === $('#password_new_confirm').val()){
        return true;
      }
      $('#statusMsg').html('\
      <div class="alert alert-danger alert-dissmisible fade show" role="alert" >\
        "Password Baru" dan "Ulangi Password Baru" harus sama\
        <button data-dismiss="alert" class="close" aria-label="Close">\
          <span aria-hidden="true">&times;</span>\
        </button>\
      </div>\
      ');
      return false;
    });
  </script>
@endsection
