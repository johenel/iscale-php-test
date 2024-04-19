<?php

namespace App\Utilities;

use App\Models\Comment;

class CommentManager extends Manager
{
    public function setModel(): void
    {
        $this->model = new Comment();
    }

    public function listComments(): array
    {
        return $this->model->select()->get();
    }

    public function addCommentForNews(string $body, int $newsId): int
    {
        return $this->model->insert([
            'body' => $body,
            'news_id' => $newsId,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function deleteComment($id): bool
    {
        return $this->model->delete($id);
    }
}