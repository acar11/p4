@extends('layouts.master')

@section('content')

<h1>Welcome to Tasks'n things to remember Management</h1>
<p class="lead">This is simple list if things we must do and we just forget because of our busy
  schedule or life style. Who has room in our brain to remember all these little things sometimes, right?
  Our list can help, it will be color coded to show you how the dates are going as far as been on time,
  or if a task is about to became due.
  The reason for colors is to help you not to focus too much
  on reading dates, but to instruct your subconscious mind that something is about to be due
  and ready to be completed, we that it's something fun!
  Enjoy scheduling your tasksn' things to do!</p>
<hr>

@if(Auth::check())
<a href="{{ route('tasks.index') }}" class="btn btn-info">View Tasks</a>
<a href="{{ route('tasks.create') }}" class="btn btn-primary">Add New Task</a>
@endif

@stop
