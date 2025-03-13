<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Post extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $guarded = ['id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the color associated with the post status.
     */
    protected function statusColor(): Attribute
    {
        return Attribute::get(function () {
            return match ($this->status) {
                'draft' => 'gray',
                'published' => 'green',
                'scheduled' => 'yellow',
                default => 'gray',
            };
        });
    }
}
