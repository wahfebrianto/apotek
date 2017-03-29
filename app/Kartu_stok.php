<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kartu_stok extends Model
{
  use SoftDeletes;
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'kartu_stok';
  protected $primarykey = ['id', 'id_obat'];
  protected $dates = ['deleted_at'];
  public $incrementing = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'id_obat', 'harga_beli', 'tanggal_beli', 'expired_date', 'stok', 'keterangan'
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
