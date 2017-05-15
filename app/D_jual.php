<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class D_jual extends Model
{
  use SoftDeletes;
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'd_jual';
  protected $primarykey = ['no_nota', 'id_obat'];
  protected $dates = ['deleted_at'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'no_nota', 'id_obat', 'jumlah', 'harga_jual', 'subtotal_jual', 'diskon', 'subtotal_jual_setelah_diskon', 'keterangan'
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
      return $this->belongsTo('App\Obat','id_obat');
  }

  public function h_jual()
  {
      return $this->belongsTo('App\H_jual','no_nota','no_nota');
  }
}
