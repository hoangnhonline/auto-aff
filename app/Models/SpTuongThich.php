<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class SpTuongThich extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sp_tuongthich';	

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
    protected $fillable = ['sp_1', 'sp_2', 'cate_id'];
  
}
