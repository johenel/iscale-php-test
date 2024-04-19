<?php

namespace App\Utilities;

use App\Models\Model;
use App\Traits\Instanceable;

abstract class Manager
{
    use Instanceable;

    protected Model $model;

    protected abstract function setModel(): void;
}