
@extends('layouts.master')

@section('content')

<h1>Task List</h1>
@if(Auth::check())

<p class="lead">ok Here's a list of all your tasks.
  <!--a href="/tasks/create">Add a new one?</a-->
  <a href="{{ route('tasks.create') }}">Add a new one?OKOK</a>
</p>
<hr>

@foreach($tasks as $task)
    <h3>{{ $task->title }}</h3>
    <p>{{ $task->description}}</p>
    <p>
        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info">View Task</a>
        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary">Edit Task</a>
    </p>
    <hr>
@endforeach
@endif
@if(Auth::guest())
 <a href="/login" class="btn btn-info">
    You need to login to see this page! 😜😜 <br><br>
</a>
@endif
@stop
