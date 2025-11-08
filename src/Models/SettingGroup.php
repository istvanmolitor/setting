<?php

declare(strict_types=1);

namespace Molitor\Setting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SettingGroup extends Model
{
    protected $table = 'setting_groups';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'icon',
        'slug',
    ];

    public $timestamps = true;

    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class, 'setting_group_id', 'id');
    }
}
