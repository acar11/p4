
@extends('layouts.master')

@section('content')

@if(Auth::check())

@php

$today = Carbon\Carbon::today()->setTimezone('America/New_York');
//var_dump($today);
$day_five   = Carbon\Carbon::today()->addDays(5)->setTimezone('America/New_York')->format('Y-m-d 00:00:00');
$day_four   = Carbon\Carbon::today()->addDays(4)->setTimezone('America/New_York')->format('Y-m-d 00:00:00');
$day_three  = Carbon\Carbon::today()->addDays(3)->setTimezone('America/New_York')->format('Y-m-d 00:00:00');
$day_two    = Carbon\Carbon::today()->addDays(2)->setTimezone('America/New_York')->format('Y-m-d 00:00:00');
$day_one    = Carbon\Carbon::today()->addDays(1)->setTimezone('America/New_York')->format('Y-m-d 00:00:00');
$day_due    = Carbon\Carbon::today()->addDays(0)->setTimezone('America/New_York')->format('Y-m-d 00:00:00');
//var_dump($day_due);
$todays_date = Carbon\Carbon::now()->setTimezone('America/New_York');

$todays = $todays_date->toFormattedDateString();
//dd($todays);

//if( $tasks[0]->user_id ) {
//if( isset($task) && isset($tasks) ) {

# Using user_id sent by TasksController
if( isset($send_user_id) ) {

  # Get the timezone for the user.
  //$get_zone = DB::table('users_timezone_log')->select('users_timezone_log.zone')
  //          ->join('tasks','tasks.user_id','=','users_timezone_log.user_id')
  //          ->where('users_timezone_log.user_id', $tasks[0]->user_id)->pluck('zone');

  # Get the timezone for the user.
  $get_zone = DB::table('users')->select('timezone')
            ->where('id', $send_user_id)->pluck('timezone');

}

if( isset($get_zone) ) {

  $got_zone = "Timezone is ".$get_zone[0];

}else{

  $got_zone = "No timezone set";

}

@endphp

<h1>Tasks'n Things to Remember.</h1>

<p class="lead">Hi {{ Auth::user()->name }}, here's a list of all your tasks as today,
  <span class="todays_date"> {{ $todays }}</span>
  <span class="timezone"> - {{ $got_zone }} </span>
</p>
<p class="tasks_header">
  <span class="green_tasks_sign"> It's new, no worries! </span>
  <span class="five_tasks_sign"> Due in 5 days! </span>
  <span class="two_tasks_sign"> Due in 2 days! </span>
  <span class="due_tasks_sign"> Due now, run away!</span>
  <span class="dummed_tasks_sign"> Dude, this task is dummed! </span>
</p>
</br>
  <!--a href="/tasks/create">Add a new one?</a-->
<p class="lead">  <a href="{{ route('tasks.create') }}" class="btn_x btn-info">Add New Task</a>
</p>

<hr>
@foreach($tasks as $task)

@php

if($task->date_me){

  // making sure date has the right delimeter
  $check_date = str_replace('/','-',$task->date_me);
  list($month, $day, $year) = explode('-', $check_date);
  $format_date = $year.'-'.$month.'-'.$day;
  $my_due_date = Carbon\Carbon::parse($format_date);

  //var_dump($day_due.' = '. $my_due_date);

}else{

  $my_due_date = '';
}

@endphp

    @if( $day_five == $my_due_date )

      <div class="five_tasks">
        <span class="tasks_title"> {{ $task->title }} </span>
        <span class='tasks_due_date_five'> Due on {{ $task->date_me }} </span>
      </div>

    @elseif($day_two  == $my_due_date )

      <div class="two_tasks">
        <span class="tasks_title"> {{ $task->title }} </span>
        <span class='tasks_due_date_two'> Due on {{ $task->date_me }} </span>
      </div>

    @elseif($day_due  == $my_due_date)

      <div class="due_tasks">
        <span class="tasks_title"> {{ $task->title }} </span>
        <span class='tasks_due_date_due'> Due today! {{ $task->date_me }} </span>
      </div>

    @elseif( $my_due_date && $today > $my_due_date )

      <div class="dummed_tasks">
        <span class="tasks_title"> {{ $task->title }} </span>
        <span class='tasks_due_date_dummed'> It was due on {{ $task->date_me }} </span>
      </div>

    @elseif($day_five < $my_due_date)

      <div class="green_tasks">
        <span class="tasks_title"> {{ $task->title }} </span>
        <span class='tasks_due_date_green'> Due on {{ $task->date_me }} </span>
      </div>

     @else

       @if($my_due_date)
         <div class="no_date_range">
           <span class="tasks_title">{{ $task->title }} </span>
           <span class='tasks_no_date_no_range'> Due on {{ $task->date_me }}</span>
         </div>
       @else
         <div class="no_date_range">
        <span class="tasks_title">{{ $task->title }} </span>
        <span class='tasks_no_date_no_range'> No set due date</span>
      </div>
       @endif

    @endif

    <p class="space">&nbsp;</p>
    <p class="desc">{{ $task->description}}</p>
    <p class="btn_down">
        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info">View Task</a>
        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary">Edit Task</a>
    </p>
    <hr>

@endforeach

@endif

@if(Auth::guest())

 <a href="/login" class="btn btn-info">
    You need to login to see this page!<br><br>
</a>

@endif

@stop
