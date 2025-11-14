<?php

namespace Molitor\Setting\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SettingBeforeSaveEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $slug;

    /**
     * @var array
     */
    public array $data;

    /**
     * Create a new event instance.
     */
    public function __construct(string $slug, array $data)
    {
        $this->slug = $slug;
        $this->data = $data;
    }
}
