<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users_timezone_log extends Model
{
  # I guess Laravel can't determine the plural form my table name.
   public $table = "users_timezone_log";
  # Define a one-to-many relationship.
    #return $this->hasMany('App\Task');
}
