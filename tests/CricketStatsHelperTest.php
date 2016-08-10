<?php
namespace Garethellis\CricketStatsHelper\Test;

use Garethellis\CricketStatsHelper\CricketStatsHelper;

class CricketStatsHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CricketStatsHelper
     */
    private $helper;

    public function setUp()
    {
        parent::setUp();
        $this->helper = new CricketStatsHelper();
    }

    public $overs = array(
        array(
            "overs" => 1,
            "balls" => 6
        ),
        array(
            "overs" => 3,
            "balls" => 18
        ),
        array(
            "overs" => 5,
            "balls" => 30
        ),
        array(
            "overs" => 2.1,
            "balls" => 13
        ),
        array(
            "overs" => 2.2,
            "balls" => 14
        ),
        array(
            "overs" => 4.3,
            "balls" => 27
        ),
        array(
            "overs" => 6.4,
            "balls" => 40
        ),
        array(
            "overs" => 5.5,
            "balls" => 35
        ),
    );

    public function testConvertOversToBalls()
    {
        foreach ($this->overs as $over) {
            $this->assertEquals($over["balls"], $this->helper->convertOversToBalls($over["overs"]));
        }
    }

    public function testConvertBallsToOvers()
    {
        foreach ($this->overs as $over) {
            $this->assertEquals($over["overs"], $this->helper->convertBallsToOvers($over["balls"]));
        }
    }

    private $battingInputs = array(
        array(
            "runs" => 150,
            "innings" => 10,
            "not_outs" => 0,
            "average" => 15
        ),
        array(
            "runs" => 12,
            "innings" => 2,
            "not_outs" => 1,
            "average" => 12
        ),
        array(
            "runs" => 255,
            "innings" => 12,
            "not_outs" => 2,
            "average" => 25.5
        ),
        array(
            "runs" => 75,
            "innings" => 2,
            "not_outs" => 2,
            "average" => false
        ),
    );

    public function testCalculateBattingAverage()
    {
        foreach ($this->battingInputs as $input) {
            $this->assertEquals(
                $input["average"],
                $this->helper->calculateBattingAverage(
                    $input["runs"],
                    $input["innings"],
                    $input["not_outs"]
                )
            );
        }

    }

    private $bowlingAverageInputs = array(
        array(
            "runs" => 100,
            "wickets" => 10,
            "average" => 10
        ),
        array(
            "runs" => 50,
            "wickets" => 0,
            "average" => false
        ),
        array(
            "runs" => 185,
            "wickets" => 10,
            "average" => 18.5
        )
    );

    public function testCalculateBowlingAverage()
    {
        foreach ($this->bowlingAverageInputs as $input) {
            $this->assertEquals(
                $input["average"],
                $this->helper->calculateBowlingAverage(
                    $input["runs"],
                    $input["wickets"]
                )
            );
        }
    }

    private $bowlingEconomyInputs = array(
        array(
            "runs" => 50,
            "overs" => 5,
            "econ" => 10
        ),
        array(
            "runs" => 50,
            "overs" => 0,
            "econ" => false
        ),
        array(
            "runs" => 165,
            "overs" => 20,
            "econ" => 8.25
        )
    );

    public function testCalculateBowlingEconomy()
    {

        foreach ($this->bowlingEconomyInputs as $input) {
            $this->assertEquals(
                $input["econ"],
                $this->helper->calculateBowlingEconomy(
                    $input["overs"],
                    $input["runs"]
                )
            );
        }
    }

    public function testCalculateStrikeRate()
    {
        $inputs = [
            [
                "overs" => "5",
                "wickets" => 2,
                "strike_rate" => "15"
            ],
            [
                "overs" => "10",
                "wickets" => 1,
                "strike_rate" => "60",
            ],
            [
                "overs" => "2.3",
                "wickets" => 3,
                "strike_rate" => "5"
            ],
            [
                "overs" => "4",
                "wickets" => 0,
                "strike_rate" => null
            ]
        ];

        foreach ($inputs as $input) {
            $this->assertEquals(
                $input["strike_rate"],
                $this->helper->calculateStrikeRate(
                    $input["overs"],
                    $input["wickets"]
                )
            );
        }
    }

}
