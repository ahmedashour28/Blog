@extends('layouts.app')

@section('content')

    <a href="/posts" class="btn btn-default">Back</a>
    <h1> {{$post->title}}</h1>
    <img style="width: 50%" src="/storage/images/{{$post->image}}" alt="">
    <p>{{$post->body}}</p>
    <hr>
    <small>Posted at {{$post->created_at}}</small>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id== $post->user_id)
            <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
            <form action="{{ route('posts.destroy',$post->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">
                    Delete
                </button>
            </form>
        @endif
    @endif
@endsection
