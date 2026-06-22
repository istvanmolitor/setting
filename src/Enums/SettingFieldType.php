<?php

namespace Molitor\Setting\Enums;

enum SettingFieldType: string
{
    case Text     = 'text';
    case Textarea = 'textarea';
    case Number   = 'number';
    case Boolean  = 'boolean';
    case Select   = 'select';
    case Image    = 'image';
    case File     = 'file';
    case Color    = 'color';
    case Email    = 'email';
    case Url      = 'url';
}
