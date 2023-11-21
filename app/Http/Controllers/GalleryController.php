<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $data = array(
    //         'id'=> "posts",
    //         'menu' => "Gallery",
    //         'galleries' => Post::where('picture', '!=', 
    //         '')->whereNotNull('picture')->orderBy('created_at', 'desc')->paginate(30)
    //     );
    //     return view('gallery.index')->with($data);
    // }

    public function index()
{
    // Mengambil data dari API
    $response = Http::get('http://127.0.0.1:8001/api/getPic');

    if ($response->failed()) {
        return response()->json(['error' => 'Gagal mengambil data melalui API'], 500);
    }

    $data = $response->json();

    // Melanjutkan dengan menampilkan data di view
    return view('gallery.index', ['galleries' => $data]);
}
    public function store(Request $request)

    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);

        $response = Http::post('http://127.0.0.1:8001/api/postPic', [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $request->file('picture')
        ]);

        $responseData = $response->json();
        if ($responseData) {
            return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
        } else {
            return redirect('gallery')->with('error', 'Gagal menambah data');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gallery.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $this->validate($request, [
    //         'title' => 'required|max:255',
    //         'description' => 'required',
    //         'picture' => 'image|nullable|max:1999'
    //         ]);
    //         if ($request->hasFile('picture')) {
    //             $filenameWithExt = $request->file('picture')->getClientOriginalName();
    //             $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
    //             $extension = $request->file('picture')->getClientOriginalExtension();
              
    //             $basename = uniqid() . time();
    //             $smallFilename = "small_{$basename}.{$extension}";
    //             $mediumFilename = "medium_{$basename}.{$extension}";
    //             $largeFilename = "large_{$basename}.{$extension}";

    //             $filenameSimpan = "{$basename}.{$extension}";
    //             $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
    //         } else {
    //             $filenameSimpan = 'noimage.png';
    //         }
    //         // dd($request->input());
    //         $post = new Post;
    //         $post->picture = $filenameSimpan;
    //         $post->title = $request->input('title');
    //         $post->description = $request->input('description');
    //         $post->save();

    //         return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
           
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gallery = Post::findOrFail($id);
        return view('gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);
    
        $gallery = Post::findOrFail($id);
    
        if ($request->hasFile('picture')) {
            // Hapus gambar lama jika ada, kecuali jika itu gambar default
            if ($gallery->picture !== 'noimage.png') {
                Storage::delete('posts_image/' . $gallery->picture);
            }
    
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
          
            $basename = uniqid() . time();
            $smallFilename = "small_{$basename}.{$extension}";
            $mediumFilename = "medium_{$basename}.{$extension}";
            $largeFilename = "large_{$basename}.{$extension}";
    
            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
    
            $gallery->picture = $filenameSimpan;
        }
    
        $gallery->title = $request->input('title');
        $gallery->description = $request->input('description');
        $gallery->save();
    
        return redirect('gallery')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gallery = Post::findOrFail($id);

        // Hapus gambar terkait jika ada
        if ($gallery->picture !== 'noimage.png') {
            Storage::delete('posts_image/' . $gallery->picture);
        }

        $gallery->delete();

        return redirect('gallery')->with('success', 'Data berhasil dihapus');
        }
}
