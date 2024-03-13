<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // 대량할당
    protected $fillable = ['body', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    } 
    protected $with = ['user'];
    protected $withCount = ['comments'];
    public function getRecentCommentsExistsAttribute()
    {
        // 최근 일주일 동안의 댓글이 있는지 확인합니다.
        $recentCommentsCount = $this->comments()
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
    
        return $recentCommentsCount > 0;
    }

    
}