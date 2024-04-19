<?php

namespace App\Utilities;

use App\Models\Model;
use App\Models\News;

class NewsManager extends Manager
{
    protected function setModel(): void
    {
       $this->model = new News();
    }

    public function listNews(): array
    {
        return $this->model->select()->get();
    }

    public function addNews(string $title, string $body): int
    {
        return  $this->model->insert(['title' => $title, 'body' => $body]);
    }

    public function deleteNews($newsId): bool
    {
        return $this->model->delete($newsId);
    }
}