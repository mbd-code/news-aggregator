<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use OpenApi\Annotations as OA;

/**
 *
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $author
 * @property string $source
 * @property string|null $category
 * @property string|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|Article newModelQuery()
 * @method static Builder<static>|Article newQuery()
 * @method static Builder<static>|Article query()
 * @method static Builder<static>|Article whereAuthor($value)
 * @method static Builder<static>|Article whereCategory($value)
 * @method static Builder<static>|Article whereContent($value)
 * @method static Builder<static>|Article whereCreatedAt($value)
 * @method static Builder<static>|Article whereId($value)
 * @method static Builder<static>|Article wherePublishedAt($value)
 * @method static Builder<static>|Article whereSource($value)
 * @method static Builder<static>|Article whereTitle($value)
 * @method static Builder<static>|Article whereUpdatedAt($value)
 * @mixin \Eloquent
 */



/**
 * @OA\Schema(
 *     schema="Article",
 *     type="object",
 *     title="Article",
 *     description="Article Model",
 *     required={"title", "content", "source", "published_at"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Example Article Title"),
 *     @OA\Property(property="content", type="string", example="This is the content of the article."),
 *     @OA\Property(property="author", type="string", example="Muzaffer DOGAN"),
 *     @OA\Property(property="source", type="string", example="NewsAPI"),
 *     @OA\Property(property="category", type="string", example="General"),
 *     @OA\Property(property="published_at", type="string", format="date-time", example="2024-11-02T12:05:28Z"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-02T12:05:28Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-02T12:05:28Z"),
 * )
 * @method static updateOrCreate(array $array, array $array1)
 * @method static create(array $validated)
 */
class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'author',
        'source',
        'category',
        'published_at',
    ];
}
