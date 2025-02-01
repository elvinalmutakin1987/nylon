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
                            <li class="breadcrumb-item"><a href="{{ route('pengaturan.index') }}"
                                    class="text-dark">Pengaturan</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('peranpengguna.index') }}" class="text-dark">Peran
                                    Pengguna</a>
                            </li>
                            <li class="breadcrumb-item" Active>Tambah Data</li>
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
                        <form action="{{ route('peranpengguna.store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('post')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Peran Pengguna</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                id="nama" name="nama" value="{{ old('nama') }}">
                                            @error('nama')
                                                <span id="nama-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-5">
                                            <label>Hak Akses</label>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-check-label">Oder</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="wargabaru"
                                                            name="wargabaru" onclick="semua_menu_jadi_cek()">
                                                        <label class="form-check-label" for="wargabaru">Order</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-check-label">Pelayanan</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="agenda"
                                                            name="agenda" onclick="semua_menu_jadi_cek()">
                                                        <label class="form-check-label" for="agenda">Agenda &
                                                            Pengumuman</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="surat"
                                                            name="surat" onclick="semua_menu_jadi_cek()">
                                                        <label class="form-check-label" for="surat">Surat</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="kejadian"
                                                            name="kejadian" onclick="semua_menu_jadi_cek()">
                                                        <label class="form-check-label" for="kejadian">Kejadian</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-check-label">Keuangan</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="akun"
                                                            name="akun">
                                                        <label class="form-check-label" for="akun">Akun</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="kasmasuk"
                                                            name="kasmasuk">
                                                        <label class="form-check-label" for="kasmasuk">Kas Masuk</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="kaskeluar"
                                                            name="kaskeluar">
                                                        <label class="form-check-label" for="kaskeluar">Kas Keluar</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="laporankas"
                                                            name="laporankas">
                                                        <label class="form-check-label" for="laporankas">Laporan
                                                            Kas</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-check-label">Pengaturan</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="rt"
                                                            name="rt" onclick="semua_menu_jadi_cek()">
                                                        <label class="form-check-label" for="rt">Daftar RT</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="pengguna_"
                                                            name="pengguna_" onclick="semua_menu_jadi_cek()">
                                                        <label class="form-check-label" for="pengguna_">Pengguna</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="profil"
                                                            name="profil" onclick="semua_menu_jadi_cek()">
                                                        <label class="form-check-label" for="profil">Profil</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="templatesurat" name="templatesurat"
                                                            onclick="semua_menu_jadi_cek()">
                                                        <label class="form-check-label" for="templatesurat">Template
                                                            Surat</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="pengaturansistem" name="pengaturansistem"
                                                            onclick="semua_menu_jadi_cek()">
                                                        <label class="form-check-label" for="pengaturansistem">Pengaturan
                                                            Sistem</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default" href="{{ route('varian.index') }}"><i
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
@endsection


@section('script')
    <script type="text/javascript"></script>
@endsection
