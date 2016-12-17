@extends('layouts.master')

@section('content')

<h1>Welcome to Tasks'n Things to Remember Management</h1>
 <p class="lead">This is a list of things we must do and we just forget because of our busy
  schedule or lifestyle. Our brain is full to its capacity most of the time and to remember
  all these little things, its just tough, right?
  Our list can help, it will be color coded to show how the dates are progressing
  as far as being on time, or if a task is about to be due.
  The reason for the colors is to help you not to focus too much on reading just plain dates,
  but to instruct your subconscious mind that something is about to be due
  and ready to be completed, hoping that it's something fun!</p>
 <p class="lead">Enjoy scheduling your Tasks'n Things!</p>
<hr>

@if(Auth::check())
<a href="{{ route('tasks.index') }}" class="btn btn-info">View Tasks</a>
<a href="{{ route('tasks.create') }}" class="btn btn-primary">Add New Task</a>
@endif

@stop
