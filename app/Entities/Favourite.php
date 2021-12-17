<?php

namespace App\Entities;

class Favourite {
    private $id;
    private $song;
    private $user;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getSong(): int
    {
        return $this->song;
    }

    /**
     * @param int $song
     */
    public function setSong(int $song): void
    {
        $this->song = $song;
    }

    /**
     * @return int
     */
    public function getUser(): int
    {
        return $this->user;
    }

    /**
     * @param int $user
     */
    public function setUser(int $user): void
    {
        $this->user = $user;
    }
}