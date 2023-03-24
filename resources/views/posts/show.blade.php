@extends('layouts.app')

@section('title', "SHOW PAGE")

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <a class="btn btn-outline-primary mb-3" href="{{ route('posts.index') }}">Go to Index Page</a>

                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{$post->title}}</h5>
                        <img src="{{asset($post->img)}}" width="180px" alt="img">
                        <p class="card-text">{{$post->content}}</p>
                        @can('update', $post)
                            <a class="btn btn-outline-success" style="width: 100%" href="{{route('posts.edit', $post->id)}}">Edit</a>
                        @endcan
                    </div>
                </div>

            </div>

            {{--            start add comment--}}
            <div class="container mt-5 mb-5">
                <h4 class="text-center">Оставить комментарий:</h4>
                <form action="{{ route('comments.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="commentInput">Комментарий:</label>
                        <textarea class="form-control @error('comment') is-invalid @enderror" id="commentInput" name="comment" placeholder="Введите ваш комментарий" required></textarea>
                        <input type="hidden" id="post_id" name="post_id" value="{{$post->id}}" />
                        @error('comment')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mt-3 mb-3">
                        <label for="imageInput">Фотография:</label>
                        <input type="file" style="border: 1px solid #ccc; padding: 5px; width: 100%;" class="form-control @error('image') is-invalid @enderror" id="imageInput" name="img">
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Отправить</button>
                </form>
            </div>
{{--end add comment--}}

                @foreach($post->comments as $com)
                <div class="col-md-9 mb-3 shadow-sm p-2 bg-white d-inline-flex flex-column">
                    <div class="mb-1">
                        <small>&nbsp;&nbsp;&nbsp;&nbsp;{{$com->user->name}} | <span class="comment-date"> {{\Carbon\Carbon::parse($com->created_at)->locale('ru')->diffForHumans()}} </span> </small>
                    </div>
                    <div class="d-inline-flex justify-content-between">
                        <p class="mr-5">{{ $com->comment }} &nbsp;&nbsp;
                            @if($com->img != 'noimg')
                                <img src="{{asset($com->img)}}" width="70px" alt="img">
                            @endif
                        </p>

                            <div class="btn-group btn-sm d-inline-flex align-items-center">
                                @can('update', $com)
                                    <!-- Button to Open the Modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{{$com->id}}">
                                        Edit
                                    </button>
                                @endcan
                                    {{--            start edit comment--}}
                                <!-- The Modal -->
                                <div class="modal fade" id="{{$com->id}}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Comment</h4>
                                                <button type="button" class="close" data-dismiss="modal">×</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form action="{{ route('comments.update', $com->id) }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="form-group">
                                                        <label for="commentInput">Content</label>
                                                        <textarea class="form-control @error('comment') is-invalid @enderror" id="commentInput" name="comment" rows="3">{{$com->comment}}</textarea>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label for="imgInput" class="form-label">Image</label>
                                                        <div class="d-flex flex-column">
                                                            <div class="me-3">
                                                                <img src="{{asset($com->img)}}" width="100px" alt="img">
                                                            </div>
                                                            <div class="flex-grow-1 mt-3">
                                                                <div class="input-group">Выбрать другое фото: &nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="file" class="form-control @error('img') is-invalid @enderror" id="imgInputUpdate" name="img">
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
                                </div>
                                    {{--end edit comment--}}

                                @can('delete', $com)
                                    <form action="{{route('comments.destroy', $com->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger mx-1" style="height: 80%" type="submit">Delete</button>
                                    </form>
                                @endcan
                            </div>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
@endsection

