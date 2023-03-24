@extends('layouts.app')

@section('title', "EDIT PAGE")

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <a class="btn btn-outline-primary mb-3" href="{{ route('posts.index') }}">Go to Index Page</a>

                <form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="titleInput">Title</label>
                        <input type="text" name="title" value="{{$post->title}}" class="form-control @error('title') is-invalid @enderror" id="titleInput" placeholder="Enter title">
                        @error('title')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contentInput">Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="contentInput" name="content" rows="3">{{$post->content}}</textarea>
                        @error('content')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="imgInput" class="form-label">Image</label>
                        <div class="d-flex flex-column">
                            <div class="me-3">
                                <img src="{{asset($post->img)}}" width="100px" alt="img">
                            </div>
                            <div class="flex-grow-1 mt-3">
                                <div class="input-group">
                                    <input type="file" class="form-control @error('img') is-invalid @enderror" id="imgInput" name="img" aria-label="Upload">
                                </div>
                                @error('img')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <div class="form-group mt-3">
                        <button class="btn btn-outline-success" type="submit">Update post</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

