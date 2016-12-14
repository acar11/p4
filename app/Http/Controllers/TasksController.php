<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use App\Task;
use App\User;
#use App\Users_timezone_log;
#use App\Tag;
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
        # Get the timezone for the user.
        $get_timezone = DB::table('users')->select('timezone')
                  ->where('id', $user->id)->pluck('timezone');
        //dd($all_ips);
        //var_dump($get_timezone);

        # Get existing entered IPs to prevent duplicates
        # For now I am setting all the user to have America/New_York timezone.
        #$existingIps = Users_timezone_log::all()->keyBy('user_ip')->toArray();
        #$existingIps = User::all()->keyBy('user_ip')->toArray();
        $existing_timezone = User::all()->keyBy('timezone')->toArray();
        //dd($existing_timezone);

        # If the timezone for the user isnt in the DB set it.
        # Setting to int justin case the we have null
        if(!array_key_exists(intval($get_timezone[0]),$existing_timezone)) {
          // dd($existingIps);
          DB::table('users')
                ->where('id', $user->id)  // find  user by their id
                ->update(array('timezone' => 'America/New_York',
                                'user_ip' => \Request::ip(),
                          ));  // update the record in the DB.
        }

    }
    else {
      //dd($user->id);
        $tasks = [];
    }

    // Assuming I alredy have all the logic for the tasks here:
    return view('tasks.index')->with([
        'tasks' => $tasks,
        'send_user_id' => $user->id,
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

    // Delete all of the data that have the same ids...
    //DB::table('tasks')->where('user_id', '=', $id)->delete();
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
