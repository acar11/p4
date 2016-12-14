<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use App\Task;
use App\Users_timezone_log;
use App\Tag;
use Mail;
use App\Mail\MyReminder;
use Auth;
use Carbon;


#use App\Http\Controllers\Users_timezone_log;

class TasksController extends Controller
{

  /**
  * GET
  */
  public function index(Request $request)
  {

    $user = $request->user();
    //dd($user->id);
    $user = Auth::user();
    //dd($user->id);
    if($user) {

        $tasks = Task::where('user_id', '=', $user->id)->orderBy('id','DESC')->get();

        # Get the IP for the user.
      //  $all_ips = DB::table('users_timezone_log')->select('users_timezone_log.user_ip')
      //            ->join('tasks','tasks.user_id','=','users_timezone_log.user_id')
      //            ->where('users_timezone_log.user_id', $user->id)->pluck('user_ip');
      //  dd($all_ips);
        # Get existing entered IPs to prevent duplicates
        # If the IP for the user isnt in the DB log it.
        # For now I am setting all the user to have America/New_York timezone.
    //    $existingIps = Users_timezone_log::all()->keyBy('user_ip')->toArray();
        //var_dump($existingIps);
        //dd($existingIps);

        //if(!array_key_exists(intval($all_ips[0]),$existingIps)) {
/*
        if(!array_key_exists($all_ips[0],$existingIps)) {
           //dd($existingIps);
          DB::table('users_timezone_log')->insert([
            'created_at' => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
            'user_id'    => $user->id,
            'zone'       => 'America/New_York',
            'user_ip'    => \Request::ip(),
          ]);
        }
  */
    }
    else {
      //dd($user->id);
        $tasks = [];
    }

    // assuming I alredy have all the logic for the days due here:
    return view('tasks.index')->with([
        'tasks' => $tasks,
        //'my_dates' => $my_dates,
        //'day_f' => 0
    ]);
  }

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
    // ...

    if($request->date_me) {

      $my_date = Carbon\Carbon::parse($request->date_me);

    }

    $input = $request->all();
    //dd($input);

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

    # Get the task to be deleted
    $task = Task::findOrFail($id);
    #$task = Task::find($id);
    /*
    public function tasks()
    {
      return $this->belongsToMany('App\Task')->withTimestamps();
    }
    */
  //  dd($task->users_timezone_log());
    # First remove any tags associated with this task
  //  dd($task->tags());

//    if($task->tags()) {
//      $task->tags()->detach();
//    }
  //  if($task->users_timezone_log()) {
    //  $task->users_timezone_log()->detach();
  //    $task->tags()->detach();
  //  }

    // Delete all of the data that have the same ids...
    //Users_timezone_log::where("user_id", $id)->delete();
    //DB::table('users_timezone_log')->where('user_id', '=', $id)->delete();
    $task->delete();

    Session::flash('flash_message', 'Task successfully deleted!');
    return redirect()->route('tasks.index');

   }

   public function sendMail()
   {
       $to_email = 'a_car11@yahoo.com';

       Mail::to($to_email)->send(new MyReminder);
       return "E-mail has been sent Successfully to you!";
       //Mail::to('acar11@gmail.com')->send(new ReminderEmailFound);
   }

   public function sendEmailReminder(Request $request, $id) {
        //$user = User::findOrFail($id);
        $user = "Andrey Test";

        $user->email = "acar11@gmail.com";
        $user->name = "Andrey";

        Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
            $m->from('hello@app.com', 'My Application Email Reminder');

            $m->to($user->email, $user->name)->subject('Your Reminder!');
        });
   }

}
