<?php

declare(strict_types=1);

namespace Molitor\Setting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    protected $table = 'settings';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'value',
    ];

    public $timestamps = true;
}
