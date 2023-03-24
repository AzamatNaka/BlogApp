@extends('layouts.app')

@section('title', "CREATE PAGE")

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <a class="btn btn-outline-primary mb-3" href="{{ route('posts.index') }}">Go to Index Page</a>

                <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="titleInput">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="titleInput" name="title" placeholder="Enter title">
                        @error('title')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contentInput">Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="contentInput" name="content" rows="3"></textarea>
                        @error('content')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="imgInput" class="form-label">Image</label>
                        <input type="file" class="form-control @error('img') is-invalid @enderror" id="imgInput" name="img">
                        @error('img')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <button class="btn btn-outline-success" type="submit">Save post</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
