<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Cate extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cate';	

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
    protected $fillable = ['name', 'slug', 'alias', 'status', 'description', 'menu_doc', 'loai_id', 'meta_id', 'is_hot', 'display_order', 'created_user', 'updated_user', 'type'];

    public function sanPham()
    {
        return $this->hasMany('App\Models\SanPham', 'cate_id');
    }

    public function banners()
    {
        return $this->hasMany('App\Models\Banner', 'object_id')->where('object_type', 2);
    }
}
