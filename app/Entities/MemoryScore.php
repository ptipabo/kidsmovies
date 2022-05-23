<?php

namespace App\Entities;

use \Datetime;

class MemoryScore extends BaseEntity {
    private $user;  
    private $date;
    private $score;
    private $numberOfTurns;
    private $difficultyMode;
    private $numberOfPlayers;

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

    /**
     * @return Datetime
     */
    public function getDate(): Datetime
    {
        return $this->date;
    }

    /**
     * @param Datetime $date
     */
    public function setDate(Datetime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    /**
     * @return int
     */
    public function getNumberOfTurns(): int
    {
        return $this->numberOfTurns;
    }

    /**
     * @param int $numberOfTurns
     */
    public function setNumberOfTurns(int $numberOfTurns): void
    {
        $this->numberOfTurns = $numberOfTurns;
    }

    /**
     * @return int
     */
    public function getDifficultyMode(): int
    {
        return $this->difficultyMode;
    }

    /**
     * @param int $difficultyMode
     */
    public function setDifficultyMode(int $difficultyMode): void
    {
        $this->difficultyMode = $difficultyMode;
    }

    /**
     * @return int
     */
    public function getNumberOfPlayers(): int
    {
        return $this->numberOfPlayers;
    }

    /**
     * @param int $numberOfPlayers
     */
    public function setNumberOfPlayers(int $numberOfPlayers): void
    {
        $this->numberOfPlayers = $numberOfPlayers;
    }
}