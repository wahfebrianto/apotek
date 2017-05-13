<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class H_jual extends Model
{
  use SoftDeletes;
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'h_jual';
  protected $primarykey = 'no_nota';
  protected $dates = ['deleted_at'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'no_nota', 'tgl', 'id_pegawai', 'total', 'diskon', 'grand_total', 'keterangan'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [

  ];

  public function d_jual()
  {
      return $this->hasMany('App\D_jual');
  }

  public function h_resep()
  {
      return $this->hasMany('App\H_resep');
  }

  public function user()
  {
      return $this->belongsTo('App\User','id_pegawai');
  }
}
