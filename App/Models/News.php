<?php

namespace App\Models;

class News extends Model
{
    protected $table = 'news';
    protected $fields = [
        'id',
        'title',
        'body',
        'created_at'
    ];

    protected $relationships = [
        'comments'
    ];

    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}