@extends('auth.layouts')

@section('content')
<div class="container">
    <h2>User List</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Original Photo</th>
                <th>Thumbnail</th>
                <th>Square Photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if ($user->photo)
                        <img src="{{ asset('storage/photos/' . $user->photo) }}" width="500px" height="300px" alt="Original Photo">
                    @else
                        No Photo
                    @endif
                </td>
                <td>
                    @if ($user->thumbnail)
                        <img src="{{ asset('storage/photos/' . $user->thumbnail) }}" alt="Thumbnail">
                    @else
                        No Thumbnail
                    @endif
                </td>
                <td>
                    @if ($user->square)
                        <img src="{{ asset('storage/photos/' . $user->square) }}" alt="Square Photo">
                    @else
                        No Square Photo
                    @endif
                </td>
                <td>
                    <a href="{{ route('edit-profile', ['id' => $user->id]) }}" enctype="multipart/form-data" class="btn btn-primary">Edit</a>
                    <form class="mt-2" action="{{ route('delete-photos', ['id' => $user->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning">Delete</button>
                    </form>
                </td>
            </tr>
            @if (session('success'))
                <div class="alert alert-primary">
                    {{ session('success') }}
                </div>
            @endif
        </tbody>
    </table>
</div>

@endsection
