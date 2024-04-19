<?php

namespace App\Models;

use App\Services\DatabaseService;

class Model extends DatabaseService implements ModelInterface
{
    protected int $id;
    protected string $title;
    protected string $body;
    protected string $createdAt;

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}