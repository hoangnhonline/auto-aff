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
    protected $fillable = ['name', 'slug', 'alias', 'loai_id', 'bg_color', 'is_hot', 'status', 'icon_url', 'display_order', 'description', 'home_style', 'meta_id', 'created_user', 'updated_user', 'menu_ngang', 'menu_doc'];

    public function sanPham()
    {
        return $this->hasMany('App\Models\SanPham', 'cate_id');
    }

    public function banners()
    {
        return $this->hasMany('App\Models\Banner', 'object_id')->where('object_type', 2);
    }
}
