  <!-- Modal -->
  <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-detail">
    <div class="modal-dialog"  role="document">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Detail Produk</h4>
        </div>
        <!--ISI MODAL-->
        <div class="modal-body">
          <table class="table table-striped table-bordered table-detail">
            <thead class="header_table">
              <th class="text-center" width="5%">NO</th>
              <th class="text-center">KODE</th>
              <th class="text-center">NAMA</th>
              <th class="text-center">HARGA</th>
              <th class="text-center">JUMLAH</th>
              <th class="text-center">SUB TOTAL</th>
              {{-- <th class="text-center" width="10%"><i class="fa fa-cog"></i></th> --}}
            </thead>
            <tbody style="font-weight: normal;">
             
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