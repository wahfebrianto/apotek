<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class H_beli extends Model
{
  use SoftDeletes;
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'h_beli';
  protected $primarykey = 'no_nota';
  protected $dates = ['deleted_at'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'no_nota', 'id_pbf', 'id_pegawai', 'tanggal_pesan', 'total', 'diskon', 'pajak', 'grand_total', 'status_lunas', 'tanggal_jatuh_tempo', 'keterangan'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [

  ];

  public function d_beli()
  {
      return $this->hasMany('App\D_beli');
  }

  public function user()
  {
      return $this->belongsTo('App\User')
  }

  public function pbf()
  {
      return $this->belongsTo('App\Pbf')
  }
}
