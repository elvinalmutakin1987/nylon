@extends('partials.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-dark">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('gudang.index') }}" class="text-dark">Gudang</a>
                            </li>
                            <li class="breadcrumb-item">Avalan</li>
                            <li class="breadcrumb-item" Active>Retur</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Application buttons -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Retur</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <a type="button" class="btn btn-success m-1"
                                            href="{{ route('retur.create', ['gudang' => 'avalan']) }}"><i
                                                class="fa fa-plus"></i> Tambah
                                            Data</a>
                                        <a type="button" class="btn btn-secondary m-1"
                                            href="{{ route('gudang.index') }}"><i class="fa fa-reply"></i> Kembali</a>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-group date" id="div_tanggal_dari" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input"
                                                    data-target="#div_tanggal_dari" id="tanggal_dari" name="tanggal_dari"
                                                    value="{{ \Carbon\Carbon::now()->startOfMonth()->toDateString() }}" />
                                                <div class="input-group-append" data-target="#div_tanggal_dari"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-group date" id="div_tanggal_sampai"
                                                data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input"
                                                    data-target="#div_tanggal_sampai" id="tanggal_sampai"
                                                    name="tanggal_sampai"
                                                    value="{{ \Carbon\Carbon::now()->endOfMonth()->toDateString() }}" />
                                                <div class="input-group-append" data-target="#div_tanggal_sampai"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control select2 w-100 select-status" id="status"
                                            name="status">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="table1" class="table projects">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>No. Dokumen</th>
                                                    <th>Tanggal</th>
                                                    <th>No. Surat Jalan</th>
                                                    <th>No. Barang Keluar</th>
                                                    <th>Catatan</th>
                                                    <th>Status</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /. row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <form enctype="multipart/form-data" id="form-delete" method="POST">
        @csrf
        @method('DELETE')
    </form>
@endsection


@section('script')
    <script type="text/javascript">
        const table1 = $('#table1');

        var data = [{
                id: 'Draft',
                text: 'Draft'
            },
            {
                id: 'Submit',
                text: 'Submit'
            },
            {
                id: 'Approved',
                text: 'Approved'
            },
            {
                id: 'Rejected',
                text: 'Rejected'
            }
        ];

        var data2 = [{
                id: 'barang-jadi',
                text: 'Barang Jadi'
            },
            {
                id: 'bahan-baku',
                text: 'Bahan Baku'
            },
            {
                id: 'benang',
                text: 'Benang'
            },
            {
                id: 'extruder',
                text: 'Extruder'
            },
            {
                id: 'wjl',
                text: 'WJL'
            },
            {
                id: 'sulzer',
                text: 'Sulzer'
            },
            {
                id: 'rashel',
                text: 'Rashel'
            },
            {
                id: 'beaming',
                text: 'Beaming'
            },
            {
                id: 'packing',
                text: 'Packing'
            },
            {
                id: '-',
                text: 'Tidak ada info'
            }
        ];

        var ajax = '{{ url()->current() }}?tanggal_dari=' + $("#tanggal_dari").val() + '&tanggal_sampai=' + $(
            '#tanggal_sampai').val() + '&gudang={{ request()->get('gudang') }}' + '&status=' + $('#status').val();

        $(document).ready(function() {
            $('#div_tanggal_dari').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            $('#div_tanggal_sampai').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            $(".select-status").select2({
                placeholder: "-- Pilih Status --",
                allowClear: true,
                data: data,
                minimumResultsForSearch: -1,
                width: '100%'
            });

            $(".select-asal").select2({
                placeholder: "-- Pilih Asal --",
                allowClear: true,
                data: data2,
                minimumResultsForSearch: -1,
                width: '100%'
            });


            get_data();
        });

        function get_data() {
            table1.DataTable({
                "paging": true,
                "responsive": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "processing": true,
                "serverSide": true,
                "destroy": true,
                "ajax": ajax,
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: '35px',
                        className: 'dt-center',
                        targets: '_all'
                    },
                    {
                        data: 'no_dokumen',
                        name: 'no_dokumen',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'suratjalan',
                        name: 'suratjalan',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'barangkeluar',
                        name: 'barangkeluar',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'catatan',
                        name: 'catatan',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            if (data == 'Draft') {
                                return '<span class="badge bg-secondary" style="font-size: 13px">' + data +
                                    '</span>';
                            } else if (data == 'Submit') {
                                return '<span class="badge bg-primary" style="font-size: 13px">' + data +
                                    '</span>';
                            } else if (data == 'Approved') {
                                return '<span class="badge bg-success" style="font-size: 13px">' + data +
                                    '</span>';
                            } else if (data == 'Rejected') {
                                return '<span class="badge bg-danger" style="font-size: 13px">' + data +
                                    '</span>';
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '100px',
                        className: 'project-actions text-center',
                        targets: '_all'
                    }
                ],
            });
        }

        function hapus(id) {
            Swal.fire({
                title: 'Apakah anda yakin menghapus data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5156be',
                cancelButtonColor: '#fd625e',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = `{!! route('barangmasuk.destroy', ':_id') !!}`;
                    url = url.replace(':_id', id);
                    $("#_method").val('DELETE');
                    $('#form-delete').attr('action', url);
                    $('#form-delete').submit();
                }
            });
        }

        @if (Session::has('message'))
            let timerInterval;
            Swal.fire({
                title: "{{ Session::get('message') }}",
                type: "{{ Session::get('status') }}",
                timer: 2000,
                icon: "{{ Session::get('status') }}",
                didOpen: () => {
                    timerInterval = setInterval(() => {}, 100)
                },
                willClose: () => {

                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {

                }
            });
        @endif

        $('#modal-default').on('hidden.bs.modal', function() {
            $("#card-tabs").html('');
        });

        $("#tanggal_dari").on('blur', function(e) {
            ajax = '{{ url()->current() }}?tanggal_dari=' + $("#tanggal_dari").val() + '&tanggal_sampai=' + $(
                    '#tanggal_sampai').val() + '&gudang={{ request()->get('gudang') }}' + '&status=' + $('#status')
                .val();
            table1.DataTable().ajax.url(ajax).load();
        });

        $("#tanggal_sampai").on('blur', function(e) {
            ajax = '{{ url()->current() }}?tanggal_dari=' + $("#tanggal_dari").val() + '&tanggal_sampai=' + $(
                    '#tanggal_sampai').val() + '&gudang={{ request()->get('gudang') }}' + '&status=' + $('#status')
                .val();
            table1.DataTable().ajax.url(ajax).load();
        });

        $("#status").on('change', function(e) {
            ajax = '{{ url()->current() }}?tanggal_dari=' + $("#tanggal_dari").val() + '&tanggal_sampai=' + $(
                    '#tanggal_sampai').val() + '&gudang={{ request()->get('gudang') }}' + '&status=' + $('#status')
                .val();
            table1.DataTable().ajax.url(ajax).load();
        });
    </script>
@endsection
