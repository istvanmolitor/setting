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
        'setting_group_id',
        'label',
        'type',
        'name',
        'value',
        'default_value',
        'description',
    ];

    public $timestamps = true;

    public function settingGroup(): BelongsTo {
        return $this->belongsTo(SettingGroup::class);
    }
}
