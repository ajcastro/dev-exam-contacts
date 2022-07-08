<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Schema;

trait ModelFields
{
    public static function getModelVisibleFields()
    {
        $visible = (new static)->getVisible();

        return !empty($visible) ? $visible : Schema::getColumnListing((new static)->getTable());
    }
}
