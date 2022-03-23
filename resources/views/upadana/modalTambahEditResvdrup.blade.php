<div class="modal fade" id="modalTambahEditResvdrup" tabindex="-1" role="dialog" aria-labelledby="modalTambahEditKamar" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title">Tambah Data Pendaftaran dr.Upadana</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="msgHasilPencarianRM"></div>
        {!! Form::open(array('class' => "needs_validation", 'novalidate', 'id'=>'editTambahResvdrup')) !!}
          <div class="row">
            <div class="form-group col-xs-12">
              {!! Form::label('slugUP','Slug',array('style'=>'display:none')) !!}
              {!! Form::text('slugUP','',array('style' => 'display:none')) !!}
              {!! Form::label('slugPasien','Slug',array('style'=>'display:none')) !!}
              {!! Form::text('slugPasien','',array('style' => 'display:none')) !!}
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('tgl_reservasi','Tanggal Booking') !!}
              {!! Form::date('tgl_reservasi','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Tanggal Reservasi", "required" ))!!}
              <div class="invalid-feedback">
                Tanggal Booking Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6 timepicker">
              {!! Form::label('pukul_reservasi','Waktu Booking') !!}
              {!! Form::text('pukul_reservasi','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Pukul Reservasi", "required" ))!!}
              <div class="form-text text-danger small" id="suggestTime"></div>
              <div class="invalid-feedback">
                Waktu Booking Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('no_rm','Nomor RM') !!}
              <div class="input-group input-group-sm">
                {!! Form::text('no_rm','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Nomor RM", "id"=>"no_rm" ))!!}
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

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('alamat','Alamat Pasien') !!}
              {!! Form::textarea('alamat','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Alamat Pasien", "required", 'rows'=>"1", 'style'=>'resize:none' ))!!}
              <div class="invalid-feedback">
                Alamat Pasien Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('no_antrian','Nomor Antrian') !!}
              <div class="input-group input-group-sm">
                {!! Form::text('no_antrian','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Nomor Antrian", "id"=>"no_antrian", 'required' ))!!}
                <span class="input-group-btn" id="btnSearchNomorAntrean"><button class="btn btn-outline"><span class="fas fa-search"></span></button></span>
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-6 d-none">
              {!! Form::label('id_bpjs','ID BPJS') !!}
              {!! Form::text('id_bpjs','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan ID BPJS" ))!!}
            </div>

            <div class="form-group col-xs-12 col-md-6 d-none">
              {!! Form::label('kelas_bpjs','Kelas BPJS') !!}
              {!! Form::text('kelas_bpjs','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Kelas BPJS" ))!!}
            </div>

            <div class="form-check form-check-inline ml-4 pl-2">
              <input class="form-check-input" type="checkbox" id="confirm" name="confirm">
              <label for="confirm">Konfirmasi Kehadiran Pasien</label>
            </div>
          </div>

          <div class="text-right">
            <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-ban"></span> Batal</button>
          </div>

        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
