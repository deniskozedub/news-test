<?php

namespace App\Models;

use App\Filters\Tags;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;

/**
 * App\Models\News
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property string $link
 * @property int $counter
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News query()
 * @method static \Illuminate\Database\Eloquent\Builder|News whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class News extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body','link'];
    protected $appends = ['counter'];


    public static function withFiltersOrNot()
    {
        return app(Pipeline::class)
            ->send(News::query())
            ->through(Tags::class)
            ->thenReturn()
            ->get();
    }
    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tag::class,'news_tag');
    }

    public function tagService(string $tags = null)
    {
        $update_tags  = array_filter(explode(',',$tags));
        if (!$update_tags){
            $this->tags()->detach();
        }else{
            $this->tags()->sync($update_tags);
        }
    }

    public function newsCounter()
    {
        return $this->increment('counter', 1);
    }
}
