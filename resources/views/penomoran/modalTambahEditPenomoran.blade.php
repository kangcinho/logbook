<div class="modal fade" id="modalTambahEditPenomoran" tabindex="-1" role="dialog" aria-labelledby="modalTambahEditPenomoran" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title">Data Penomoran BPJS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="msgHasilPencarianRM"></div>
        {!! Form::open(array('class' => "needs_validation", 'novalidate', 'id'=>'editTambahPenomoranBPJS')) !!}
          <div class="row">
            <div class="form-group col-xs-12">
              {!! Form::label('id','Slug',array('style'=>'display:none')) !!}
              {!! Form::text('id','',array('style' => 'display:none')) !!}
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('no_rm','Nomor RM Pasien') !!}
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
              {!! Form::label('tgl_lahir','Tanggal Lahir Pasien') !!}
              {!! Form::date('tgl_lahir','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Tanggal Lahir" ))!!}
            </div>

            <div class="form-group col-xs-12 col-md-6">
              {!! Form::label('alamat','Alamat Pasien') !!}
              {!! Form::textarea('alamat','',array("class" => "form-control form-control-sm", "placeholder" => "Masukan Alamat Pasien", "required", 'rows'=>"1", 'style'=>'resize:none' ))!!}
              <div class="invalid-feedback">
                Alamat Pasien Tidak Boleh Kosong
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
  </div>
</div>
