@extends('auth.layouts.app')

@section('content')
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Featured Image</th>
                <th scope="col">Title</th> 
                <th scope="col">Created At</th> 
                <th scope="col">Author</th> 
                <th scope="col">Delete</th>
            <tr>
        </thead>
        <tbody> 
            @if(count($posts) >= 1)
                @foreach($posts as $post)
                    @if(Auth::user()->id == $post->user_id)
                        <tr>
                            <td>
                                    @if($post->featured_image)
                                        <?php $featuredImage=URL::to('/')."/storage/images/$post->featured_image" ?>
                                        <img src="<?php echo $featuredImage ?>" width="250px"/>
                                    @endif
                            </td>
                            <td>
                                <span><a href="/auth/posts/{{$post->id}}/edit">{{$post->title}}</a></span>
                            </td>
                            <td>
                                <span>{{$post->created_at}}</span>
                            </td>
                            <td>
                                <span>{{$post->user->name}}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deletePost{{$post->id}}">Delete</button>
                                <div class="modal fade" id="deletePost{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="deletePostLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deletePostLabel">Delete {{$post->title}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                    <span>Are you sure you want to delete this post?</span>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    {{Form::submit('Yes', ['class' => 'btn btn-danger'])}}
                                                {!!Form::close()!!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        <tr>
                    @endif
                @endforeach
            @else
                <p>No posts found</p>
            @endif
        </tbody>
    </table>
</div>
<div class="container">
    <div class="row">
        <div width="400px" class="mx-auto">
            {{$posts->links()}}
        </div>
    </div>
<div>
@endsection