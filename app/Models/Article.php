<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['featured', 'title', 'url', 'imageUrl', 'newsSite', 'summary', 'publishedAt', 'launche_id', 'event_id'];

    /**
     * Relationships
     */
    public function launche()
    {
        return $this->belongsTo(Launche::class,'launche_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class,'event_id');
    }

    public function rules() {
        return [
            'featured' => 'required',
            'title' => 'required',
            'url' => 'required',
            'imageUrl' => 'required',
            'newsSite' => 'required',
            'summary' => 'required',
            'publishedAt' => 'required',
            'launche_id' => 'exists:launches,id',
            'event_id' => 'exists:events,id'
        ];
    }
}
