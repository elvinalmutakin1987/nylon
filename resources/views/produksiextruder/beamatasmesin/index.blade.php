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
                            <li class="breadcrumb-item" Active>Beam Atas Mesin</li>
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
                                <h3 class="card-title">Beam Atas Mesin</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <a type="button" class="btn btn-success m-1"
                                            href="{{ route('produksiextruder.beamatasmesin.create') }}"><i
                                                class="fa fa-plus"></i> Tambah
                                            Data</a>
                                        <button type="button" class="btn btn-primary m-1" onclick="cetak()"><i
                                                class="fa fa-print"></i>
                                            Cetak</button>
                                        <button type="button" class="btn btn-info m-1" onclick="export_()"><i
                                                class="fas fa-file-excel"></i>
                                            Export</button>
                                        <a type="button" class="btn btn-secondary m-1"
                                            href="{{ route('produksi.index') }}"><i class="fa fa-reply"></i> Kembali</a>
                                    </div>
                                </div>
                                <div class="card ">
                                    <div class="card-body table-responsive">
                                        <table id="table1" class="table projects">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Tanggal</th>
                                                    <th>Beam Nomor</th>
                                                    <th>Jenis Produksi</th>
                                                    <th>Rajutan Lusi</th>
                                                    <th>Lebar Kain</th>
                                                    <th>Jumlah Benang</th>
                                                    <th>Denier</th>
                                                    <th>Beam Isi</th>
                                                    <th>Beam Sisa</th>
                                                    <th>Berat (Kg)</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($beamatasmesin as $d)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $d->tanggal }}</td>
                                                        <td>{{ $d->beam_number }}</td>
                                                        <td>{{ $d->jenis_produksi }}</td>
                                                        <td>{{ $d->rajutan_lusi }}</td>
                                                        <td>{{ $d->lebar_kain }}</td>
                                                        <td>{{ Illuminate\Support\Number::format($d->jumlah_benang) }}
                                                        </td>
                                                        <td>{{ $d->denier }}</td>
                                                        <td>{{ $d->beam_isi }}</td>
                                                        <td>{{ Illuminate\Support\Number::format($d->beam_sisa) }}
                                                        </td>
                                                        <td>{{ $d->berat }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-info"
                                                                data-toggle="dropdown"><i
                                                                    class="fa fa-wrench"></i>Aksi</button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('produksiextruder.beamatasmesin.edit', $d->slug) }}")">
                                                                    <i class="fas fa-pencil-alt"></i> Edit</a>
                                                                <button class="dropdown-item"
                                                                    onClick="hapus('{{ $d->slug }}')"><i
                                                                        class="fas fa-trash"></i> Hapus</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
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
                    let url = `{!! route('produksiextruder.beamatasmesin.destroy', ':_id') !!}`;
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

        function cetak() {
            var url = "{!! route('produksiextruder.beamatasmesin.cetak') !!}";
            window.open(url, '_blank');
        }

        function export_() {
            var url = "{!! route('produksiextruder.beamatasmesin.export') !!}";
            window.open(url, '_blank');
        }
    </script>
@endsection
