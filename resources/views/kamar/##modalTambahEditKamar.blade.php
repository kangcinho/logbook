<div class="modal fade" id="modalTambahEditKamar" tabindex="-1" role="dialog" aria-labelledby="modalTambahEditKamar" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title">Tambah Data Kamar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!! Form::open(array('class' => "needs_validation", 'novalidate', 'id'=>'editTambahKamar')) !!}
          <div class="form-group col-xs-12">
            {!! Form::label('slug','Slug',array('style'=>'display:none')) !!}
            {!! Form::text('slug','',array('style' => 'display:none')) !!}
            {!! Form::label('nama_kamar','Nama Kamar') !!}
            {!! Form::text('nama_kamar','',array("class" => "form-control", "placeholder" => "Masukan Nama Kamar", "required"))!!}
            <div class="invalid-feedback">
              Nama Kamar Tidak Boleh Kosong
            </div>
          </div>
          <div class="form-group col-xs-12">
            {!! Form::label('deskripsi_kamar','Deskripsi Kamar') !!}
            {!! Form::textarea('deskripsi_kamar','',array("class" => "form-control", "placeholder" => "Masukan Deskripsi Kamar", 'style' => 'resize:none' ))!!}
            <div class="valid-feedback">
              Deskripsi Kamar Boleh Kosong
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
