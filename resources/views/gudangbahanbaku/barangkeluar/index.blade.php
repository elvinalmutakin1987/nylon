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
                            <li class="breadcrumb-item">Gudang Bahan Baku</li>
                            <li class="breadcrumb-item" Active>Barang Keluar</li>
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
                                <h3 class="card-title">Gudang Bahan Baku - Barang Keluar</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <a type="button" class="btn btn-success m-1"
                                            href="{{ route('barangkeluar.create', ['gudang' => 'bahan-baku']) }}"><i
                                                class="fa fa-plus"></i>
                                            Tambah
                                            Data</a>
                                        <a type="button" class="btn btn-secondary m-1"
                                            href="{{ route('gudang.index') }}"><i class="fa fa-reply"></i> Kembali</a>
                                    </div>
                                </div>

                                <div class="card ">
                                    <div class="card-body">
                                        <table id="table1" class="table projects">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>No. Dokumen</th>
                                                    <th>Referensi</th>
                                                    <th>Tanggal</th>
                                                    <th>Dibuat Oleh</th>
                                                    <th>Disetujui Oleh</th>
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

        $(document).ready(function() {
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
                "ajax": '{{ url()->current() }}',
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
                        data: 'referensi',
                        name: 'referensi',
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
                        data: 'dibuat_oleh',
                        name: 'dibuat_oleh',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'disetujui_oleh',
                        name: 'disetujui_oleh',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: true,
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
                    let url = `{!! route('barangkeluar.destroy', ':_id') !!}`;
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
    </script>
@endsection
