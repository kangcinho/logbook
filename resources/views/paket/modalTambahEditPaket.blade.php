<div class="modal fade" id="modalTambahEditPaket" tabindex="-1" role="dialog" aria-labelledby="modalTambahEditPaket" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title">Tambah Data Paket</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!! Form::open(array('class' => "needs_validation", 'novalidate', 'id'=>'editTambahPaket')) !!}
          <div class="form-group col-xs-12">
            {!! Form::label('slug','Slug',array('style'=>'display:none')) !!}
            {!! Form::text('slug','',array('style' => 'display:none')) !!}
            {!! Form::label('nama_paket','Nama Paket') !!}
            {!! Form::text('nama_paket','',array("class" => "form-control", "placeholder" => "Masukan Nama Paket", "required" ))!!}
            <div class="invalid-feedback">
              Nama Paket Tidak Boleh Kosong
            </div>
          </div>
          <div class="form-group col-xs-12">
            {!! Form::label('deskripsi_paket','Deskripsi Paket') !!}
            {!! Form::textarea('deskripsi_paket','',array("class" => "form-control", "placeholder" => "Masukan Deskripsi Paket", 'style' => 'resize:none' ))!!}
            <div class="valid-feedback">
              Deskripsi Paket Boleh Kosong
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
