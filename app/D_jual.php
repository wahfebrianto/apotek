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
  protected $primarykey = ['no_nota', 'id_obat', 'harga_beli'];
  protected $dates = ['deleted_at'];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'no_nota', 'id_obat', 'jumlah', 'harga_jual', 'harga_beli', 'subtotal_jual', 'subtotal_beli', 'diskon', 'subtotal_jual_setelah_diskon', 'keterangan'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [

  ];
}
