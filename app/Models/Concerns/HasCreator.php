<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Auth;
use App\Models\Contracts\TracksCreator;

trait HasCreator
{
    protected static function bootHasCreator(): void
    {
        static::creating(function ($model) {
            if (! $model instanceof TracksCreator) {
                return;
            }

            if (empty($model->created_by) && Auth::check()) {
                $model->created_by = Auth::id();
            }
        });
    }
}
