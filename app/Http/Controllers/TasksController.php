<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Task;
use Mail;
use App\Mail\MyReminder;

class TasksController extends Controller
{
  public function index() {

    $tasks = Task::all();
    return view('tasks.index')->withTasks($tasks);
    //return view('tasks.index');

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

    $input = $request->all();
    Task::create($input);
    Session::flash('flash_message', 'Task successfully added!');
    return redirect()->back();
  }

  public function show($id) {

    $task = Task::findOrFail($id);
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
    Session::flash('flash_message', 'Task successfully added!');
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
