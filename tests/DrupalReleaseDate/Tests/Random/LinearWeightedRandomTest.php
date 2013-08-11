<?php
namespace DrupalReleaseDate\Tests\Random;

use DrupalReleaseDate\Random\LinearWeightedRandom;

class LinearWeightedRandomTest extends \PHPUnit_Framework_TestCase {

    /**
     * Number of iterations to retrieve from the generator when multiple results
     * are required.
     */
    protected $iterations = 1000;

    /**
     * Test that the generator only returns results in the specified range.
     */
    public function testRange() {
        $min = 2;
        $max = 15;
        $generator = new LinearWeightedRandom($min, $max);

        for ($i = 0; $i < $this->iterations; $i++) {
            $rand = $generator->generate();
            $this->assertGreaterThanOrEqual($min, $rand);
            $this->assertLessThanOrEqual($max, $rand);
        }
    }

    /**
     * Test that the calculated weights for the generator are correct.
     */
    public function testSimpleWeights() {
        $min = 1;
        $max = 10;
        $generator = new LinearWeightedRandom($min, $max);

        $weight = 1;
        for ($i = $min; $i <= $max; $i++) {
            $this->assertEquals($weight, $generator->calculateWeight($i));
            $weight++;
        }
    }

    /**
     * Test that the calculated weights for the generator are correct.
     */
    public function testShiftedWeights() {
        $min = 3;
        $max = 12;
        $generator = new LinearWeightedRandom($min, $max);

        $weight = 1;
        for ($i = $min; $i <= $max; $i++) {
            $this->assertEquals($weight, $generator->calculateWeight($i));
            $weight++;
        }
    }

    /**
     * Check that the distribution of results from a generator is accurate
     * within its range.
     *
     * Since the sum of probabilities is greater than in a flat distribution,
     * addtional iterations need to be performed to get sufficient precision for
     * the least likely items.
     *
     * @param WeightedRandom $generator
     * @param int $min
     * @param int $max
     * @param
     */
    protected function checkDistribution(\DrupalReleaseDate\Random\WeightedRandom $generator, $min, $max) {

        $range = $max - $min + 1;
        $probabilitySum = ($range * ($range + 1) / 2);

        $results = array();
        for ($i = $min; $i <= $max; $i++) {
            $results[$i] = 0;
        }

        for ($i = 0; $i < ($this->iterations * $probabilitySum); $i++) {
            $results[$generator->generate()]++;
        }

        // TODO make the required results adaptive based on the range of the generator
        //      and the number of iterations performed.
        $weight = 1.0;
        foreach ($results as $key => $count) {
            $this->assertEquals($weight, $count / ($this->iterations), '', 0.2);
            $weight++;
        }
    }

    /**
     * Test that the generator produces a linearly increasing distribution of results.
     * (e.g. the second item should be twice as likely as the first, the third item
     *  three times as likely, etc)
     */
    public function testDistribution() {
        $generator = new LinearWeightedRandom(3, 8);

        $this->checkDistribution($generator, 3, 8);
    }

    /**
     * Test that a generator produces a correct distribution if the min value is
     * changed.
     */
    public function testDistributionChangeMin() {
        $generator = new LinearWeightedRandom(4, 8);

        $generator->setMin(3);
        $this->checkDistribution($generator, 3, 8);

        $generator->setMin(5);
        $this->checkDistribution($generator, 5, 8);
    }

    /**
     * Test that a generator produces a correct distribution if the max value is
     * changed.
     */
    public function testDistributionChangeMax() {

        $generator = new LinearWeightedRandom(4, 7);

        $generator->setMax(9);
        $this->checkDistribution($generator, 4, 9);

        $generator->setMax(8);
        $this->checkDistribution($generator, 4, 8);
    }
}
