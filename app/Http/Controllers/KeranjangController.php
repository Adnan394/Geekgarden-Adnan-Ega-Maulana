<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Keranjang;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\KeranjangCollection;
use App\Models\Transaksi;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role_id != 1) {
            $keranjang = Keranjang::where('user_id', Auth::user()->id)->paginate(5); 
            return new KeranjangCollection($keranjang);
        }else {
            $keranjang = Keranjang::paginate(5);
            return new KeranjangCollection($keranjang);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->role_id != 2) {
            return Response()->json([
                'message' => 'Error 403 forbidden'
            ]);
        }
        $produk = Produk::where('id', $request->produk_id)->first();
        $data = Keranjang::create([
            'id' => Str::uuid(),
            'user_id' => Auth::user()->id,
            'produk_id' => $request->produk_id,
            'harga' => $produk->harga * $request->jumlah,
            'jumlah' => $request->jumlah,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        return Response()->json([
            'message' => 'Pesanan Disimpan Dikeranjang',
            'data' => [$data],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $keranjang = Keranjang::where('id', $id)->get();
        return new KeranjangCollection($keranjang);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->role_id != 1) {
            $update = Keranjang::findOrFail($id);
            $produk = Produk::where('id', $update->produk_id)->first();
            if($update->user_id == Auth::user()->id) {
                $update->jumlah = $request->jumlah;
                $update->harga = $produk->harga * $request->jumlah;
                $update->metode_pembayaran = $request->metode_pembayaran;
                
                $update->save();
                return Response()->json([
                    'message' => 'Data berhasil diubah!',
                    'data' => [$update],
                ]);
            }else {
                return Response()->json([
                    'message' => 'tidak bisa merubah data post yang bukan anda Author nya',
                ]);
            }
        }else {
            return Response()->json([
                'message' => 'Error 403 Forbidden',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->role_id != 2) {
            return Response()->json([
                'message' => 'Error 403 forbidden'
            ]);
        }
        $keranjang = Keranjang::findOrFail($id);

        if($keranjang->user_id == Auth::user()->id) {
            $keranjang->delete();
            return Response()->json([
                'message' => 'Data berhasil dihapus!',
            ]);
        }else {
            return Response()->json([
                'message' => 'ada tidak dapat menghapus postingan yang bukan anda buat!',
            ]);
        }
    }
}