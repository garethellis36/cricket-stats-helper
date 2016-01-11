<?php
namespace Garethellis\CricketStatsHelper;

/**
 * Class CricketStatsHelper
 * @package Garethellis\CricketStatsHelper
 */
class CricketStatsHelper
{
    /**
     * @var int
     */
    private $ballsPerOver;

    /**
     * CricketStatsHelper constructor.
     *
     * @param int $ballsPerOver The number of balls per over to use in stats calculations
     */
    public function __construct($ballsPerOver = 6)
    {
        if (!is_int($ballsPerOver)) {
            throw new \InvalidArgumentException('$ballsPerOver must be of type int');
        }
        $this->ballsPerOver = $ballsPerOver;
    }

    /**
     * @return int
     */
    public function getBallsPerOver()
    {
        return $this->ballsPerOver;
    }

    /**
     * @param int $ballsPerOver
     */
    public function setBallsPerOver($ballsPerOver)
    {
        if (!is_int($ballsPerOver)) {
            throw new \InvalidArgumentException('$ballsPerOver must be of type int');
        }
        $this->ballsPerOver = $ballsPerOver;
    }


    /**
     * Converts from scorecard decimal notation to number of balls
     * e.g. 10.3 overs is 10 whole overs plus 3 balls, e.g. 63 balls
     *
     * @param mixed $overs The number of overs to convert. Can be int (e.g. 3), string (e.g. "3" or "3.2") or float (3.2)
     * @return float
     */
    public function convertOversToBalls($overs)
    {
        if (!is_numeric($overs)) {
            throw new \InvalidArgumentException('$overs must be int, numeric string or float');
        }
        $bits = explode(".", $overs);
        if (count($bits) == 1) {
            return (float)($overs * $this->ballsPerOver);
        }
        return (float)($bits[0] * $this->ballsPerOver) + $bits[1];
    }

    /**
     * Converts from number of balls to scorecard decimal notation
     *
     * @param $balls
     * @return float
     */
    public function convertBallsToOvers($balls)
    {
        $remainder = fmod($balls, $this->ballsPerOver);
        if ($remainder == 0) {
            return (float)($balls / $this->ballsPerOver);
        }
        $wholeOvers = floor($balls / $this->ballsPerOver);
        return (float)$wholeOvers + ($remainder / 10);
    }

    /**
     * Calculates batting average, a measure of how productive a batsman is at scoring runs
     *
     * Batting average in cricket is calculated by dividing the total number of runs scored by the number of times
     * the batsman was dismissed (number of innings minus not-outs)
     *
     * @param int $runs The total number of runs scored
     * @param int $innings The total number of innings
     * @param int $notOuts The total number of not-out innings
     * @return bool|float Returns batting average as float, or false if innings minus not-outs is zero
     */
    public function calculateBattingAverage($runs, $innings, $notOuts)
    {
        if (!is_int($runs)) {
            throw new \InvalidArgumentException('$runs must be of type int');
        }
        if (!is_int($innings)) {
            throw new \InvalidArgumentException('$innings must be of type int');
        }
        if (!is_int($notOuts)) {
            throw new \InvalidArgumentException('$notOuts must be of type int');
        }
        if ($notOuts > $innings) {
            throw new \InvalidArgumentException('$notOuts may not be greater than $innings');
        }
        $dismissals = $innings - $notOuts;
        if ($dismissals == 0) {
            return false;
        }
        return (float)$runs / $dismissals;
    }

    /**
     * Calculates bowling average, a measure of how good a bowler is at taking wickets vs. conceding runs
     *
     * Bowling average in cricket is calculated by dividing the total runs conceded by the number of wickets taken
     *
     * @param int $runs Number of runs conceded
     * @param int $wickets Number of wickets taken
     * @return bool|float Returns bowling average as a float, or false if no wickets taken
     */
    public function calculateBowlingAverage($runs, $wickets)
    {
        if (!is_int($runs)) {
            throw new \InvalidArgumentException('$runs must be of type int');
        }
        if (!is_int($wickets)) {
            throw new \InvalidArgumentException('$wickets must be of type int');
        }
        if ($wickets == 0) {
            return false;
        }
        return $runs / $wickets;
    }

    /**
     * Calculates bowling economy, a measure of how well a bowler restricts batsmen from scoring
     *
     * @param mixed $overs The number of overs bowled in scorecard notation, e.g. 10.3 for 10 overs and 3 balls
     * @param int $runs The number of runs conceded
     * @return bool|float Returns bowling economy as float, or false if zero overs bowled
     */
    public function calculateBowlingEconomy($overs, $runs)
    {
        if (!is_numeric($overs)) {
            throw new \InvalidArgumentException('$overs must be int, numeric string or float');
        }
        if (!is_int($runs)) {
            throw new \InvalidArgumentException('$runs must be of type int');
        }
        if ($overs == 0) {
            return false;
        }
        //we need overs in decimal form, e.g. 12.3 (12 overs & 3 balls) needs to be 12.5 (12 and a half)
        $overs = $this->convertBallsToDecimal($this->convertOversToBalls($overs));
        return (float)$runs / $overs;
    }

    /**
     * Convert from number of balls to a traditional decimal
     * e.g. 20 balls is 3.3333 overs in traditional decimal, but 3.2 overs in scorecard notation
     *
     * @param $balls
     * @return float
     */
    private function convertBallsToDecimal($balls)
    {
        return (float)($balls / $this->ballsPerOver);
    }
}