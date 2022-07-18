  <!-- Modal -->
  <div class="modal fade" id="modal-produk" tabindex="-1" role="dialog" aria-labelledby="modal-produk" >
    <div class="modal-dialog modal-lg" style="width: 80%" role="document">
       
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><strong> - Pilih Produk</strong></h4>
                </div>
		<!--ISI MODAL-->
                <div class="modal-body">
                    <table class="table table-striped table-bordered table-produk">
                        <thead class="header_table">
                            <th class="text-center" width="5%">NO</th>
                            <th class="text-center">KODE</th>
                            <th class="text-center">NAMA</th>
                            <th class="text-center">HARGA BELI</th>
                            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody style="font-weight: normal;">
                            @foreach ($produk as $key => $item)
                                <tr>
                                    <td width="5%">{{ $key+1 }}</td>
                                    <td><span class="label label-success">{{ $item->kode_produk }}</span></td>
                                    <td>{{ $item->nama_produk }}</td>
                                    <td>{{ $item->harga_beli }}</td>      
                                    <td>
                                        <a href="#" class="btn btn-primary btn-xs btn-flat" onclick="pilihProduk('{{ $item->id }}', '{{ $item->kode_produk }}')"><i class="fa fa-check-circle"></i> Pilih</a>
                                    </td>
                                </tr>                          
                            @endforeach
                        </tbody>
                    </table>
			          </div>
        <!--END MODAL-->
                {{-- <div class="modal-footer">
                  <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                  <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div> --}}
              </div>
       
    </div>
  </div>

 