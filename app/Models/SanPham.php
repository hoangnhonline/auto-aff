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
    protected $fillable = ['ma_sp', 'name', 'name_extend', 'alias', 'alias_extend', 'slug', 'slug_extend', 'thumbnail_id', 'is_hot', 'is_sale', 'price', 'price_sale', 'loai_id', 'cate_id', 'mo_ta', 'sp_phukien', 'xuat_xu', 'khuyen_mai', 'chi_tiet', 'bao_hanh', 'so_luong_ton', 'sale_percent', 'so_luong_ban', 'status', 'created_user', 'updated_user', 'meta_id', 'views', 'so_lan_mua', 'sp_tuongtu', 'display_order', 'is_primary', 'name_primary', 'color_id','can_nang', 'chieu_dai', 'chieu_cao', 'chieu_rong', 'con_hang', 'khe_ram', 'pro_style', 'image_pro', 'is_event','so_luong_tam'];
    
}
