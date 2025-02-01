@php
    use Illuminate\Support\Number;
@endphp

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
                            <li class="breadcrumb-item"><a href="{{ route('order.index') }}" class="text-dark">Order</a>
                            </li>
                            <li class="breadcrumb-item" Active>Edit Data</li>
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
                        <form action="{{ route('order.update', $order->slug) }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            @method('put')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Order</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_order">No. Order</label>
                                                <input type="text"
                                                    class="form-control @error('no_order') is-invalid @enderror"
                                                    id="no_order" name="no_order"
                                                    value="{{ old('no_order') ?? $order->no_order }}">
                                                @error('no_order')
                                                    <span id="no_order-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nama_pemesan">Nama Pemesan</label>
                                                <input type="text"
                                                    class="form-control @error('nama_pemesan') is-invalid @enderror"
                                                    id="nama_pemesan" name="nama_pemesan"
                                                    value="{{ old('nama_pemesan') ?? $order->nama_pemesan }}">
                                                @error('nama_pemesan')
                                                    <span id="nama_pemesan-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal Order</label>
                                                <div class="input-group date" id="div_tanggal" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#div_tanggal" id="tanggal" name="tanggal"
                                                        value="{{ old('tanggal') ?? $order->tanggal }}" />
                                                    <div class="input-group-append" data-target="#div_tanggal"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('tanggal')
                                                    <span id="nama-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Jenis Barang</label>
                                                <textarea id="jenis_barang" name="jenis_barang" class="form-control @error('jenis_barang') is-invalid @enderror"
                                                    rows="7">{!! $order->jenis_barang !!}</textarea>
                                            </div>
                                            @error('jenis_barang')
                                                <span id="no_order-error"
                                                    class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive p-0">
                                                <table id="table1" class="table border table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 40%">Barang</th>
                                                            <th style="width: 10%">Satuan</th>
                                                            <th style="width: 15%">Jumlah</th>
                                                            <th>Keterangan</th>
                                                            <th style="width: 50px" class="text-center"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($order->orderdetail as $d)
                                                            <tr>
                                                                <td>
                                                                    <select class="form-control select2 w-100 select-barang"
                                                                        id="material_id{{ $d->id }}"
                                                                        name="material_id[]">
                                                                        <option value="{{ $d->material_id }}">
                                                                            {{ $d->material->nama }}</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control select2 w-100 select-satuan"
                                                                        id="satuan{{ $d->id }}" name="satuan[]">
                                                                        @foreach ($satuan as $s)
                                                                            <option value="{{ $s->nama }}"
                                                                                {{ $d->satuan == $s->nama ? 'selected' : '' }}>
                                                                                {{ $s->nama }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        id="jumlah{{ $d->id }}" name="jumlah[]"
                                                                        onblur="ubah_format('jumlah{{ $d->id }}', this.value)"
                                                                        value="{{ Number::format($d->jumlah, precision: 1) }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        id="keterangan{{ $d->id }}"
                                                                        name="keterangan_[]">
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-danger"
                                                                        id="hapus"><i class="fa fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td class="text-right text-bold" colspan="4"></td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary"
                                                                    onclick="tambah()"><i class="fa fa-plus"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="keterangan">Keterangan</label>
                                                <input type="text"
                                                    class="form-control @error('keterangan') is-invalid @enderror"
                                                    id="keterangan" name="keterangan"
                                                    value="{{ old('keterangan') ?? $order->keterangan }}">
                                                @error('keterangan')
                                                    <span id="keterangan-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tanggal_kirim">Tanggal Kirim</label>
                                                <div class="input-group date" id="div_tanggal_kirim"
                                                    data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#div_tanggal_kirim" id="tanggal_kirim"
                                                        name="tanggal_kirim"
                                                        value="{{ old('tanggal_kirim') ?? $order->tanggal_kirim }}" />
                                                    <div class="input-group-append" data-target="#div_tanggal_kirim"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('tanggal_kirim')
                                                    <span id="nama-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="kode">Kode</label>
                                                <input type="text"
                                                    class="form-control @error('kode') is-invalid @enderror"
                                                    id="kode" name="kode"
                                                    value="{{ old('kode') ?? $order->kode }}">
                                                @error('kode')
                                                    <span id="kode-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select
                                                    class="form-control select2 w-100 select-lokasi @error('status') is-invalid @enderror"
                                                    id="status" name="status">
                                                    <option value="Open"
                                                        {{ $order->status == 'Open' ? 'selected' : '' }}>Open</option>
                                                    <option value="On Progress"
                                                        {{ $order->status == 'On Progress' ? 'selected' : '' }}>On
                                                        Progress</option>
                                                    <option value="Done"
                                                        {{ $order->status == 'Done' ? 'selected' : '' }}>Done</option>
                                                </select>
                                                @error('status')
                                                    <span id="status-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="">Catatan</label>
                                            <div id="list-progress">
                                                @include('order.list-progress', ['order' => $order])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#modal-import"><i class="fa fa-plus"></i>
                                                Tambah Catatan</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="">Histori</label>
                                            <table class="w-100">
                                                @foreach ($histori as $d)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d/M/Y h:i:s') }}
                                                            - {{ $d->keterangan }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default" href="{{ route('order.index') }}"><i
                                            class="fa fa-reply"></i>
                                        Kembali</a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                        Simpan</button>
                                </div>
                            </div>
                            <!-- /.card -->
                        </form>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /. row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <form enctype="multipart/form-data" id="form-import">
        <div class="modal fade" id="modal-import">
            <div class="modal-dialog">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Catatan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <textarea id="catatan" name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-reply"></i>
                            Kembali</button>
                        <button type="button" class="btn btn-success" id="modal-button-simpan"><i
                                class="fa fa-save"></i>
                            Simpan</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>
    <!-- /.modal -->
@endsection


@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#div_tanggal').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            $('#status').select2();

            format_select2();
        });

        function format_select2() {

            $('.select-satuan').select2({
                width: '100%'
            });

            $('.select-barang').select2({
                placeholder: "- Pilih Barang -",
                allowClear: true,
                ajax: {
                    url: '{{ route('order.get_material') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        };
                    },
                    cache: true,
                },
                width: '100%'
            });
        }

        $("#modal-button-simpan").on('click', function() {
            $.post("{{ route('order.progress', $order->slug) }}", $("#form-import").serialize(), function(data) {
                if (data.status == 'success') {
                    $('#modal-import').modal('hide');
                    $("#list-progress").html(`
                        <div class="d-flex justify-content-center m-2">
                           <button class="btn btn-primary" type="button" disabled>
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                            Loading...
                            </button>
                        </div>
                    `);
                    $("#catatan").val('');
                    setTimeout(() => {
                        $("#list-progress").html(data.data);
                    }, 500);
                }
            });
        });

        function ubah_format(field, nilai) {
            var mynumeral = numeral(nilai).format('0,0');
            if (field.includes('jumlah')) {
                mynumeral = numeral(nilai).format('0,0.0');
            }
            $("#" + field).val(mynumeral);
        }

        function tambah() {
            var tbody_row = $('#table1').find('tr').length;
            var row_id = Date.now().toString(36) + Math.random().toString(36).substr(2);
            $("#table1 > tbody > tr:last").before(`
                <tr>
                    <td>
                        <select class="form-control select2 w-100 select-barang"
                            id="mamterial_id${row_id}" name="material_id[]">
                        </select>
                    </td>
                    <td>
                        <select class="form-control select2 w-100 select-satuan"
                            id="satuan${row_id}" name="satuan[]">
                            @foreach ($satuan as $d)
                                <option value="{{ $d->nama }}">{{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" id="jumlah${row_id}"
                            name="jumlah[]" onblur="ubah_format('jumlah${row_id}', this.value)">
                    </td>
                    <td>
                        <input type="text" class="form-control" id="keterangan${row_id}"
                            name="keterangan_[]">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger" id="hapus"><i
                                class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);

            format_select2();
        }

        $("#table1").on("click", "#hapus", function() {
            $(this).closest("tr").remove();
        });
    </script>
@endsection
