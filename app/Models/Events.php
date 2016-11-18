<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Events extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'events';	

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
    protected $fillable = ['name', 'slug', 'status', 'small_banner', 'display_order', 'large_banner', 'description', 'meta_id', 'from_date', 'to_date', 'created_user', 'updated_user', 'the_le'];

    public function products()
    {
        return $this->hasMany('App\Models\ProductEvents', 'event_id');
    }
       
}
