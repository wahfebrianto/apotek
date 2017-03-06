<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Obat extends Model
{
  use SoftDeletes;
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'obat';
  protected $primarykey = 'id';
  protected $dates = ['deleted_at'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'nama', 'id_pamakologi', 'dosis', 'bentuk_sediaan', 'harga_jual', 'keterangan'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'id'
  ];
}
