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
    protected $fillable = ['name', 'slug', 'alias', 'bg_color', 'is_hot', 'status', 'icon_url', 'display_order', 'description', 'home_style', 'meta_id', 'menu_ngang', 'menu_doc', 'icon_mau', 'is_hover', 'banner_menu', 'price_sort', 'icon_km', 'phi_dich_vu'];

    public function cates()
    {
        return $this->hasMany('App\Models\Cate', 'loai_id');
    }

    public function banners()
    {
        return $this->hasMany('App\Models\Banner', 'object_id')->where('object_type', 1);
    }

}
