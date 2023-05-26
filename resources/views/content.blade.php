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