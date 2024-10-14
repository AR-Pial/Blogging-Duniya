<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; 
class Community extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'name', 'short_title', 'visibility', 'description', 'terms_condition', 'image', 'owner_id', 'created_by'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // public function members()
    // {
    //     return $this->belongsToMany(User::class, 'community_user', 'community_id', 'user_id')->withTimestamps();
    // }
    public function members()
    {
        return $this->belongsToMany(User::class, 'community_user');
    }

    public function getTotalMembers()
    {
        return $this->members()->count() + 1;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_community');
    }

    public function isMember(User $user)
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }
    public function locations()
    {
        return $this->hasMany(CommunityLocation::class, 'community_id');
    }
    
    public function getLocations()
    {
        return DB::table('community_location')
            ->where('community_id', $this->id)
            ->pluck('country')
            ->toArray();
    }
}
