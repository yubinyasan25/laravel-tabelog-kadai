<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Store extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'name',             // 店舗名
        'description',      // 店舗の紹介文
        'address',          // 住所
        'category_id',      // カテゴリID（例：ラーメン、味噌カツなど）
        'image',            // 店舗画像
        'recommend_flag',   // おすすめ店舗フラグ
    ];

    /** カテゴリとのリレーション */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /** レビューとのリレーション */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /** お気に入りユーザーとの中間リレーション */
    public function favorited_users()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    /** 予約とのリレーション */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
