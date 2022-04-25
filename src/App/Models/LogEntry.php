<?php

namespace Console\App\Models;

class LogEntry
{
    private string $path;
    private int $statusCode;
    private string $bytes;
    private string $agent;

    /**
     * @return string
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function statusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return int
     */
    public function bytes(): int
    {
        return $this->bytes;
    }

    /**
     * @return string
     */
    public function agent(): string
    {
        return $this->agent;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath(string $path): LogEntry
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @param int $statusCode
     * @return $this
     */
    public function setStatusCode(int $statusCode): LogEntry
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param int $bytes
     * @return $this
     */
    public function setBytes(int $bytes): LogEntry
    {
        $this->bytes = $bytes;
        return $this;
    }

    /**
     * @param string $agent
     * @return $this
     */
    public function setAgent(string $agent): LogEntry
    {
        $this->agent = $agent;
        return $this;
    }
}