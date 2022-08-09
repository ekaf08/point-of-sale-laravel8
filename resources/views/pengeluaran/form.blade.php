  <!-- Modal -->
  <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog"  role="document">
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
                        <label for="deskripsi"class="col-md-2 col-md-offset-1 control-label" >Jenis Pengeluaran</label>
                        <div class="col-md-6">
                            <input type="text" name="deskripsi" id="deskripsi" onkeyup="pengeluaran()" class="form-control" required autofocus><span class="help-block with-errors"></span>
                        </div>
                    </div> 
                    <div class="form-group row">
                      <label for="nominal"class="col-md-2 col-md-offset-1 control-label" >Nominal</label>
                      <div class="col-md-6">
                          <input type="text" name="nominal" id="nominal" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control" required autofocus><span class="help-block with-errors"></span>
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