<?php namespace App\Models;

use App\Events\PersonCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'description',
    ];

    protected static function booted()
    {
        static::created(function ($person) {
            event(new PersonCreated($person));
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
