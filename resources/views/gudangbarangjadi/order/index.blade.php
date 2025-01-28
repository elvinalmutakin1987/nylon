@php
    use App\Models\Orderdetail;
    use App\Models\Suratjalan;
    use App\Models\Suratjalandetail;
    use App\Models\User;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Number;
    use App\Models\Ordercatatan;
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
                            <li class="breadcrumb-item">Barang Jadi</li>
                            <li class="breadcrumb-item" Active>Order</li>
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
                                <h3 class="card-title">Order</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <a type="button" class="btn btn-secondary m-1"
                                            href="{{ route('gudang.index') }}"><i class="fa fa-reply"></i> Kembali</a>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body table-responsive p-0">
                                        <table id="table1" class="table">
                                            <thead>
                                                <tr>
                                                    <th width="50">#</th>
                                                    <th>No. Order</th>
                                                    <th>Pesanan</th>
                                                    <th>Pengiriman</th>
                                                    <th>Catatan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order as $d)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            <span
                                                                class="badge bg-{{ $d->status == 'Open' ? 'danger' : 'warning' }}"
                                                                style="font-size: 13px">
                                                                {{ $d->no_order }}
                                                            </span> <br>
                                                            {{ $d->nama_pemesan }}
                                                        </td>
                                                        <td>
                                                            @php
                                                                $orderdetail = Orderdetail::where(
                                                                    'order_id',
                                                                    $d->id,
                                                                )->get();
                                                            @endphp
                                                            <table class="table table-bordered w-100 table-sm">
                                                                <tr>
                                                                    <th>Barang</th>
                                                                    <th>Satuan</th>
                                                                    <th>Jumlah</th>
                                                                    <th>Terkirim</th>
                                                                </tr>
                                                                @foreach ($orderdetail as $d2)
                                                                    <tr>
                                                                        <td>{{ $d2->material->nama }}</td>
                                                                        <td>{{ $d2->satuan }}</td>
                                                                        <td>{{ Number::format((float) $d2->jumlah, precision: 1) }}
                                                                        </td>
                                                                        <td>
                                                                            @php
                                                                                $terkirim = 0;
                                                                                $terkirim = Suratjalandetail::leftJoin(
                                                                                    'suratjalans',
                                                                                    'suratjalans.id',
                                                                                    '=',
                                                                                    'suratjalandetails.suratjalan_id',
                                                                                )
                                                                                    ->where(
                                                                                        'suratjalans.order_id',
                                                                                        $d2->order_id,
                                                                                    )
                                                                                    ->where(
                                                                                        'suratjalandetails.material_id',
                                                                                        $d2->material_id,
                                                                                    )
                                                                                    ->sum('suratjalandetails.jumlah');
                                                                            @endphp
                                                                            {{ Number::format((float) $terkirim, precision: 1) }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <div class="row">
                                                                @php
                                                                    $suratjalan = Suratjalan::where(
                                                                        'order_id',
                                                                        $d->id,
                                                                    )->get();
                                                                @endphp
                                                                <table class="table table-bordered w-100 table-sm">
                                                                    <tr>
                                                                        <th>No. SJ</th>
                                                                        <th>Barang</th>
                                                                        <th>Satuan</th>
                                                                        <th>Jumlah</th>
                                                                    </tr>
                                                                    @foreach ($suratjalan as $d4)
                                                                        @php
                                                                            $suratjalandetail = Suratjalandetail::where(
                                                                                'suratjalan_id',
                                                                                $d4->id,
                                                                            )->get();
                                                                        @endphp
                                                                        @foreach ($suratjalandetail as $d5)
                                                                            <tr>
                                                                                <td><a href="{{ route('suratjalan.show', $d4->slug) }}"
                                                                                        target="_blank">{{ $d4->no_dokumen }}</a>
                                                                                </td>
                                                                                <td>{{ $d5->material->nama }}</td>
                                                                                <td>{{ $d5->satuan }}</td>
                                                                                <td>{{ Number::format((float) $d5->jumlah, precision: 1) }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                            @if (auth()->user()->can('gudang.barangjadi.suratjalan'))
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <a type="button" class="btn btn-success m-1"
                                                                            href="{{ route('suratjalan.create', ['order' => $d->slug]) }}"><i
                                                                                class="fa fa-truck"></i> Buat SJ</a>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div id="list-progress{{ $d->id }}">
                                                                @include(
                                                                    'gudangbarangjadi.order.list-progress',
                                                                    [
                                                                        'order_id' => $d->id,
                                                                    ]
                                                                )
                                                                <!-- Timelime example  -->
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <button type="button" class="btn btn-primary m-1"
                                                                        data-toggle="modal" data-target="#modal-import"
                                                                        onclick="pilih('{{ $d->slug }}', '{{ $d->id }}')"><i
                                                                            class="fa fa-plus"></i>
                                                                        Catatan</button>
                                                                </div>
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
                        <button type="button" class="btn btn-success" id="modal-button-simpan"><i class="fa fa-save"></i>
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
        var url = "";
        var list_progress = '';

        function pilih(slug, id) {
            url = "{{ route('gudangbarangjadiorder.progress', 'slug') }}";
            url = url.replace('slug', slug);
            list_progress = "#list-progress" + id;
        }

        $("#modal-button-simpan").on('click', function() {
            $.post(url, $("#form-import").serialize(), function(data) {
                if (data.status == 'success') {
                    $('#modal-import').modal('hide');
                    $(list_progress).html(`
                    <div class="d-flex justify-content-center m-2">
                       <button class="btn btn-primary" type="button" disabled>
                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        Loading...
                        </button>
                    </div>
                `);
                    $("#catatan").val('');
                    setTimeout(() => {
                        $(list_progress).html(data.data);
                    }, 500);
                }
            });
        })
    </script>
@endsection
