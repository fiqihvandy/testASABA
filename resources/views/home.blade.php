@extends('layout')

@section('content')
<div class="container">
    <div class="container-fluid mt-3">
        <p style="font-weight: 600;">PT. Jawa Food Sejahtera</p>

        <div class="card mt-4 shadow" style="border: 0; border-radius: 10px;">
            <div class="card-body" style="text-align: justify;">
                Aplikasi simulasi produksi makanan "Snaki" adalah sebuah solusi interaktif untuk membantu pengguna memperoleh hasil produksi yang maksimal. Aplikasi ini menyediakan kemampuan untuk mengubah jumlah kebutuhan bahan baku dan harga bahan baku, sehingga pengguna dapat mengeksplorasi skenario produksi yang berbeda untuk mendapatkan hasil optimal.
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <div class="card shadow my-1">
                    <div class="card-header">
                        Daftar bahan baku
                        <button class="btn btn-sm btn-success float-end" onclick="openMdl('bahan')"><i class="fas fa-plus mr-1"></i> Tambah Bahan</button>
                    </div>
                    <div class="card-body">
                        @if ($bahan->isNotEmpty())
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Bahan</td>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Harga (Rp)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bahan as $bh)
                                <tr>
                                    <td>{{$bh->nm_bahan}}</td>
                                    <td class="text-end">{{$bh->jumlah}}</td>
                                    <td>{{$bh->satuanRelasi->nm_satuan}}</td>
                                    <td class="text-end">{{number_format($bh->harga, 0, ',', '.')}}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary" onclick="openEdtMdl('{{$bh->id_bahan}}', 'bahan')"><i class="fas fa-pen"></i></button>
                                        <button class="btn btn-sm btn-danger" onclick="openDelMdl('{{$bh->id_bahan}}', 'bahan')"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p>Data kosong lakukan tambah bahan terlebih dahulu!</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow my-1">
                    <div class="card-header">
                        Bahan baku yang digunakan
                        <button class="btn btn-sm btn-success float-end" onclick="openMdl('produk')"><i class="fas fa-plus mr-1"></i> Tambah Bahan</button>
                    </div>
                    <div class="card-body">
                        @if ($produk->isNotEmpty())
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Bahan</td>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Harga (Rp)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $total = 0;
                                @endphp
                                @foreach ($produk as $pr)
                                <tr>
                                    <td>{{$pr->bahan->nm_bahan}}</td>
                                    <td class="text-end">{{$pr->jumlah}}</td>
                                    <td>{{$pr->satuanRelasi->eceran}}</td>
                                    <td class="text-end">
                                        @php
                                        $hargaper = ($pr->bahan->harga / ($pr->bahan->jumlah * $pr->satuanRelasi->jumlah)) * $pr->jumlah;
                                        $total += $hargaper;
                                        @endphp
                                        {{number_format($hargaper, 0, ',', '.')}}
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary" onclick="openEdtMdl('{{$pr->id_produk}}', 'produk')"><i class="fas fa-pen"></i></button>
                                        <button class="btn btn-sm btn-danger" onclick="openDelMdl('{{$pr->id_produk}}', 'produk')"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p>Data kosong lakukan tambah bahan terlebih dahulu!</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3 shadow" style="border: 0; border-radius: 10px;">
            <div class="card-body">
                Biaya produksi untuk setiap kemasan "Snaki" adalah :
                <b class="float-end" style="font-size: 1.5em;">Rp {{number_format((isset($total) ? $total : 0), 0, ',', '.')}}</b>
            </div>
        </div>
    </div>
</div>

<!-- Modal ADD -->
<div class="modal fade" id="addBahan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="titleAddBahan"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('home.store')}}" method="post">
                @csrf
                <input type="hidden" id="tipe" name="tipe">
                <div class="modal-body">
                    <div class="form-group mb-2" id="inpBahan">
                        <label>Nama Bahan</label>
                        <input type="text" class="form-control" id="nm_bahan" name="nm_bahan">
                    </div>
                    <div class="form-group mb-2" id="inpSelect">
                        <label>Nama Bahan</label>
                        <select class="form-select" id="nm_bahans" name="nm_bahans">
                            <option selected>--PILIH BAHAN--</option>
                            @foreach ($bahan as $bh)
                            <option value="{{$bh->id_bahan}}">{{$bh->nm_bahan}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Jumlah Bahan</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="jumlah" name="jumlah">
                            <span class="input-group-text" id="spnSatuan">kg</span>
                        </div>
                    </div>
                    <div class="form-group mb-2" id="inpHarga">
                        <label>Harga</label>
                        <input type="number" min="1" class="form-control" id="harga" name="harga">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal EDIT -->
<div class="modal fade" id="edtBahan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="titleEdtBahan"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="">
                @method('PUT')
                @csrf
                <input type="hidden" id="edttipe" name="edttipe">
                <div class="modal-body">
                    <div class="form-group mb-2" id="edtinpBahan">
                        <label>Nama Bahan</label>
                        <input type="text" class="form-control" id="edtnm_bahan" name="edtnm_bahan">
                    </div>
                    <div class="form-group mb-2" id="edtinpSelect">
                        <label>Nama Bahan</label>
                        <select class="form-select" id="edtnm_bahans" name="edtnm_bahan">
                            <option selected>--PILIH BAHAN--</option>
                            @foreach ($bahan as $bh)
                            <option value="{{$bh->id_bahan}}">{{$bh->nm_bahan}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Jumlah Bahan</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="edtjumlah" name="edtjumlah">
                            <span class="input-group-text" id="edtspnSatuan">kg</span>
                        </div>
                    </div>
                    <div class="form-group mb-2" id="edtinpHarga">
                        <label>Harga</label>
                        <input type="number" min="1" class="form-control" id="edtharga" name="edtharga">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnEdtSubmit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal DELETE -->
<div class="modal fade" id="delBahan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="titleEdtBahan"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="">
                @method('DELETE')
                @csrf
                <input type="hidden" id="delid_bahan" name="delid_bahan">
                <div class="modal-body">
                    <p>Apakah anda yakin menghapus data :</p>
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nama</td>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Harga (Rp)</th>
                            </tr>
                        </thead>
                        <tbody id="tbDelMdl">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnDelSubmit" class="btn btn-danger"><i class="fas fa-check"></i> Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
    let addModal = new bootstrap.Modal(document.getElementById('addBahan'), {})
    let edtModal = new bootstrap.Modal(document.getElementById('edtBahan'), {})
    let delModal = new bootstrap.Modal(document.getElementById('delBahan'), {})

    function openMdl(tipe) {
        addModal.show()
        $('#tipe').val(tipe)
        if (tipe === 'bahan') {
            $('#titleAddBahan').text('Tambah Bahan Baku')
            $('#inpHarga').removeClass('d-none')
            $('#inpBahan').removeClass('d-none')
            $('#inpSelect').addClass('d-none')
            $('#spnSatuan').text('kg')
        } else {
            $('#titleAddBahan').text('Tambah Bahan Produk')
            $('#inpHarga').addClass('d-none')
            $('#inpBahan').addClass('d-none')
            $('#inpSelect').removeClass('d-none')
            $('#spnSatuan').text('gram')
        }
    }

    function openEdtMdl(id, tipe) {
        var url = '{{ route("home.show", ":id") }}'
        url = url.replace(':id', id)
        var urledt = '{{ route("home.update", ":id") }}'
        urledt = urledt.replace(':id', id)
        $('#edttipe').val(tipe)
        if (tipe === 'bahan') {
            $('#titleEdtBahan').text('Edit Bahan Baku')
            $('#edtinpHarga').removeClass('d-none')
            $('#edtinpBahan').removeClass('d-none')
            $('#edtinpSelect').addClass('d-none')
        } else {
            $('#titleEdtBahan').text('Edit Bahan Produk')
            $('#edtinpHarga').addClass('d-none')
            $('#edtinpBahan').addClass('d-none')
            $('#edtinpSelect').removeClass('d-none')
        }
        $.ajax({
            type: 'GET',
            url: url,
            data: {
                _token: CSRF_TOKEN,
                'tipe': tipe,
            },
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    $('[name="edtnm_bahan"]').val(result.data.nm_bahan)
                    $('#edtjumlah').val(result.data.jumlah)
                    $('#edtharga').val(result.data.harga)
                    $('#edtspnSatuan').text((tipe === 'bahan' ? result.data.satuan_relasi.nm_satuan : result.data.satuan_relasi.eceran))
                    edtModal.show()
                }
            }
        })

        $('#btnEdtSubmit').on('click', function() {
            if (tipe === 'bahan') {
                var edtnm_bahan = $('#edtnm_bahan').val()
            } else {
                var edtnm_bahan = $('#edtnm_bahans').val()
            }
            var edtjumlah = $('#edtjumlah').val()
            var edtharga = $('#edtharga').val()
            $.ajax({
                type: 'PUT',
                url: url,
                data: {
                    _token: CSRF_TOKEN,
                    'tipe': tipe,
                    'edtnm_bahan': edtnm_bahan,
                    'edtjumlah': edtjumlah,
                    'edtharga': edtharga,
                },
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        location.reload()
                    }
                }
            })
        })
    }

    function openDelMdl(id, tipe) {
        var url = '{{ route("home.show", ":id") }}'
        url = url.replace(':id', id)
        var urldel = '{{ route("home.destroy", ":id") }}'
        urldel = urldel.replace(':id', id)
        $('#delid_bahan').val(id)

        $.ajax({
            type: 'GET',
            url: url,
            data: {
                _token: CSRF_TOKEN,
                'tipe': tipe,
            },
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    $('#tbDelMdl').empty()
                    $('#tbDelMdl').append('<tr><td>' + result.data.nm_bahan + '</td><td class="text-end">' + result.data.jumlah + '</td><td>' + (tipe === 'bahan' ? result.data.satuan_relasi.nm_satuan : result.data.satuan_relasi.eceran) + '</td><td class="text-end">' + result.data.harga + '</td></tr>')
                    delModal.show()
                }
            }
        })

        $('#btnDelSubmit').on('click', function() {
            $.ajax({
                type: 'DELETE',
                url: urldel,
                data: {
                    _token: CSRF_TOKEN,
                    'tipe': tipe,
                },
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        location.reload()
                    }
                }
            })
        })
    }
</script>
@endsection