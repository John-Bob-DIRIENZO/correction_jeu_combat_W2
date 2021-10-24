<?php

namespace App\Fram\Utils;

class Flash
{
    /**
     * Sets an escaped flash message
     * @param string $message
     */
    public static function setFlash(string $message): void
    {
        $_SESSION['flash'] = htmlspecialchars($message);
    }

    public static function hasFlash(): bool
    {
        return isset($_SESSION['flash']);
    }

    /**
     * Returns the flash messages if it exists and then, deletes it
     * @return string|void
     */
    public static function getFlash()
    {
        if (self::hasFlash()) {
            $message = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $message;
        }
    }
}