<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProductEvent extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'product_event';	

	 /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['event_id', 'sp_id', 'so_luong', 'da_ban', 'con_lai', 'so_luong_tam', 'status', 'status', 'created_user', 'updated_user', 'display_order'];

}
