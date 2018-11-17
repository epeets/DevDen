@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    <div class="row">
        @if(count($posts) >= 1)
            @foreach($posts as $post)
            <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        @if($post->featured_image)
                            <?php $featuredImage=URL::to('/')."/storage/images/wp/$post->featured_image" ?>
                            <a href="/posts/{{$post->id}}"><img class="card-img-top" src="<?php echo $featuredImage ?>" width="250px" alt="Card image cap"></a>
                        @endif
                        <div class="card-body">
                            <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Written on {{$post->created_at}} by {{$post->user->name}}</small>
                        </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>No posts found</p>
        @endif
    </div>
    <div class="row">
        <div width="400px" class="mx-auto">
            {{$posts->links()}}
        </div>
    <div>
@endsection