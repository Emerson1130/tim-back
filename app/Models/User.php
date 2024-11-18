<?php

namespace App\Models;

use App\Models\Forum\Favorite;
use App\Models\Forum\ForumComment;
use App\Models\Forum\ForumCommentStatus;
use App\Models\Forum\TopicScore;
use App\Models\Security\Permission;
use App\Models\Security\UserLevel;
use App\Models\Society\Person;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'security_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'person_id',
        'forum_active',
        'level_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Lista de roles que um usuário possui
     *
     * @var array
     */
    public $roles = [];

    protected $appends = ['comments_count', 'blocked_comments_count'];

    protected function commentsCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->comments()
                ->whereHas('topic', function ($query) {
                    $query->where('forum_id', request()->get('forum_id'));
                })
                ->count(),
        );
    }

    protected function blockedCommentsCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->comments()
                ->where('status_id', ForumCommentStatus::STATUS_BLOCKED)
                ->whereHas('topic', function ($query) {
                    $query->where('forum_id', request()->get('forum_id'));
                })
                ->count(),
        );
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function userLevel(): BelongsTo
    {
        return $this->belongsTo(UserLevel::class, 'level_id');
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ForumComment::class, 'author_id');
    }

    public function scores(): HasMany
    {
        return $this->hasMany(TopicScore::class, 'author_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
