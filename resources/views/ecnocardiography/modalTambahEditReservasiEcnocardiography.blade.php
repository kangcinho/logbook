<div class="modal fade" id="modalTambahEditReservasiEcnocardiography" tabindex="-1" role="dialog" aria-labelledby="modalTambahEditReservasiEcnocardiography" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title">Tambah Data Reservasi Echocardiography</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="msgHasilPencarianRM"></div>
        {!! Form::open(array('class' => "needs_validation", 'novalidate', 'id'=>'editTambahReservasiEcnocardiography', 'files'=>'true')) !!}
          <div class="row">
            <div class="form-group col-xs-12">
              {!! Form::label('slugEcnocardiography','Slug',array('style'=>'display:none')) !!}
              {!! Form::text('slugEcnocardiography','',array('style' => 'display:none')) !!}
              {!! Form::label('slugPasien','Slug',array('style'=>'display:none')) !!}
              {!! Form::text('slugPasien','',array('style' => 'display:none')) !!}
            </div>

            <div class="form-group col-xs-12 col-md-4">
              {!! Form::label('tgl_ditindak','Tanggal Dilakukan Tindakan') !!}
              {!! Form::date('tgl_ditindak','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Tanggal Dilakukan Tindakan", "required" ))!!}
              <div class="invalid-feedback">
                Tanggal Dilakukan Tindakan Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-4">
              {!! Form::label('waktu_ditindak','Waktu Dilakukan Tindakan') !!}
              {!! Form::text('waktu_ditindak','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Waktu Dilakukan Tindakan", "required" ))!!}
              <div class="form-text text-danger small" id="suggestTime"></div>
              <div class="invalid-feedback">
                Waktu Dilakukan Tindakan Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-4">
              {!! Form::label('no_rm','Nomor RM') !!}
              <div class="input-group input-group-sm">
                {!! Form::text('no_rm','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Nomor RM", "id"=>"no_rm" ))!!}
                <span class="input-group-btn" id="btnSearchNRM"><button class="btn btn-outline"><span class="fas fa-search"></span></button></span>
              </div>
            </div>
            <div class="form-group col-xs-12 col-md-4">
              {!! Form::label('nama','Nama Pasien') !!}
              {!! Form::text('nama','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Nama Pasien", "required" ))!!}
              <div class="invalid-feedback">
                Nama Pasien Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-4">
              {!! Form::label('tlp','Telpon') !!}
              {!! Form::text('tlp','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Nomor Telpon", "required" ))!!}
              <div class="invalid-feedback">
                Nomor Telpon Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-4 d-none">
              {!! Form::label('tgl_lahir','Tanggal Lahir') !!}
              {!! Form::date('tgl_lahir','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Tanggal Lahir" ))!!}
              <div class="invalid-feedback">
                Tanggal Lahir Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-4">
              {!! Form::label('alamat','Alamat Pasien') !!}
              {!! Form::textarea('alamat','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Alamat Pasien", "required", 'rows'=>"1", 'style'=>'resize:none' ))!!}
              <div class="invalid-feedback">
                Alamat Pasien Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-4">
              {!! Form::label('petugas_poli','Petugas Poli') !!}
              {!! Form::text('petugas_poli','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Petugas Poli", "required"))!!}
              <div class="invalid-feedback">
                Keterangan Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-4">
              {!! Form::label('petugas_fo','Petugas FO') !!}
              {!! Form::text('petugas_fo','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Petugas FO", "required"))!!}
              <div class="invalid-feedback">
                Petugas FO Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-4">
              {!! Form::label('keterangan','Keterangan') !!}
              {!! Form::textarea('keterangan','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Keterangan", "required", 'rows'=>"1", 'style'=>'resize:none'))!!}
              <div class="invalid-feedback">
                Keterangan Tidak Boleh Kosong
              </div>
            </div>

            <div class="custom-file col-xs-12 col-md-12">
              {!! Form::label('surat_rujukan','Surat Rujukan') !!}
              {!! Form::file('surat_rujukan',array("class" => "form-control-file form-control-sm", "placeholder" => "Upload Surat Rujukan"))!!}
              <div class="valid-feedback">
                Surat Rujukan Boleh Kosong
              </div>
            </div>

            <div class="form-check form-check-inline ml-4 pl-2 mt-5">
              <input class="form-check-input" type="checkbox" id="confirm" name="confirm">
              <label for="confirm">Konfirmasi Kehadiran Pasien</label>
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

          <div class="text-right">
            <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-ban"></span> Batal</button>
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
