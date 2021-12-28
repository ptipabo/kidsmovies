<?php

namespace App\Entities;

class Song extends BaseEntity {
    private $movie;  
    private $title;
    private $video;
    private $censored;
    private $order;

    /**
     * @return int
     */
    public function getMovie(): int
    {
        return $this->movie;
    }

    /**
     * @param int $movie
     */
    public function setMovie(int $movie): void
    {
        $this->movie = $movie;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getVideo(): string
    {
        return $this->video;
    }

    /**
     * @param string $video
     */
    public function setVideo(string $video): void
    {
        $this->video = $video;
    }

    /**
     * @return bool
     */
    public function isCensored(): bool
    {
        return $this->censored;
    }

    /**
     * @param int $censored
     */
    public function setCensored(bool $censored): void
    {
        $this->censored = $censored;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @param int $order
     */
    public function setOrder(int $order): void
    {
        $this->order = $order;
    }
}