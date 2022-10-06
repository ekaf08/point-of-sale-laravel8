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
                        <label for="nama_produk"class="col-md-2 col-md-offset-1 control-label" >Nama</label>
                        <div class="col-md-6">
                            <input type="text" name="nama_produk" id="nama_produk" onkeyup="kapital()" class="form-control" required autofocus><span class="help-block with-errors"></span>
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="id_kategori"class="col-md-2 col-md-offset-1 control-label" >Kategori</label>
                        <div class="col-md-6">
                            <select name="id_kategori" class="form-control" id="id_kategori" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="merk"class="col-md-2 col-md-offset-1 control-label" >Merk</label>
                        <div class="col-md-6">
                            <input type="text" name="merk" id="merk" onkeyup="kapital()" class="form-control" required ><span class="help-block with-errors"></span>
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="harga_beli"class="col-md-2 col-md-offset-1 control-label" >Harga Beli</label>
                        <div class="col-md-6">
                            <input type="text" name="harga_beli" id="harga_beli" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control"
                            data-inputmask="'alias': 'numeric','prefix': 'Rp ','digits': 2,'groupSeparator': ',','removeMaskOnSubmit': true,'autoUnmask':true"
                             required ><span class="help-block with-errors"></span>
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="harga_jual"class="col-md-2 col-md-offset-1 control-label" >Harga Jual</label>
                        <div class="col-md-6">
                            <input type="text" name="harga_jual" id="harga_jual" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control"
                            data-inputmask="'alias': 'numeric','prefix': 'Rp ','digits': 2,'groupSeparator': ',','removeMaskOnSubmit': true,'autoUnmask':true"
                             required><span class="help-block with-errors"></span>
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="diskon"class="col-md-2 col-md-offset-1 control-label" >Diskon</label>
                        <div class="col-md-6">
                            <input type="text" name="diskon" id="diskon" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control" required ><span class="help-block with-errors"></span>
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="stok"class="col-md-2 col-md-offset-1 control-label" >Stok</label>
                        <div class="col-md-6">
                            <input type="text" name="stok" id="stok" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control"
                            data-inputmask="'alias': 'numeric','digits': 2,'groupSeparator': ',','removeMaskOnSubmit': true,'autoUnmask':true"
                            required ><span class="help-block with-errors"></span>
                            {{-- <input type="text" name="kode_produk" id="kode_produk" class="form-control" required hidden><span class="help-block with-errors"></span> --}}
                        </div>
                    </div> 


                </div>
                <div class="modal-footer">
                    <div class="col-md-9">
                  <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                  <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
                </div>
              </div>
        </form>
    </div>
  </div>