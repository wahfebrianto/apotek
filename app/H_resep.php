<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class H_resep extends Model
{
  use SoftDeletes;
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'h_resep';
  protected $primarykey = ['no_nota', 'id_racikan'];
  protected $dates = ['deleted_at'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'no_nota', 'id_racikan', 'nama_racikan', 'bentuk_sediaan', 'total', 'jumlah', 'biaya_kemasan'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [

  ];
}
