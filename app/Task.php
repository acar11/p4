<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  /**
   * Fillable fields
   *
   * @var array
   */
  protected $fillable = [
      'title',
      'description',
      'user_id',
      'user_email',
      'date_me'

  ];

  public function user() {
    return $this->belongsTo('App\User');
  }

  public function users_timezone_log() {
      return $this->belongsTo('App\Users_timezone_log');
   }

}
