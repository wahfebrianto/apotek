<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
  use SoftDeletes;
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'log';
  protected $primarykey = 'id';
  protected $dates = ['deleted_at'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'id_obat', 'keterangan'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'id'
  ];

  public function obat()
  {
      return $this->belongsTo('App\Obat','id_obat');
  }
}
