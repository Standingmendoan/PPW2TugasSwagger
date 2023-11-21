@extends('auth.layouts')

@section('content')
    <div class="container">
        <h1>Edit Galeri</h1>
        <form method="POST" action="{{ route('gallery.update', ['gallery' => $gallery->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group m-3">
                <label for="title">Judul:</label>
                <input type="text" name="title" id="title" value="{{ $gallery->title }}" class="form-control">
            </div>

            <div class="form-group m-3">
                <label for="description">Deskripsi:</label>
                <textarea name="description" id="description" class="form-control">{{ $gallery->description }}</textarea>
            </div>

            <div class="form-group m-3">
                <label for="picture">Gambar:</label>
                <input type="file" name="picture" id="picture" class="form-control">
            </div>

            <div class="form-group m-3 ">
                <img src="{{ asset('storage/posts_image/' . $gallery->picture) }}" alt="{{ $gallery->title }}" style="max-width: 500px">
            </div>

            <button type="submit" class="btn btn-success ms-3">Simpan Perubahan</button>
        </form>
    </div>
@endsection
