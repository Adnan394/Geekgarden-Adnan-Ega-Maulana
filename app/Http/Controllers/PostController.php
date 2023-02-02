<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostCollection;
use GuzzleHttp\Psr7\Response;

class PostController extends Controller
{
    //

    public function index() {
        $posts = Post::where('author', Auth::user()->id)->paginate(5); 
        return new PostCollection($posts);
    }

    public function store(Request $request) {
        $data = Post::create([
            'title' => $request->title,
            'news_content' => $request->news_content,
            'author' => Auth::user()->id,
        ]);

        return Response()->json([
            'message' => 'Data berhasil ditambah!',
            'data' => [$data],
        ]);
    }

    public function update(Request $request, $id) {
        $update = Post::findOrFail($id);
        if($update->author == Auth::user()->id) {
            $update->title = $request->title;
            $update->news_content = $request->news_content;
            $update->author = Auth::user()->id;
    
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

    public function show($id) {
        $posts = Post::where('id', $id)->get();
        return new PostCollection($posts);
    }
    public function delete($id) {
        $posts = Post::findOrFail($id);

        if($posts->author == Auth::user()->id) {
            $posts->delete();
            return Response()->json([
                'message' => 'Data berhasil dihapus!',
            ]);
        }else {
            return Response()->json([
                'message' => 'ada tidak dapat menghapus postingan yang bukan anda buat!',
            ]);
        }
    }

    public function search($request) {
        $posts = Post::where('title', 'like', '%'.$request.'%')->paginate(5);
        return new PostCollection($posts);
    }
}