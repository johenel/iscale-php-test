<?php

namespace App\Models;

interface ModelInterface 
{
	public function setId(int $id): self;

    public function getId(): int;

    public function setCreatedAt(string $createdAt): self;

    public function getCreatedAt(): string;
}