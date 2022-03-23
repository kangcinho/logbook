<div class="modal fade" id="modalTambahEditPasien" tabindex="-1" role="dialog" aria-labelledby="modalTambahEditPasien" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title">Tambah Data Pasien</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="msgHasilPencarianRM"></div>
        {!! Form::open(array('class' => "needs_validation", 'novalidate', 'id'=>'editTambahPasien')) !!}
          {!! Form::label('slug','Slug',array('style'=>'display:none')) !!}
          {!! Form::text('slug','',array('style' => 'display:none')) !!}
          <div class="form-group col-xs-12">
            <div class="input-group">
              {!! Form::text('no_rm','',array("class" => "form-control", "placeholder" => "Masukan Nomor RM", "required", "id"=>"no_rm" ))!!}
              <span class="input-group-btn" id="btnSearchNRM"><button class="btn btn-outline"><span class="fas fa-search"></span></button></span>
            </div>
          </div>

          <div class="form-group col-xs-12">
            {!! Form::label('nama','Nama Pasien') !!}
            {!! Form::text('nama','',array("class" => "form-control", "placeholder" => "Masukan Nama Pasien", "required" ))!!}
            <div class="invalid-feedback">
              Nama Pasien Tidak Boleh Kosong
            </div>
          </div>

          <div class="form-group col-xs-12">
            {!! Form::label('tlp','Telpon') !!}
            {!! Form::text('tlp','',array("class" => "form-control", "placeholder" => "Masukan Nomor Telpon", "required" ))!!}
            <div class="invalid-feedback">
              Nomor Telpon Tidak Boleh Kosong
            </div>
          </div>

          <div class="form-group col-xs-12">
            {!! Form::label('tgl_lahir','Tanggal Lahir') !!}
            {!! Form::date('tgl_lahir','',array("class" => "form-control", "placeholder" => "Masukan Tanggal Lahir", "required" ))!!}
            <div class="invalid-feedback">
              Tanggal Lahir Tidak Boleh Kosong
            </div>
          </div>

          <div class="form-group col-xs-12">
            {!! Form::label('alamat','Alamat') !!}
            {!! Form::textarea('alamat','',array("class" => "form-control", "placeholder" => "Masukan Alamat", "required", 'style' => 'resize:none', 'rows' => '2' ))!!}
            <div class="invalid-feedback">
              Alamat Tidak Boleh Kosong
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
