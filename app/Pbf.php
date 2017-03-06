<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pbf extends Model
{
  use SoftDeletes;
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'pbf';
  protected $primarykey = 'id';
  protected $dates = ['deleted_at'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'nama', 'alamat', 'telepon', 'nama_cp', 'telp_cp', 'tergolong_pajak', 'keterangan'
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
