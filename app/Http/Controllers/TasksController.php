<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Task;
use Mail;
use App\Mail\MyReminder;
use Auth;
use Carbon;

class TasksController extends Controller
{

  /**
  * GET
  */
  public function index(Request $request)
  {

    $user = $request->user();
    //dd($user->id);
    # Note: We're getting the user from the request, but you can also get it like this:
    $user = Auth::user();
    //dd($user->id);
    if($user) {
        # Approach 1)
        $tasks = Task::where('user_id', '=', $user->id)->orderBy('id','DESC')->get();

        //$tasks = Task::where('user_id', '=', $user->id)->orderBy('user_id','DESC')->get();
        //dd($tasks);
        # Approach 2) Take advantage of Model relationships
        //$tasks = $user->tasks()->get();
        //dd($tasks);
    }
    else {
      //dd($user->id);
        $tasks = [];
    }

  //  $day_five = Carbon\Carbon::today()->addDays(5);
  //  $day_two  = Carbon\Carbon::today()->addDays(2);
  //  $day_due  = Carbon\Carbon::today()->addDays(0);
/*
   $my_dates = array();
   foreach ($tasks as $task){

     if($task->date_me){
     list($month, $day, $year) = explode('-', $task->date_me);
     $format_date = $year.'-'.$month.'-'.$day;
     //var_dump('Line 52 '.$format_date);
     $my_date = Carbon\Carbon::parse($format_date);
     var_dump('Line 54A '.$format_date.' - '.$my_date);

     array_push($my_dates, $my_date);
     }
   }
*/
//var_dump($my_dates);
// assuming I alredy have all the logic for the days due here:
    return view('tasks.index')->with([
        'tasks' => $tasks,
        //'my_dates' => $my_dates,
        //'day_f' => 0
    ]);
  }
  //public function index() {

  //  $tasks = Task::all();
//    return view('tasks.index')->withTasks($tasks);
    //return view('tasks.index');

//  }

  public function create() {

    return view('tasks.create');

  }

  public function store(Request $request){
    //dd($request->all());

    $this->validate($request, [
      'title' => 'required',
      'description' => 'required'
    ]);

    # get todays date for email reminder test
    $mytime = Carbon\Carbon::now();
    //$mytime = new Carbon\Carbon();
    $today = Carbon\Carbon::today();
    //$today->subDays(5);
    //dd($today);
    #$the_date = $mytime->toDateString();
    $the_date = $mytime->toDateTimeString();

    //$test_date = '12-31-2016'; //"12-31-2016"

    //dd($test_date);
    //$new_date = Carbon\Carbon::createFromFormat('d/m/Y',$test_date);
    //if($model->edited_at->gt($model->created_at)){
    // edited at is newer than created at
    //}
    //dd('line 84 - '.Carbon\Carbon::today()->subDays(30)->toDateTimeString(). ' - '.Carbon\Carbon::parse($request->date_me)->toDateTimeString());
    //$test_date = '12-06-2016';

    $test_today = Carbon\Carbon::today()->addDays(0);
    $day_five = Carbon\Carbon::today()->addDays(5);
    $day_two  = Carbon\Carbon::today()->addDays(2);
    $day_due  = Carbon\Carbon::today()->addDays(0);

    //dd($days_to); // 12-02-2016
    //var_dump('Line 93 '.$request->date_me);
    //$mydate = date('Y-m-d',$request->date_me);
    //$mydate = strptime($request->date_me, '%Y-%m-%d');
    //var_dump('Line 96 '.$mydate);
    //$mydate->getTimestamp();
    //$test_date = '12-09-2016';

    if($request->date_me) {
    var_dump($request->date_me);
    //list($month, $day, $year) = explode('-', $request->date_me);
    //$format_date = $year.'-'.$month.'-'.$day;
    //var_dump('Line 101 '.$format_date);
    //$my_date = Carbon\Carbon::parse($format_date);
    $my_date = Carbon\Carbon::parse($request->date_me);

    //$my_date = Carbon\Carbon::parse($request->date_me);
    //$my_date = Carbon\Carbon::createFromFormat('m-d-Y',$request->date_me);

    //$my_date = $request->date_me->format('M d Y');
    //$my_date = Carbon\Carbon::createFromFormat('F d, Y',$request->date_me);
    //$my_date = Carbon\Carbon::($request->date_me);
    //dd('line 97 '. $my_date);
    //"Dates to: 12-09-2016 to 2016-12-09 00:00:00" with $request->date_me
    //"Dates to: 2016-09-12 00:00:00 to 2016-12-09 00:00:00" with $my_date
    //dd('my_date: '.$my_date.' day_to '.$day_two);
    //if ( Carbon\Carbon::today()->subDays(30) <= Carbon\Carbon::parse($request->date_me)  )
    //if ( $its_now->gt( $my_date) )
/*
    if( $day_five  == $my_date) {
      dd('Day 5 '.$day_five.' == '.$my_date.'  - '.$request->date_me );
    }elseif ($day_two  == $my_date) {
      dd('Day 2 '.$day_two.' == '.$my_date.'  - '.$request->date_me );
    }elseif ($day_due  == $my_date) {
      dd('Day Due '.$day_due.' == '.$my_date.'  - '.$request->date_me );
    }else{ dd('no match dates to: '.$day_two.' '.$my_date); }
*/

    }

    //dd($test_date. 'out');
    //$d = new DateTime($test_date);
    //$timestamp = $d->getTimestamp(); // Unix timestamp
    //$formatted_date = $d->format('Y-m-d'); // 2003-10-16
    //$formatted_date = Carbon\Carbon::parse($test_date);
    //dd($formatted_date);
    //if ($today->lt($formatted_date)) { dd($the_date);}
    //dd($request->date_me);
    //if($today->gt($test_date)){
      //dd($today);
      //dd($request->date_me);
    //}
    //dd($the_date);
    // dd($request->date_me);
    $input = $request->all();
    //dd($input);

    //$book->user_id = $request->user()->id; # <--- NEW LINE
    Task::create($input);
    Session::flash('flash_message', 'Task successfully added!');
    return redirect()->back();
  }

  public function show($id) {

    $task = Task::findOrFail($id);
    //dd($task);
    //return view('tasks.show');
    return view('tasks.show')->withTask($task);
  }

  public function edit($id) {

    $task = Task::findOrFail($id);
    return view('tasks.edit')->withTask($task);
    //return view('tasks.edit');

  }

  public function update($id, Request $request) {

    $task = Task::findOrFail($id);
    $this->validate($request, [
                                'title' => 'required',
                                'description' => 'required'
                             ]);

    $input = $request->all();
    $task->fill($input)->save();
    Session::flash('flash_message', 'Task successfully updated!');
    return redirect()->back();

   }

   public function destroy($id){

    $task = Task::findOrFail($id);
    $task->delete();
    Session::flash('flash_message', 'Task successfully deleted!');
    return redirect()->route('tasks.index');

   }

   public function sendMail()
   {
       $to_email = 'a_car11@yahoo.com';

       Mail::to($to_email)->send(new MyReminder);
       return "E-mail has been sent Successfully to you!";
       //Mail::to('batman@batcave.io')->send(new KryptoniteFound);
   }

   public function sendEmailReminder(Request $request, $id) {
        //$user = User::findOrFail($id);
        $user = "Andrey Test";

        $user->email = "a_car11@yahoo.com";
        $user->name = "ACAR11";

        Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
            $m->from('hello@app.com', 'My Application Email Reminder');

            $m->to($user->email, $user->name)->subject('Your Reminder!');
        });
   }

}
