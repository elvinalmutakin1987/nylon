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
                            <li class="breadcrumb-item"><a href="{{ route('gudang.index') }}" class="text-dark">Gudang</a>
                            </li>
                            <li class="breadcrumb-item">Packing</li>
                            <li class="breadcrumb-item">Retur</li>
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
                        <form action="{{ route('retur.update', $retur->slug) }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            @method('put')
                            <input type="hidden" id="gudang" name="gudang" value="{{ $gudang }}">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Retur</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="no_dokumen">No. Retur</label>
                                                <input type="text"
                                                    class="form-control @error('no_dokumen') is-invalid @enderror"
                                                    id="no_dokumen" name="no_dokumen" value="{{ $retur->no_dokumen }}"
                                                    readonly>
                                                @error('no_dokumen')
                                                    <span id="no_dokumen-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="dokumen">Dokumen</label>
                                                <select
                                                    class="form-control select2 w-100 select-dokumen @error('dokumen') is-invalid @enderror"
                                                    id="dokumen" name="dokumen">
                                                    @php
                                                        $referensi = '';
                                                        if ($retur->referensi == 'suratjalan') {
                                                            $referensi = 'Surat Jalan';
                                                        } elseif ($retur->referensi == 'barangkeluar') {
                                                            $referensi = 'Barang Keluar';
                                                        }
                                                    @endphp
                                                    <option value="{{ $retur->referensi }}">{{ $referensi }}</option>
                                                </select>
                                                @error('dokumen')
                                                    <span id="dokumen-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="dokumen_id">No. Dokumen</label>
                                                @php
                                                    $dokumen_id = '';
                                                    $dokumen = '';
                                                    if ($retur->referensi == 'suratjalan') {
                                                        $dokumen_id = $retur->suratjalan_id;
                                                        $dokumen = $retur->suratjalan->no_dokumen;
                                                    } elseif ($retur->referensi == 'barangkeluar') {
                                                        $dokumen_id = $retur->barangkeluar_id;
                                                        $dokumen = $retur->barangkeluar->no_dokumen;
                                                    }
                                                @endphp
                                                <select
                                                    class="form-control select2 w-100 select-get-dokumen @error('dokumen_id') is-invalid @enderror"
                                                    id="dokumen_id" name="dokumen_id">
                                                    <option value="{{ $dokumen_id }}">{{ $dokumen }}</option>
                                                </select>
                                                @error('dokumen_id')
                                                    <span id="dokumen_id-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal</label>
                                                <div class="input-group date" id="div_tanggal" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#div_tanggal" id="tanggal" name="tanggal"
                                                        value="{{ old('tanggal') ?? $retur->tanggal }}" />
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
                                                        @foreach ($retur->returdetail as $d)
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
                                                                        onblur="ubah_format('jumlah1', this.value)"
                                                                        value="{{ Number::format((float) $d->jumlah, precision: 1) }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        id="keterangan{{ $d->id }}"
                                                                        name="keterangan[]" value="{{ $d->keterangan }}">
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
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="catatan">Catatan</label>
                                                <textarea id="catatan" name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default"
                                        href="{{ route('retur.index', ['gudang' => $gudang]) }}"><i
                                            class="fa fa-reply"></i>
                                        Kembali</a>
                                    <button type="button" class="btn btn-success" data-toggle="dropdown"><i
                                            class="fa fa-save"></i>
                                        Simpan</button>
                                    <div class="dropdown-menu" role="menu">
                                        <button type="submit" class="dropdown-item" name="status" value="Draft"><i
                                                class="fa fa-file"></i> Sebagai Draft</button>
                                        <button type="submit" class="dropdown-item" name="status" value="Submit"><i
                                                class="fa fa-save"></i> Simpan Retur</button>
                                    </div>
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
@endsection


@section('script')
    <script type="text/javascript">
        var dokumen;

        var data2 = [{
                id: 'barangkeluar',
                text: 'Barang Keluar'
            },
            {
                id: 'suratjalan',
                text: 'Surat Jalan'
            }
        ];

        $(document).ready(function() {
            $('#div_tanggal').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            format_select2();
        });

        function format_select2() {
            $(".select-dokumen").select2({
                placeholder: "-- Pilih Dokumen --",
                allowClear: true,
                data: data2,
                minimumResultsForSearch: -1,
                width: '100%'
            });

            $('.select-get-dokumen').select2({
                placeholder: "- Pilih Barang Keluar -",
                allowClear: true,
                ajax: {
                    url: '{{ route('retur.get_dokumen') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                            dokumen: dokumen,
                            gudang: '{{ $gudang }}'
                        };
                    },
                    cache: true,
                }
            });

            $('.select-satuan').select2({
                width: '100%'
            });

            $('.select-barang').select2({
                placeholder: "- Pilih Barang -",
                allowClear: true,
                ajax: {
                    url: '{{ route('retur.get_material') }}',
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
                            name="keterangan[]">
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

        $(".select-dokumen").on('change', function(e) {
            $('.select-get-dokumen').val('').trigger('change');
            dokumen = $(".select-dokumen").val();
            $('.select-get-dokumen').select2({
                placeholder: "- Pilih No. Dokumen -",
                allowClear: true,
                ajax: {
                    url: '{{ route('retur.get_dokumen') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                            dokumen: dokumen,
                            gudang: '{{ $gudang }}'
                        };
                    },
                    cache: true,
                }
            });
        })
    </script>
@endsection
