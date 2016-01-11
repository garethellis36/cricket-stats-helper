# Cricket Stats Helper #

[![Build Status](https://travis-ci.org/garethellis36/cricket-stats-helper.svg?branch=master)](https://travis-ci.org/garethellis36/cricket-stats-helper)
[![Code Climate](https://codeclimate.com/github/garethellis36/cricket-stats-helper/badges/gpa.svg)](https://codeclimate.com/github/garethellis36/cricket-stats-helper)

A simple PHP library for calculating cricket statistics such as batting average, bowling average and bowling economy. 
Can also convert number of overs bowled in scorecard notation to number of balls bowled, and vice-versa.

# Installation #

Install with composer, obvs:

``` bash
$ composer require Garethellis/cricket-stats-helper
```


# Usage #

To use the stats helper, simply create a new instance of it. 

``` php
<?php
use Garethellis\CricketStatsHelper\CricketStatsHelper;
$helper = new CricketStatsHelper();
```

# Balls per over #

The standard number of balls in an over in cricket is six. However, in some formats of the sport you will see variations
in this. Indeed, until 1979 in Australia all Test Cricket overs lasted eight balls. Thus, you can change the number of
balls in an over on which to base the various calculations in two ways. Firstly, in the constructor:

``` php
$helper = new CricketStatsHelper(8);
```

Secondly, using a setter method:
``` php
$helper = new CricketStatsHelper();
$helper->setBallsPerOver(8);
```

# Calculating Batting Average #

A batting average is a measure of a batsman's productivity in terms of runs scored per dismissal (it is
not quite the same as runs scored per *innings*). You can calculate the batting average as follows:

``` php
<?php
use Garethellis\CricketStatsHelper\CricketStatsHelper;
$helper = new CricketStatsHelper();
$battingAverage = $helper->calculateBattingAverage($runsScored, $inningsPlayed, $numberOfTimesNotOut);
```

Note, each argument to this method must be of type int.

# Calculating Bowling Average #

A bowling average is a measure of a bowler's productivity in terms of their ratio of wickets taken to runs conceded. To
calculate the bowling average using this library:

``` php
<?php
use Garethellis\CricketStatsHelper\CricketStatsHelper;
$helper = new CricketStatsHelper();
$bowlingAverage = $helper->calculateBowlingAverage($runsConceded, $wicketsTaken);
```

Note, each argument to this method must be of type int.

# Calculating Bowling Economy #

Bowling economy is a measure of a bowler's ability to restrict batsmen from scoring runs. To calculate the bowling 
economy:

``` php
<?php
use Garethellis\CricketStatsHelper\CricketStatsHelper;
$helper = new CricketStatsHelper();
$bowlingEconomy = $helper->calculateBowlingEconomy($runsConceded, $oversBowled);
```

Runs conceded must be of type int. Overs bowled can be a whole number (int or string) or a decimal (float or string). 
 Decimals must be provided in "scorecard notation" style, i.e. "10.3" means 10 overs and 3 balls, *not* 10 and one-third
 overs.
 
# Converting between overs and balls #

As mentioned above, cricket scorecard notation is different from conventional decimal notation. If you see that someone
bowled "9.5" overs, this means they bowled 9 overs (probably 6 balls each) and 5 balls, for a total of 59 balls - it does
not mean that they bowled 9-and-a-half overs. As well as the above methods for producing stats, some helper methods are
provided for converting between over scorecard notation and balls, in case you want to produce any stats of your own.

## Converting from overs to balls ##

``` php
<?php
use Garethellis\CricketStatsHelper\CricketStatsHelper;
$helper = new CricketStatsHelper();
$numberOfBalls = $helper->convertOversToBalls($overs);
```

As with bowling economy, overs here can be a whole number (int or string) or a decimal (float or string). Decimals must 
be provided in "scorecard notation" style, i.e. "10.3" means 10 overs and 3 balls, *not* 10 and one-third overs.

## Converting from balls to overs ##

``` php
<?php
use Garethellis\CricketStatsHelper\CricketStatsHelper;
$helper = new CricketStatsHelper();
$numberOfOvers = $helper->convertBallsToOvers($balls);
```

The number of overs returned will be in "scorecard notation" style (see above).