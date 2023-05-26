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

        <div id="isiKonten">
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
                                        <th>Harga</th>
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
                                            <button class="btn btn-sm my-1 btn-primary" onclick="openEdtMdl('{{$bh->id_bahan}}', 'bahan')"><i class="fas fa-pen"></i></button>
                                            <button class="btn btn-sm my-1 btn-danger" onclick="openDelMdl('{{$bh->id_bahan}}', 'bahan')"><i class="fas fa-trash"></i></button>
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
                                        <th>Harga</th>
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
                                            <button class="btn btn-sm my-1 btn-primary" onclick="openEdtMdl('{{$pr->id_produk}}', 'produk')"><i class="fas fa-pen"></i></button>
                                            <button class="btn btn-sm my-1 btn-danger" onclick="openDelMdl('{{$pr->id_produk}}', 'produk')"><i class="fas fa-trash"></i></button>
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

            <div class="card mt-3 mb-4 shadow" style="border: 0; border-radius: 10px;">
                <div class="card-body">
                    Biaya produksi untuk setiap kemasan "Snaki" adalah :
                    <b class="float-end" style="font-size: 1.5em;">Rp {{number_format((isset($total) ? $total : 0), 0, ',', '.')}}</b>
                </div>
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
            <form action="" method="post">
                @csrf
                <input type="hidden" id="tipe" name="tipe">
                <div class="modal-body">
                    <div class="form-group mb-2" id="inpBahan">
                        <label>Nama Bahan</label>
                        <input type="text" class="form-control n-val" id="nm_bahan" name="nm_bahan">
                        <div class="invalid-feedback" id="msgnm_bahan"></div>
                    </div>
                    <div id="inpSelect">
                    </div>
                    <div class="form-group mb-2">
                        <label>Jumlah Bahan</label>
                        <input type="number" class="form-control n-val" id="jumlah" name="jumlah">
                        <div class="invalid-feedback" id="msgjumlah"></div>
                    </div>
                    <div class="form-group mb-2">
                        <label>Satuan</label>
                        <select class="form-select n-val" id="satuan" name="satuan">
                        </select>
                        <div class="invalid-feedback" id="msgsatuan"></div>
                    </div>
                    <div class="form-group mb-2" id="inpHarga">
                        <label>Harga</label>
                        <input type="number" class="form-control n-val" id="harga" name="harga">
                        <div class="invalid-feedback" id="msgharga"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnAddSubmit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Simpan</button>
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
                        <input type="text" class="form-control n-val" id="edtnm_bahan" name="edtnm_bahan">
                        <div class="invalid-feedback" id="msgedtnm_bahan"></div>
                    </div>
                    <div class="form-group mb-2" id="edtinpSelect">
                        <label>Nama Bahan</label>
                        <select class="form-select n-val" id="edtnm_bahans" name="edtnm_bahan">
                        </select>
                        <div class="invalid-feedback" id="msgedtnm_bahans"></div>
                    </div>
                    <div class="form-group mb-2">
                        <label>Jumlah Bahan</label>
                        <div class="input-group">
                            <input type="number" class="form-control n-val" id="edtjumlah" name="edtjumlah">
                            <div class="invalid-feedback" id="msgedtjumlah"></div>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label>Satuan</label>
                        <select class="form-select n-val n-val" id="edtsatuan" name="edtsatuan">
                        </select>
                        <div class="invalid-feedback" id="msgedtsatuan"></div>
                    </div>
                    <div class="form-group mb-2" id="edtinpHarga">
                        <label>Harga</label>
                        <input type="number" class="form-control n-val" id="edtharga" name="edtharga">
                        <div class="invalid-feedback" id="msgedtharga"></div>
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
                <h5 class="modal-title text-white" id="titleDelBahan"></h5>
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
                                <th>Nama Bahan</td>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th id="lblDelHarga">Harga</th>
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
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast'
        },
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    })

    $('.n-val').on('change', function() {
        if ($(this).val() != '' && $(this).val() != '0') {
            $('#' + $(this).attr('id')).addClass('is-valid')
            $('#' + $(this).attr('id')).removeClass('is-invalid')
        } else {
            $('#' + $(this).attr('id')).removeClass('is-valid')
            $('#' + $(this).attr('id')).addClass('is-invalid')
        }
    })

    function openMdl(tipe) {
        addModal.show()
        clearAddMdl()
        $('#tipe').val(tipe)
        if (tipe === 'bahan') {
            $('#titleAddBahan').text('Tambah Bahan Baku')
            $('#inpHarga').removeClass('d-none')
            $('#inpBahan').removeClass('d-none')
            $('#satuan').attr('disabled', false)
            $('#inpSelect').empty();
        } else {
            $('#titleAddBahan').text('Tambah Bahan Produk')
            $('#inpHarga').addClass('d-none')
            $('#inpBahan').addClass('d-none')
            $('#satuan').attr('disabled', true)
            $('#inpSelect').empty();
            $('#inpSelect').append('<div class="form-group mb-2"><label>Nama Bahan</label><select class="form-select n-val" id="nm_bahans" name="nm_bahans"></select><div class="invalid-feedback" id="msgnm_bahans"></div></div>')

            $.ajax({
                type: 'GET',
                url: '{{url("/bahan/Avl")}}',
                data: {
                    _token: CSRF_TOKEN,
                },
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        $('#nm_bahans').empty()
                        $('#nm_bahans').append('<option selected>--PILIH BAHAN--</option>')
                        result.data.forEach(el => {
                            $('#nm_bahans').append('<option value="' + el.id_bahan + '">' + el.nm_bahan + '</option>')
                        })
                    }
                }
            })
        }
    }

    $(document).on('change', '#nm_bahans', function() {
        var url = '{{url("/satuan/:id")}}'
        url = url.replace(':id', $('#nm_bahans').val())
        $.ajax({
            type: 'GET',
            url: url,
            data: {
                _token: CSRF_TOKEN,
            },
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    $('#satuan').val(result.data.id_satuan)
                    $('#satuan option[value=' + result.data.id_satuan + ']').text(result.data.eceran)
                    $('#satuan').trigger('change')
                    $('#nm_bahans').removeClass('is-invalid')
                    $('#nm_bahans').addClass('is-valid')
                } else {
                    $('#satuan').val(0)
                    $('#satuan').trigger('change')
                    $('#nm_bahans').addClass('is-invalid')
                    $('#nm_bahans').removeClass('is-valid')
                }
            }
        })
    })

    $('#btnAddSubmit').on('click', function() {
        var tipe = $('#tipe').val()
        if (tipe === 'bahan') {
            var nm_bahan = $('#nm_bahan').val()
            var harga = $('#harga').val()
        } else {
            var nm_bahan = $('#nm_bahans').val()
            var harga = 1
        }
        $.ajax({
            type: 'POST',
            url: '{{route("home.store")}}',
            data: {
                _token: CSRF_TOKEN,
                'tipe': tipe,
                'nm_bahan': nm_bahan,
                'jumlah': $('#jumlah').val(),
                'harga': harga,
                'satuan': $('#satuan').val(),
            },
            dataType: 'json',
            success: function(result) {
                if (result.success) {
                    $('#isiKonten').load('{{url("/refresh")}}')
                    addModal.hide()
                    Toast.fire({
                        icon: 'success',
                        title: result.msg
                    })
                } else {
                    if (tipe === 'bahan') {
                        if (result.errors['nm_bahan']) {
                            $('#nm_bahan').addClass('is-invalid')
                            $('#msgnm_bahan').text(result.errors['nm_bahan'])
                        }
                    } else {
                        if (result.errors['nm_bahan']) {
                            $('#nm_bahans').addClass('is-invalid')
                            $('#msgnm_bahans').text(result.errors['nm_bahan'])
                        }
                    }
                    if (result.errors['jumlah']) {
                        $('#jumlah').addClass('is-invalid')
                        $('#msgjumlah').text(result.errors['jumlah'])
                    }
                    if (result.errors['satuan']) {
                        $('#satuan').addClass('is-invalid')
                        $('#msgsatuan').text(result.errors['satuan'])
                    }
                    if (result.errors['harga']) {
                        $('#harga').addClass('is-invalid')
                        $('#msgharga').text(result.errors['harga'])
                    }
                }
            }
        })
    })

    function openEdtMdl(id, tipe) {
        $('.n-val').removeClass('is-invalid')
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

            $.ajax({
                type: 'GET',
                url: '{{url("/bahan/All")}}',
                data: {
                    _token: CSRF_TOKEN,
                },
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        $('#edtnm_bahans').empty()
                        $('#edtnm_bahans').append('<option selected>--PILIH BAHAN--</option>')
                        result.data.forEach(el => {
                            $('#edtnm_bahans').append('<option value="' + el.id_bahan + '">' + el.nm_bahan + '</option>')
                        })
                    }
                }
            })
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
                    $('[name="edtnm_bahan"]').val(result.data.data.nm_bahan)
                    $('#edtjumlah').val(result.data.data.jumlah)
                    $('#edtharga').val(result.data.data.harga)
                    $('#edtsatuan').empty()
                    if (tipe === 'produk') {
                        $('#edtsatuan').attr('disabled', true)
                    } else {
                        $('#edtsatuan').attr('disabled', false)
                    }
                    $('#edtsatuan').append('<option value="0" selected>--PILIH SATUAN--</option><option value="1">' + (tipe === 'bahan' ? 'kg' : 'gram') + '</option><option value="2">biji</option>')
                    $('#edtsatuan').val(result.data.data.satuan)
                    edtModal.show()
                }
            }
        })

        $(document).on('change', '#edtnm_bahans', function() {
            var url = '{{url("/satuan/:id")}}'
            url = url.replace(':id', $('#edtnm_bahans').val())
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    _token: CSRF_TOKEN,
                },
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        $('#edtsatuan').val(result.data.id_satuan)
                        $('#edtsatuan').trigger('change')
                        $('#edtnm_bahans').removeClass('is-invalid')
                        $('#edtnm_bahans').addClass('is-valid')
                    } else {
                        $('#edtsatuan').val(0)
                        $('#edtsatuan').trigger('change')
                        $('#edtnm_bahans').addClass('is-invalid')
                        $('#edtnm_bahans').removeClass('is-valid')
                    }
                }
            })
        })

        $('#btnEdtSubmit').on('click', function() {
            if (tipe === 'bahan') {
                var edtnm_bahan = $('#edtnm_bahan').val()
                var edtharga = $('#edtharga').val()
            } else {
                var edtnm_bahan = $('#edtnm_bahans').val()
                var edtharga = 1
            }
            var edtjumlah = $('#edtjumlah').val()
            var edtsatuan = $('#edtsatuan').val()
            $.ajax({
                type: 'PUT',
                url: url,
                data: {
                    _token: CSRF_TOKEN,
                    'tipe': tipe,
                    'edtnm_bahan': edtnm_bahan,
                    'edtjumlah': edtjumlah,
                    'edtsatuan': edtsatuan,
                    'edtharga': edtharga,
                },
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        $('#isiKonten').load('{{url("/refresh")}}')
                        edtModal.hide()
                        Toast.fire({
                            icon: 'success',
                            title: result.msg
                        })
                    } else {
                        if (tipe === 'bahan') {
                            if (result.errors['edtnm_bahan']) {
                                $('#edtnm_bahan').addClass('is-invalid')
                                $('#msgedtnm_bahan').text(result.errors['edtnm_bahan'])
                            }
                        } else {
                            if (result.errors['edtnm_bahan']) {
                                $('#edtnm_bahans').addClass('is-invalid')
                                $('#msgedtnm_bahans').text(result.errors['edtnm_bahan'])
                            }
                        }
                        if (result.errors['edtjumlah']) {
                            $('#edtjumlah').addClass('is-invalid')
                            $('#msgedtjumlah').text(result.errors['edtjumlah'])
                        }
                        if (result.errors['edtsatuan']) {
                            $('#edtsatuan').addClass('is-invalid')
                            $('#msgedtsatuan').text(result.errors['edtsatuan'])
                        }
                        if (result.errors['edtharga']) {
                            $('#edtharga').addClass('is-invalid')
                            $('#msgedtharga').text(result.errors['edtharga'])
                        }
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
        if (tipe === 'bahan') {
            $('#titleDelBahan').text('Hapus Bahan Baku')
        } else {
            $('#titleDelBahan').text('Hapus Bahan Produk')
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
                    $('#tbDelMdl').empty()
                    $('#tbDelMdl').append('<tr><td>' + (tipe === 'bahan' ? result.data.data.nm_bahan : result.data.data.bahan.nm_bahan) + '</td><td class="text-end">' + result.data.data.jumlah + '</td><td>' + (tipe === 'bahan' ? result.data.data.satuan_relasi.nm_satuan : result.data.data.satuan_relasi.eceran) + '</td><td class="text-end" id="txtDelHarga">' + result.data.data.harga + '</td></tr>')
                    if (tipe === 'produk') {
                        $('#lblDelHarga').addClass('d-none')
                        $('#txtDelHarga').addClass('d-none')
                    } else {
                        $('#lblDelHarga').removeClass('d-none')
                        $('#txtDelHarga').removeClass('d-none')
                    }
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
                        $('#isiKonten').load('{{url("/refresh")}}')
                        delModal.hide()
                        Toast.fire({
                            icon: 'success',
                            title: result.msg
                        })
                    }
                }
            })
        })
    }

    function clearAddMdl() {
        $('#nm_bahan').val('')
        $('#jumlah').val('')
        $('#harga').val('')
        $('#satuan').empty()
        $('#satuan').append('<option value="0" selected>--PILIH SATUAN--</option><option value="1">kg</option><option value="2">biji</option>')
        $('#satuan').val(0)
        $('.n-val').removeClass('is-valid')
        $('.n-val').removeClass('is-invalid')
    }
</script>
@endsection