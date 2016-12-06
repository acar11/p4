@extends('layouts.master')

@section('content')

<!--@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif -->

<h1>Add a New Task</h1>
<p class="lead">Add your new task below or <a href="{{ route('tasks.index') }}">go back to all your tasks.</a></p>
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

<div class="form-group">
    {!! Form::hidden('user_id', Auth::user()->id, array( 'id' => 'user_id' ) ) !!}
    {!! Form::hidden('user_email', Auth::user()->email, array( 'id' => 'email' ) ) !!}
    {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('reminder', 'Set Date Reminder:', ['class' => 'control-label']) !!}
    <!--input class="date form-control" style="width: 300px;" type="text"-->
    {!! Form::text('date_me', null, ['class' => 'date form-control']) !!}
</div>

{!! Form::submit('Create New Task', ['class' => 'btn btn-primary']) !!}
<br><br><br>
{!! Form::close() !!}
<script type="text/javascript">
        $('.date').datepicker({
           format: 'mm-dd-yyyy'
         });
    </script>
@endif

@stop
