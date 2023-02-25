<?php

namespace Src\Utils;

class Filesystem extends Singleton
{
    private const DB_DIR = 'db';

    /**
     * Read data from file
     * @param string $fileName
     * @return string
     */
    public function read(string $fileName): string
    {
        return file_get_contents($this->genPath($fileName));
    }

    /**
     * Write data to file
     * @param string $filename
     * @param string $context
     * @return string
     */
    public function write(string $filename, string $context): string
    {
        return file_put_contents($this->genPath($filename), $context);
    }

    /**
     * Generate file path
     * @param string $fileName
     * @return string
     */
    private function genPath(string $fileName): string
    {
        return self::DB_DIR . '/' . $fileName . '.json';
    }
}