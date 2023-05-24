@extends('layout')

@section('content')
<div class="container">
    <div class="container-fluid mt-3">
        <p style="font-weight: 600;">PT. Jawa Food Sejahtera</p>

        <div class="card mt-4 shadow" style="border: 0; border-radius: 10px;">
            <div class="card-body">
                Aplikasi simulasi produksi makanan "Snaki" adalah sebuah solusi interaktif yang dirancang untuk membantu pengguna memperoleh hasil produksi yang maksimal. Aplikasi ini menyediakan kemampuan untuk mengubah jumlah kebutuhan bahan baku dan harga bahan baku, sehingga pengguna dapat mengeksplorasi skenario produksi yang berbeda untuk mendapatkan hasil optimal.
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <div class="card shadow my-1">
                    <div class="card-header">
                        BAHAN BAKU
                        <button class="btn btn-sm btn-success float-end" onclick="openMdl('bahan')"><i class="fas fa-plus mr-1"></i> Tambah Bahan</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</td>
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
                                        <button class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></button>
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow my-1">
                    <div class="card-header">
                        PRODUKSI <b>@ Snaki</b>
                        <button class="btn btn-sm btn-success float-end" onclick="openMdl('produk')"><i class="fas fa-plus mr-1"></i> Tambah Bahan</button>
                    </div>
                    <div class="card-body">
                        @if ($produk->isNotEmpty())
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</td>
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
                                        $hargaper = ($pr->bahan->harga / $pr->satuanRelasi->jumlah) * $pr->jumlah;
                                        $total += $hargaper;
                                        @endphp
                                        {{number_format($hargaper, 0, ',', '.')}}
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></button>
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
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
                Biaya produksi untuk setiap kemasan "Snaki" adalah : {{number_format($total, 0, ',', '.')}} Rupiah.
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
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
                        <select class="form-select" id="nm_bahan" name="nm_bahan">
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
@endsection

@section('script')
<script>
    let myModal = new bootstrap.Modal(document.getElementById('addBahan'), {})

    function openMdl(tipe) {
        myModal.show()
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
</script>
@endsection