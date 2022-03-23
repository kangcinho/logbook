<div class="modal fade" id="modalTambahEditPermission" tabindex="-1" role="dialog" aria-labelledby="modalTambahEditPermission" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title">Tambah Data Permission</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!! Form::open(array('class' => "needs_validation", 'novalidate', 'id'=>'tambahPermission')) !!}
          <div class="row">
            <div class="form-group col-xs-12 col-md-12">
              {!! Form::label('name','Nama Permission') !!}
              {!! Form::text('name','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Nama Permission", "required" ))!!}
              <div class="invalid-feedback">
                Nama Permission Tidak Boleh Kosong
              </div>
            </div>

            <div class="form-group col-xs-12 col-md-12">
              {!! Form::label('display_name','Nama Permission Publish') !!}
              {!! Form::text('display_name','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Nama Permission Publish" ))!!}
            </div>

            <div class="form-group col-xs-12 col-md-12">
              {!! Form::label('description','Deskripsi') !!}
              {!! Form::text('description','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Deskripsi"))!!}
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
