@extends('layouts.master')

@section('title')
    Laporan Pendapatan {{ tanggal_indonesia($tanggalAwal) }} s/d {{ tanggal_indonesia($tanggalAkhir) }}
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('/AdminLTE-2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Laporan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-success btn-xs btn-flat" onclick="updatePeriode()"><i class="fa fa-stack-exchange"></i> Ubah Periode</button>
                <a href="{{ route('laporan.export_pdf',[$tanggalAwal, $tanggalAkhir]) }}" class="btn btn-info btn-xs btn-flat" target="_blank" ><i class="fa fa-print"></i> Cetak PDF</a>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead class="header_table">
                        <th class="text-center" width="5%">NO</th>
                        <th class="text-center" width="15%">TANGGAL</th>
                        <th class="text-center" width="45%">PENJUALAN</th>
                        <th class="text-center" width="20%">PEMBELIAN</th>
                        <th class="text-center" width="20%">PENGELUARAN</th>
                        <th class="text-center" width="20%">PENDAPATAN</th>
                    </thead>
                    <tbody style="font-weight: normal;">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('laporan.form')    
@endsection

@push('scripts')
<script src="{{ asset('/AdminLTE-2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('laporan.data', [$tanggalAwal, $tanggalAkhir]) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable:false, sortable:false},
                {data: 'tanggal'},
                {data: 'penjualan'},
                {data: 'pembelian'},
                {data: 'pengeluaran'},
                {data: 'pendapatan'},
            ],
            dom: 'Brt',
            bSort: false,
            bPaginate: false,
        });

        $('.datepicker').datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true
        });
    });

    function updatePeriode() {
        $('#modal-form').modal('show');
    }
    
    function batal(){
        location.reload();
    }
</script>


@endpush