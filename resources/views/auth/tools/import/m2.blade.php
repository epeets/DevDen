@extends('auth.layouts.app')

@section('content')
    @auth
    <h1>Magento 2 Web Api</h1>
    {!! Form::open(['action' => 'M2ImportController@store', 'method' => 'POST']) !!}
    <div class='form-group'>
        {{Form::label('API Url','API Url')}}
        {{Form::text('api','', ['class' => 'form-control', 'placeholder' => 'WordPress API URL', 'required'])}}
    </div>
    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
    @endauth
@endsection