<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Preference",
 *     type="object",
 *     title="Preference",
 *     description="User Preferences Model",
 *     required={"user_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="source", type="string", example="NewsAPI"),
 *     @OA\Property(property="category", type="string", example="General"),
 *     @OA\Property(property="author", type="string", example="Test"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-02T12:05:28Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-02T12:05:28Z")
 * )
 * @method static updateOrCreate(array $array, array $param)
 * @method static where(string $string, int|string|null $id)
 */
class Preference extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'source',
        'category',
        'author',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
