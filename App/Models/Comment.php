<?php

namespace App\Models;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fields = [
        'id',
        'title',
        'body',
        'news_id',
        'created_at'
    ];
    protected int $newsId;

    public function setNewsId(int $newsId): self
    {
        $this->newsId = $newsId;

        return $this;
    }

    public function getNewsId(): int
    {
        return $this->newsId;
    }
}