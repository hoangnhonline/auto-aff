<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CrawlerUrl extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'crawler_url';	

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
    protected $fillable = ['loai_id', 'ads_url', 'time_start', 'time_end', 'object_id', 'object_type', 'type', 'display_order', 'status', 'created_user', 'updated_user'];
    
}
