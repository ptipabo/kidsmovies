<?php

namespace App\Entities;

class Character extends BaseEntity {
    private $movie;  
    private $name;
    private $img;
    private $desc;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getImg(): string
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg(string $img): void
    {
        $this->img = $img;
    }

    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->desc;
    }

    /**
     * @param string $desc
     */
    public function setDesc(string $desc): void
    {
        $this->desc = $desc;
    }
}