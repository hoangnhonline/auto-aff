<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class HoverInfo extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'hover_info';	

	 /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['text_hien_thi', 'str_thuoctinh_id', 'display_order', 'loai_id'];

}
