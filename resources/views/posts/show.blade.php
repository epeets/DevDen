@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-default">Go Back</a>
    <?php $title=$post->title; ?>
    <h1>{{html_entity_decode($title)}}</h1>
    <img style="width:100%" src="/storage/images/wp/{{$post->featured_image}}">
    <br><br>
    <div>
        {!!$post->body!!}
    </div>
    <hr>
    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
@endsection