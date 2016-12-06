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
      'user_email'

  ];

  public function user() {
    return $this->belongsTo('App\User');
  }

}
