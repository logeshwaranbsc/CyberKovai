<?php
declare(strict_types=1);

namespace CyberKovai\Security;

use RuntimeException;

/**
 * Thrown when persistent 2FA security storage is unreadable or malformed.
 * Authentication flows must fail closed when this exception is encountered.
 */
class CorruptedStorageException extends RuntimeException
{
}

