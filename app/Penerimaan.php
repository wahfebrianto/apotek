<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penerimaan extends Model
{
  use SoftDeletes;
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'penerimaan';
  protected $primarykey = 'id';
  protected $dates = ['deleted_at'];
  protected $guarded = ['id'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'no_nota', 'id_obat', 'jumlah', 'tangal_expired', 'tanggal_terima', 'keterangan'
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

  public function h_beli()
  {
      return $this->belongsTo('App\H_beli','no_nota','no_nota');
  }
}
