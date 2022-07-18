  <!-- Modal -->
  <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" style="width: 80%" role="document">
        <form action="" method="POST" class="form-horizontal">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama_supplier"class="col-md-2 col-md-offset-1 control-label" >Nama</label>
                        <div class="col-md-6">
                            <input type="text" name="nama_supplier" id="nama_supplier" onkeyup="upsupplier()" class="form-control" required autofocus><span class="help-block with-errors"></span>
                        </div>
                    </div> 
                    <div class="form-group row">
                      <label for="telepon"class="col-md-2 col-md-offset-1 control-label" >Telepon</label>
                      <div class="col-md-6">
                          <input type="text" name="telepon" id="telepon" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control" required autofocus><span class="help-block with-errors"></span>
                      </div>
                  </div>
                  <div class="form-group row">
                    <label for="alamat"class="col-md-2 col-md-offset-1 control-label" >Alamat</label>
                    <div class="col-md-6">
                      <textarea name="alamat" id="alamat" onkeyup="upsupplier()" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                  <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
              </div>
        </form>
    </div>
  </div>