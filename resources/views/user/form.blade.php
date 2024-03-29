  <!-- Modal -->
  <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg"  role="document">
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
                        <label for="nama"class="col-md-3 col-md-offset-1 control-label" >Nama</label>
                        <div class="col-md-6">
                            <input type="text" name="nama" id="nama" onkeyup="user()" class="form-control" required autofocus><span class="help-block with-errors"></span>
                        </div>
                    </div> 
                    <div class="form-group row">
                      <label for="email"class="col-md-3 col-md-offset-1 control-label" >E-mail</label>
                      <div class="col-md-6">
                          <input type="text" name="email" id="email" onkeyup="user()" class="form-control" required ><span class="help-block with-errors"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="password"class="col-md-3 col-md-offset-1 control-label" >Password</label>
                      <div class="col-md-6">
                          <input type="password" name="password" id="password" class="form-control" required ><span class="help-block with-errors"></span>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="password_confirmation"class="col-md-3 col-md-offset-1 control-label" >Konfirmasi Password</label>
                      <div class="col-md-6">
                          <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required data-match="#password"><span class="help-block with-errors"></span>
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