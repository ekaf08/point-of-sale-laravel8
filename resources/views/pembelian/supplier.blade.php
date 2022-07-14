  <!-- Modal -->
  <div class="modal fade" id="modal-supplier" tabindex="-1" role="dialog" aria-labelledby="modal-supplier" >
    <div class="modal-dialog" role="document">
       
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"></h4>
                </div>
		<!--ISI MODAL-->
                <div class="modal-body">
                    <table class="table table-striped table-bordered table-supplier">
                        <thead class="header_table">
                            <th class="text-center" width="5%">NO</th>
                            <th class="text-center">NAMA</th>
                            <th class="text-center">TELEPON</th>
                            <th class="text-center">ALAMAT</th>
                            <th class="text-center" width="10%"><i class="fa fa-cog"></i></th>
                        </thead>
                        <tbody style="font-weight: normal;">
                            @foreach ($supplier as $key => $item)
                                <tr>
                                    <td width="5%">{{ $key+1 }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->telepon }}</td>
                                    <td>{{ $item->alamat }}</td>      
                                    <td>
                                        <a href="{{ route('pembelian.create', $item->id) }}" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-check-circle"></i> Pilih</a>
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

 