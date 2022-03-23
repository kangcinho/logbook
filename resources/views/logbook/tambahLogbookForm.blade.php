@extends('master.master')
@section('title', 'Logbook Form')
@section('content')
  <div id="statusMsg">
    @if(session('msg'))
      <div class="alert alert-sm alert-info alert-dissmisible fade show" role="alert" >
        {!! session('msg') !!}
        <button data-dismiss="alert" class="close" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
  </div>
  <div class="card">
    <div class="card-header bg-info">
      <h5>Data Logbook</h5>
    </div>
    <div class="card-body">
      {!! Form::open(array('class' => "needs_validation", 'novalidate', 'id'=>'editTambahLogbook')) !!}
          {!! Form::label('slugPasien','Slug',array('style'=>'display:none')) !!}
          {!! Form::text('slugPasien','',array('style' => 'display:none')) !!}
          {!! Form::label('slugLogbook','Slug',array('style'=>'display:none')) !!}
          {!! Form::text('slugLogbook','',array('style' => 'display:none')) !!}
          <div class="row">
            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('no_rm','Nomor RM') !!}
              <div class="input-group input-group-sm">
                {!! Form::text('no_rm','',array("class" => "form-control ", "placeholder" => "Masukan Nomor RM", "required", "id"=>"no_rm" ))!!}
                <span class="input-group-btn" id="btnSearchNRM"><button class="btn btn-outline"><span class="fas fa-search"></span></button></span>
              </div>
            </div>
            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('nama','Nama Pasien') !!}
              {!! Form::text('nama','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Nama Pasien", "required" ))!!}
              <div class="invalid-feedback">
                Nama Pasien Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('tlp','Telpon Pasien') !!}
              {!! Form::text('tlp','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Nomor Telpon", "required" ))!!}
              <div class="invalid-feedback">
                Nomor Telpon Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('tgl_lahir','Tanggal Lahir Pasien') !!}
              {!! Form::date('tgl_lahir','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Tanggal Lahir", "required" ))!!}
              <div class="invalid-feedback">
                Tanggal Lahir Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-12">
              {!! Form::label('alamat','Alamat Pasien') !!}
              {!! Form::textarea('alamat','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Alamat", "required", 'style' => 'resize:none', 'rows' => '1' ))!!}
              <div class="invalid-feedback">
                Alamat Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('id_bpjs','ID BPJS') !!}
              {!! Form::text('id_bpjs','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan ID" ))!!}
              <div class="valid-feedback">
                ID BPJS Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('kelas_bpjs','Kelas BPJS') !!}
              {!! Form::text('kelas_bpjs','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Kelas BPJS" ))!!}
              <div class="valid-feedback">
                Kelas BPJS Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('no_sep','Nomor SEP') !!}
              {!! Form::text('no_sep','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Nomor SEP" ))!!}
              <div class="valid-feedback">
                Nomor SEP Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('ppk','PPK I') !!}
              {!! Form::text('ppk','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Data PPK", "required" ))!!}
              <div class="invalid-feedback">
                Data PPK Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('dokter_perujuk','Dokter Perujuk') !!}
              {!! Form::text('dokter_perujuk','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Nama Dokter Perujuk", "required" ))!!}
              <div class="invalid-feedback">
                Nama Dokter Perujuk Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('kamar_logbook','Nomor Kamar') !!}
              <select class="form-control form-control-sm" name="kamar_logbook" id="kamar_logbook">
                <option value="" selected></option>
                @foreach($kamars as $kamar)
                  <optgroup label="{{ $kamar->nama_kamar }}">
                    @foreach($kamar->no_kamar as $noKamar)
                      <option value="{{ $noKamar->slug }}">{{$noKamar->no_kamar}}</option>
                    @endforeach
                  </optgroup>
                @endforeach
              </select>
              <div class="invalid-feedback">
                Kamar Logbook Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('paket_logbook','Paket') !!}
              {!! Form::select('paket_logbook',$paket,'',array("class" => "form-control form-control-sm", "placeholder" => "Pilih Paket", "required" ))!!}
              <div class="invalid-feedback">
                Paket Logbook Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('nama_dokter','Nama Dokter') !!}
              {!! Form::text('nama_dokter','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Nama Dokter yang Menghandle", "required" ))!!}
              <div class="invalid-feedback">
                Nama Dokter Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('check_in', 'Tanggal Check In') !!}
              {!! Form::date('check_in', null, array("class" => "form-control form-control-sm", "required")) !!}
              <div class="invalid-feedback">
                Tanggal Check In Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('check_out', 'Tanggal Check Out') !!}
              {!! Form::date('check_out',null, array("class" => "form-control form-control-sm")) !!}
              <div class="valid-feedback">
                Tanggal Check Out Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('keterangan_tindakan','Ket / Tindakan') !!}
              {!! Form::textarea('keterangan_tindakan','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Keterangan atau Tindakan", "required" ,'style' => 'resize:none',  "rows" => '2'))!!}
              <div class="invalid-feedback">
                Data Keterangan atau Tindakan Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('diagnosa','Diagnosa') !!}
              {!! Form::textarea('diagnosa','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Diagnosa", "required" , 'style' => 'resize:none', "rows" => '2'))!!}
              <div class="invalid-feedback">
                Data Diagnosa Tidak Boleh Kosong
              </div>
            </div>
          </div>

        <div class="text-right">
          <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-ban"></span> Batal</button>
        </div>
      {!! Form::close() !!}
    </div>
  </div>
@endsection
@section('additionalJS')
  <script type="text/javascript" src="{!! asset('js/needs_validation.js') !!}"></script>
  <script>
    $(document).ready(function(){
      $("#no_rm").focus();

      $('#no_rm').on('keypress',function(e){
        if(e.which == 13){
          $('#btnSearchNRM').click();
          $('#no_sep').focus();
        }
      })

      $('#btnSearchNRM').on('click', function(e){
        e.preventDefault();
        var nrm = $("#no_rm").val();
        $.ajax({
          type:'GET',
          url: '../getPasienIndividual/'+nrm,
          success:function(data){
            if(data.flag == "mysql"){
              $("#slugPasien").val(data.data.slug);
              $("#nama").val(data.data.nama);
              $("#tlp").val(data.data.tlp);
              $('#tgl_lahir').val(data.data.tgl_lahir.split(' ')[0])
              $("#alamat").val(data.data.alamat);
              $("#id_bpjs").val('');
              $('#kelas_bpjs').val('');
            }else if(data.flag == 'sqlserver'){
              //data SQL SERVER
              $("#slugPasien").val('');
              $("#nama").val(data.data.NamaPasien);
              $("#tlp").val(data.data.Phone);
              $('#tgl_lahir').val(data.data.TglLahir.split(' ')[0])
              $("#alamat").val(data.data.Alamat);
              $("#id_bpjs").val('');
              $('#kelas_bpjs').val('');
            }

            if(data.msg){
              alertSuccess(data.msg, 'msgHasilPencarianRM');
              $("#slugPasien").val('');
              $("#nama").val('');
              $("#tlp").val('');
              $('#tgl_lahir').val('');
              $("#alamat").val('');
            }
          }
        });
      })

      $("#no_rm").on('keypress',function(e){
        if(e.which == 13){
          $(this).click();
        }
      })

      $.fn.select2.defaults.set( "theme", "bootstrap4" );
      $('#kamar_logbook').select2({
        width : "100%",
        placeholder : "Pilih Nomor Kamar"
      });
    });
  </script>

@endsection
