<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProdukCollection;
use GuzzleHttp\Psr7\Response;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::where('user_id', Auth::user()->id)->paginate(5); 
        return new ProdukCollection($produk);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->role_id != 1) {
            return Response()->json([
                'message' => 'Error 403 forbidden'
            ]);
        }
        $data = Produk::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'user_id' => Auth::user()->id,
        ]);

        return Response()->json([
            'message' => 'Data berhasil ditambah!',
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
        $produk = Produk::where('id', $id)->get();
        return new ProdukCollection($produk);
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
            return Response()->json([
                'message' => 'Error 403 forbidden'
            ]);
        }
        $update = Produk::findOrFail($id);
        if($update->user_id == Auth::user()->id) {
            $update->nama = $request->nama;
            $update->deskripsi = $request->deskripsi;
            $update->harga = $request->harga;
            $update->user_id = Auth::user()->id;
    
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->role_id != 1) {
            return Response()->json([
                'message' => 'Error 403 forbidden'
            ]);
        }
        $produk = Produk::findOrFail($id);

        if($produk->user_id == Auth::user()->id) {
            $produk->delete();
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