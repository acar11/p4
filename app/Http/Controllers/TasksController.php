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

    return view('tasks.index')->with([
        'tasks' => $tasks
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
    $the_date = $mytime->toDateString();
    //dd($the_date);

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
