<?php

class BowlingGame
{
    /**
     * @var array
     */
    protected $rolls = [];

    /**
     * @param $pins
     */
    public function roll($pins)
    {
        $this->guardAgainstInvalidRoll($pins);
        $this->rolls[] = $pins;
    }

    /**
     * @return int
     */
    public function score()
    {
        $score = 0;
        $roll = 0;

        for ($frame = 1; $frame <= 10; $frame++) {
            if ($this->isStrike($roll)) {
                $score += 10 + $this->strikeBonus($roll);
                $roll += 1;
            }
            else if ($this->isSpare($roll)) {
                $score += 10 + $this->spareBonus($roll);
                $roll += 2;
            }
            else {
                $score += $this->getDefaultFrameScore($roll);
                $roll += 2;
            }
        }

        return $score;
    }

    /**
     * @param $roll
     * @return bool
     */
    private function isSpare($roll): bool
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1] == 10;
    }

    /**
     * @param $roll
     * @return
     */
    private function getDefaultFrameScore($roll)
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1];
    }

    /**
     * @param $roll
     * @return bool
     */
    private function isStrike($roll): bool
    {
        return $this->rolls[$roll] == 10;
    }

    /**
     * @param $roll
     * @return mixed
     */
    private function strikeBonus($roll) {
        return $this->rolls[$roll + 1] + $this->rolls[$roll + 2];
    }

    /**
     * @param $roll
     * @return mixed
     */
    private function spareBonus($roll)
    {
        return $this->rolls[$roll + 2];
    }

    /**
     * @param $pins
     */
    private function guardAgainstInvalidRoll($pins): void
    {
        if ($pins < 0) {
            throw new InvalidArgumentException();
        }
    }
}
