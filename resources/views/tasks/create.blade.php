@extends('layouts.master')

@section('content')

<!--@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif -->

<h1>Add a New Task</h1>
<p class="lead">Add to your task list below.</p>
<hr>


@if(Auth::guest())
 <a href="/login" class="btn btn-info">
    You need to login to see this page! 😜😜 <br><br>
</a>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

@if(Auth::check())

{!! Form::open([
    'route' => 'tasks.store'
]) !!}

<div class="form-group"> *****{!! Auth::user()->name !!}*****
    {!! Form::hidden('user_email', Auth::user()->name, array( 'user' => 'user' ) ) !!}
    {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

{!! Form::submit('Create New Task', ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}

@endif

@stop
