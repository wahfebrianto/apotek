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
  protected $guarded = ['id'];
  public $incrementing = false;

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

  public function pamakologi()
  {
      return $this->belongsTo('App\Pamakologi','id_pamakologi');
  }

  public function log()
  {
      return $this->hasMany('App\Log');
  }

  public function kartu_stok()
  {
      return $this->hasMany('App\Kartu_stok');
  }

  public function d_resep()
  {
      return $this->belongsTo('App\D_resep');
  }

  public function d_jual()
  {
      return $this->belongsTo('App\D_jual');
  }

  public function d_beli()
  {
      return $this->belongsTo('App\D_beli');
  }
}
