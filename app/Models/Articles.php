<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Articles extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'articles';

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
    protected $fillable = ['title', 'slug', 'alias', 'cate_id', 'is_hot', 'status', 'display_order', 'description', 'image_url', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'custom_text'];
    
}
