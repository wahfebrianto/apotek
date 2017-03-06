<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class D_resep extends Model
{
  use SoftDeletes;
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'd_resep';
  protected $primarykey = ['no_nota', 'id_racikan', 'id_obat', 'harga_beli'];
  protected $dates = ['deleted_at'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'no_nota', 'id_racikan', 'id_obat', 'jumlah', 'harga_jual', 'harga_beli', 'subtotal_jual', 'subtotal_beli', 'keterangan'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [

  ];

  public function obat()
  {
      return $this->hasOne('App\Obat');
  }

  public function h_resep()
  {
      return $this->belongsTo('App\H_resep')
  }
}
