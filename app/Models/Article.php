<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['id','featured', 'title', 'url', 'imageUrl', 'newsSite', 'summary', 'publishedAt'];

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Relationships
     */
    public function launches()
    {
        return $this->belongsToMany(Launche::class, 'article_launches', 'article_id', 'launch_id');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class,'article_events', 'article_id', 'event_id');
    }

    public function rules() {
        return [
            'featured' => 'required',
            'title' => 'required',
            'url' => 'required',
            'imageUrl' => 'required|file|mimes:png,jpeg,jpg',
            'newsSite' => 'required',
            'summary' => 'required',
            'publishedAt' => 'required'
        ];
    }
}
