@extends('layouts.master')

@section('content')

<h1>Editing "{{ $task->title }}"</h1>
<p class="lead">Edit and save this task below, or <a href="{{ route('tasks.index') }}">go back to all your tasks.</a></p>
<hr>

@include('partials.alerts.errors')

<!--@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif-->

{!! Form::model($task, [
    'method' => 'PATCH',
    'route' => ['tasks.update', $task->id]
]) !!}

<div class="form-group">
    {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('reminder', 'Set Date Reminder:', ['class' => 'control-label']) !!}
    {!! Form::text('date_me', null, ['class' => 'date form-control_picker']) !!}
</div>

{!! Form::submit('Update Task', ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}
<script type="text/javascript">
  $('.date').datepicker({
    format: 'mm-dd-yyyy'
  });
</script>
@stop
