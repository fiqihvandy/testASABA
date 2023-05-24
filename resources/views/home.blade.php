@extends('layout')

@section('content')
<div class="container">
    <div class="container-fluid mt-3">
        <p style="font-weight: 600;">PT. Jawa Food Sejahtera</p>

        <div class="card mt-4" style="border: 0; border-radius: 10px;">
            <div class="card-body">
                Aplikasi simulasi produksi makanan "Snaki" adalah sebuah solusi interaktif yang dirancang untuk membantu pengguna memperoleh hasil produksi yang maksimal. Aplikasi ini menyediakan kemampuan untuk mengubah jumlah kebutuhan bahan baku dan harga bahan baku, sehingga pengguna dapat mengeksplorasi skenario produksi yang berbeda untuk mendapatkan hasil optimal.
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        BAHAN BAKU
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</td>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Harga (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Gula Pasir</td>
                                    <td class="text-end">1</td>
                                    <td>Kg</td>
                                    <td class="text-end">{{number_format(10000, 0, ',', '.')}}</td>
                                </tr>
                                <tr>
                                    <td>Tepung Tapioka</td>
                                    <td class="text-end">1</td>
                                    <td>Kg</td>
                                    <td class="text-end">{{number_format(25000, 0, ',', '.')}}</td>
                                </tr>
                                <tr>
                                    <td>Coklat Batangan</td>
                                    <td class="text-end">1</td>
                                    <td>Kg</td>
                                    <td class="text-end">{{number_format(35000, 0, ',', '.')}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <div class="card-header">
                        PRODUKSI <b>@ Snaki</b>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</td>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Gula Pasir</td>
                                    <td>1</td>
                                    <td>Kg</td>
                                    <td>10000</td>
                                </tr>
                                <tr>
                                    <td>Gula Pasir</td>
                                    <td>1</td>
                                    <td>Kg</td>
                                    <td>10000</td>
                                </tr>
                                <tr>
                                    <td>Gula Pasir</td>
                                    <td>1</td>
                                    <td>Kg</td>
                                    <td>10000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3" style="border: 0; border-radius: 10px;">
            <div class="card-body">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo soluta earum sed ut maxime molestiae dolorem explicabo beatae nam a inventore quae tempore labore necessitatibus voluptatem, impedit quaerat possimus praesentium.
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
</script>
@endsection