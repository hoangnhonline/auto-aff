<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class LoaiSp extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'loai_sp';	

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
    protected $fillable = ['name', 'slug', 'alias', 'description', 'display_order', 'status', 'created_user', 'updated_user', 'meta_id', 'type'];

    public function cates()
    {
        return $this->hasMany('App\Models\Cate', 'loai_id');
    }
}
