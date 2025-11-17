<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Store extends Model
{
    use HasFactory, Sortable;

    /**
     * 保存可能なカラム
     */
    protected $fillable = [
        'name',          // 店舗名
        'description',   // 店舗の紹介文
        'address',       // 住所
        'image',         // 店舗画像
        'category_id',   // カテゴリーID
    ];

    /** レビューとのリレーション */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /** お気に入りユーザーとの中間リレーション */
    public function favorited_users()
    {
        return $this->belongsToMany(User::class, 'favorite_store_user', 'store_id', 'user_id')->withTimestamps();
    }

    /** 予約とのリレーション */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /** カテゴリーとのリレーション */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 画像 URL を取得
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('img/' . $this->image) : asset('img/default.JPG');
    }
}
