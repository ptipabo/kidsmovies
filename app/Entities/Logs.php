<?php

namespace App\Entities;

use DateTime;

class Logs extends BaseEntity {
    const VIDEO_NOT_FOUND_EVENT = 1;
    
    /** int */
    private $eventType;
    /** string */
    private $message;
    /** Datetime */
    private $timestamp;

    /**
     * @return int
     */
    public function getEventType(): int
    {
        return $this->eventType;
    }

    /**
     * @param int $movie
     */
    public function setEventType(int $eventType): void
    {
        $this->eventType = $eventType;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param Datetime $timestamp
     */
    public function setTimestamp(DateTime $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return Datetime
     */
    public function getTimestamp(): DateTime
    {
        return $this->timestamp;
    }
}