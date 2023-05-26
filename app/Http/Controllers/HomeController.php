<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Bahan;
use App\Produk;
use App\Satuan;

class HomeController extends Controller
{
    public function index()
    {
        $data['bahan'] = Bahan::all();
        $data['produk'] = Produk::all();
        $data['satuan'] = Satuan::all();
        return view('home', $data);
    }

    public function refresh()
    {
        $data['bahan'] = Bahan::all();
        $data['produk'] = Produk::all();
        return view('content', $data);
    }

    public function getBahan($mode)
    {
        if ($mode == 'All') {
            $data = Bahan::all();
        } else {
            $data = Bahan::whereDoesntHave('produk')->get();
        }
        $result = ['success' => true, 'data' => $data];
        return json_encode($result);
    }

    public function getSatuan($id)
    {
        $data = Bahan::find($id);
        if ($data) {
            $result = ['success' => true, 'data' => $data->satuanRelasi];
        } else {
            $result = ['success' => false];
        }
        return json_encode($result);
    }

    public function show($id, Request $request)
    {
        $tipe = $request->tipe;
        if ($tipe === 'bahan') {
            $data['data'] = Bahan::find($id);
            $data['satuan'] = $data['data']->satuanRelasi;
        } else {
            $data['data'] = Produk::find($id);
            $data['satuan'] = $data['data']->satuanRelasi;
            $data['bahan'] = $data['data']->bahan;
        }
        $result = ['success' => true, 'data' => $data];
        return json_encode($result);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nm_bahan' => 'required|gt:0',
            'jumlah' => 'required',
            'harga' => 'required',
            'satuan' => 'required|gt:0',
        ], [
            'satuan.*' => 'You have to choose the satuan.',
            'nm_bahan.gt' => 'You have to choose the nm bahan.'
        ]);
        if ($validator->fails()) {
            $result = ['success' => false, 'errors' => $validator->errors()];
            return json_encode($result);
        }

        if ($request->tipe === 'bahan') {
            $bahan = new Bahan;
            $bahan->nm_bahan = $request->nm_bahan;
            $bahan->jumlah = $request->jumlah;
            $bahan->satuan = $request->satuan;
            $bahan->harga = $request->harga;
            $bahan->save();
        } else {
            $produk = new Produk;
            $produk->nm_bahan = $request->nm_bahan;
            $produk->jumlah = $request->jumlah;
            $produk->satuan = $request->satuan;
            $produk->save();
        }
        $result = ['success' => true, 'msg' => 'Berhasil menambahkan data!'];
        return json_encode($result);
    }

    public function update($id, Request $request)
    {
        if ($request->tipe === 'bahan') {
            $bahan = Bahan::find($id);
            $bahan->nm_bahan = $request->edtnm_bahan;
            $bahan->jumlah = $request->edtjumlah;
            $bahan->satuan = 1;
            $bahan->harga = $request->edtharga;
            $bahan->save();
        } else {
            $produk = Produk::find($id);
            $produk->nm_bahan = $request->edtnm_bahan;
            $produk->jumlah = $request->edtjumlah;
            $produk->satuan = 1;
            $produk->save();
        }
        $result = ['success' => true, 'msg' => 'Berhasil edit data!'];
        return json_encode($result);
    }

    public function destroy($id, Request $request)
    {
        $tipe = $request->tipe;
        if ($tipe === 'bahan') {
            Bahan::find($id)->delete();
            Produk::where('nm_bahan', $id)->delete();
        } else {
            Produk::find($id)->delete();
        }
        $result = ['success' => true, 'msg' => 'Berhasil menghapus data!'];
        return json_encode($result);
    }
}
