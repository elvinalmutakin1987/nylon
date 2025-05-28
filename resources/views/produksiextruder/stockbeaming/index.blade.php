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
                            <li class="breadcrumb-item"><a href="{{ route('produksi.index') }}"
                                    class="text-dark">Produksi</a>
                            </li>
                            <li class="breadcrumb-item" Active>Stock Beaming</li>
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
                                <h3 class="card-title">Mesin</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary" onclick="cetak()"><i
                                                class="fa fa-print"></i>
                                            Cetak</button>
                                        <button type="button" class="btn btn-success" onclick="export_()"><i
                                                class="fas fa-file-excel"></i>
                                            Export</button>
                                        <a type="button" class="btn btn-secondary m-1"
                                            href="{{ route('produksi.index') }}"><i class="fa fa-reply"></i> Kembali</a>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <select
                                            class="form-control select2 select-status @error('status') is-invalid @enderror"
                                            id="status" name="status">
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select
                                            class="form-control select2 select-posisi @error('posisi') is-invalid @enderror"
                                            id="posisi" name="posisi">
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="table1" class="table projects">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Beam Number</th>
                                                    <th>Tanggal</th>
                                                    <th>Posisi</th>
                                                    <th>Hasil Panen</th>
                                                    <th>Sisa</th>
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

        var ajax = '{{ url()->current() }}';

        var data = [{
                id: 'Semua',
                text: 'Semua'
            }, {
                id: 'Atas',
                text: 'Atas'
            },
            {
                id: 'Bawah',
                text: 'Bawah'
            }
        ];

        var data2 = [{
                id: 'Semua',
                text: 'Semua'
            }, {
                id: 'Aktif',
                text: 'Aktif'
            },
            {
                id: 'Tidak Aktif',
                text: 'Tidak Aktif'
            }
        ];

        $(document).ready(function() {
            get_data();

            $(".select-status").select2({
                placeholder: "-- Pilih Status --",
                allowClear: false,
                data: data2,
                minimumResultsForSearch: -1,
                width: '100%'
            });

            $(".select-posisi").select2({
                placeholder: "-- Pilih Posisi --",
                allowClear: false,
                data: data,
                minimumResultsForSearch: -1,
                width: '100%'
            });
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
                        data: 'beam_number',
                        name: 'beam_number',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'tanggal_panen',
                        name: 'tanggal_panen',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'posisi',
                        name: 'posisi',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'meter_hasil',
                        name: 'meter_hasil',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return numeral(data).format('0,0');
                        }
                    },
                    {
                        data: 'meter',
                        name: 'meter',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            var meter = numeral(row.meter).format('0');
                            var meter_hasil = numeral(row.meter_hasil).format('0');
                            var sisa = parseFloat(meter_hasil) - parseFloat(meter);
                            return numeral(sisa).format('0,0');
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            if (data == 'Tidak Aktif') {
                                return '<span class="badge bg-danger" style="font-size: 13px">' + data +
                                    '</span>';
                            } else if (data == 'Aktif') {
                                return '<span class="badge bg-success" style="font-size: 13px">' + data +
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

        function ubah_format(field, nilai) {
            var mynumeral = numeral(nilai).format('0,0');
            if (field.includes('jumlah')) {
                mynumeral = numeral(nilai).format('0,0.0');
            }
            $("#" + field).val(mynumeral);
        }

        $("#posisi").on('change', function(e) {
            ajax = '{{ url()->current() }}?posisi=' + $("#posisi").val() + '&status=' + $("#status").val();
            table1.DataTable().ajax.url(ajax).load();
        })

        $("#status").on('change', function(e) {
            ajax = '{{ url()->current() }}?posisi=' + $("#posisi").val() + '&status=' + $("#status").val();
            table1.DataTable().ajax.url(ajax).load();
        })

        function hapus(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5156be',
                cancelButtonColor: '#fd625e',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = `{!! route('produksiextruder.stockbeaming.destroy', ':_id') !!}`;
                    url = url.replace(':_id', id);
                    $("#_method").val('DELETE');
                    $('#form-delete').attr('action', url);
                    $('#form-delete').submit();
                }
            });
        }

        function cetak() {
            let posisi = $("#posisi").val();
            let status = $("#status").val();
            let url = `{!! route('produksiextruder.stockbeaming.cetak', ['posisi' => '_posisi', 'status' => '_status']) !!}`;
            url = url.replace('_posisi', posisi);
            url = url.replace('_status', status);
            window.open(url, '_blank');
        }

        function export_() {
            let posisi = $("#posisi").val();
            let status = $("#status").val();
            let url = `{!! route('produksiextruder.stockbeaming.export', ['posisi' => '_posisi', 'status' => '_status']) !!}`;
            url = url.replace('_posisi', posisi);
            url = url.replace('_status', status);
            window.open(url, '_blank');
        }
    </script>
@endsection
