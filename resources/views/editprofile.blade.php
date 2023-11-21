@extends('auth.layouts')

@section('content')
<form method="POST" action="{{ route('update-profile', ['id' => $user->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <!-- Tambahkan bidang lain yang ingin diedit -->

<form action="{{ route('update-profile', ['id' => $user->id]) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" value="{{ $user->name }}" class="form-control">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" value="{{ $user->email }}" class="form-control">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="mb-3 mt-3 col">
        <label for="photo" class=" col-form-label text-md-end text-start">Edit Photo</label>
        <div class="col-md-6">
            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" value="{{ old('photo') }}">
            @if ($errors->has('photo'))
                <span class="text-danger">{{ $errors->first('photo') }}</span>
            @endif
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection

