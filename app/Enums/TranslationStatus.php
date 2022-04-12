<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Approved()
 * @method static static Pending()
 */
final class TranslationStatus extends Enum
{
    const Approved = 0;
    const Pending = 1;
}
