@extends('layouts.app')

@section('content')

    <h1> Posts</h1>
    @if(count($posts)>=1)
    <dev class="card">
        <ul class="list-group list-group-flush">
        @foreach($posts as $post)
            <div class="row">
                <div class="col-md-4">
                    <img style="width: 50%" src="/storage/images/{{$post->image}}" alt="">
                </div>
                <div class="col-md-8">
                    <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                    <small>Posted at {{$post->created_at}}</small>
                </div>
            </div>
        @endforeach

        </ul>
    </dev>
    @endif



@endsection
