<?php

namespace App\Services\Ai;

use RuntimeException;

/**
 * Dilempar ketika limit penggunaan AI telah tercapai.
 */
class AiUsageLimitExceededException extends RuntimeException
{
}