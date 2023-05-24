<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bahan;
use App\Produk;

class HomeController extends Controller
{
    public function index()
    {
        $data['bahan'] = Bahan::all();
        $data['produk'] = Produk::all();
        return view('home', $data);
    }

    public function show($id, Request $request)
    {
        $tipe = $request->tipe;
        if ($tipe === 'bahan') {
            $data = Bahan::find($id);
        } else {
            $data = Produk::find($id);
        }
        $result = ['success' => true, 'data' => $data];
        return json_encode($result);
    }

    public function store(Request $request)
    {
        if ($request->tipe === 'bahan') {
            $bahan = new Bahan;
            $bahan->nm_bahan = $request->nm_bahan;
            $bahan->jumlah = $request->jumlah;
            $bahan->satuan = 1;
            $bahan->harga = $request->harga;
            $bahan->save();
        } else {
            $produk = new Produk;
            $produk->nm_bahan = $request->nm_bahan;
            $produk->jumlah = $request->jumlah;
            $produk->satuan = 1;
            $produk->save();
        }
        return redirect()->back()->with('success', 'your message,here');
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
}
