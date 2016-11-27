<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class SanPham extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'san_pham';

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
    protected $fillable = [
            'ma_sp', 
            'name', 
            'alias', 
            'slug', 
            'thumbnail_id', 
            'thumbnail_url', 
            'is_hot', 
            'is_sale', 
            'price', 
            'price_sale', 
            'loai_id', 
            'cate_id', 
            'mo_ta', 
            'xuat_xu', 
            'chi_tiet', 
            'bao_hanh', 
            'so_luong_ton', 
            'sale_percent', 
            'status', 
            'created_user', 
            'updated_user', 
            'meta_id', 
            'views', 
            'display_order',
            'con_hang',
            'site_id',
            'type',
            'is_aff',
            'url',
            'aff_price',
            'aff_price_old',
            'aff_sale_percent'
            ];
    
}
