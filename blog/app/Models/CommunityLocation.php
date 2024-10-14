<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityLocation extends Model
{
    use HasFactory;
    // Specify the table name if it differs from the default (plural form of model name)
    protected $table = 'community_location';

    // Disable default incrementing and primary key settings since you have a composite key
    public $incrementing = false;
    protected $primaryKey = ['community_id', 'country'];

    // Define the fillable attributes to allow mass assignment
    protected $fillable = ['community_id', 'country'];

    // Define the relationship with the Community model
    public function community()
    {
        return $this->belongsTo(Community::class, 'community_id');
    }
}
