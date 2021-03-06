<?php

namespace Console\App\Helpers;

class FileHelper
{
    public const MAX_BUFFER_SIZE = 16 * 1024 * 1024;

    /**
     * Reads file in chunks of less than $chunkSize bytes (integer number of lines)
     * Every chunk is then passed into $callback object as an array of strings
     * @param string $filePath
     * @param callable $callback
     * @param int $chunkSize
     * @return void
     */
    public static function readInChunks(string $filePath, callable $callback, int $chunkSize = self::MAX_BUFFER_SIZE): void
    {
        $size = filesize($filePath);
        $chunkNumber = 0;
        $leftover = '';
        while ($chunkSize * $chunkNumber < $size) {
            $chunk = explode(PHP_EOL, file_get_contents($filePath, false, null, $chunkNumber * $chunkSize, $chunkSize));
            if (!empty($leftover)) {
                $chunk[0] = $leftover . $chunk[0];
            }
            $leftover = array_pop($chunk);
            $callback($chunk);
            $chunkNumber++;
        }
        if (!empty($leftover)) {
            $callback([$leftover]);
        }
    }

    /**
     * @param $filename
     * @return bool
     */
    public static function exists($filename): bool
    {
        return file_exists($filename);
    }

    /**
     * @param $filename
     * @return int
     */
    public static function size($filename): int
    {
        return filesize($filename);
    }
}
