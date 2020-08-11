<?php

/**
 * ParserTest is used to test functionality of Parser.php
 *
 *
 * @author Allison Christiansen <allison@achristiansen.com>
 */

namespace BigramParser\tests;

use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
  /**
   * Parser object for testing
   * @var \BigramParser\Parser
   */
  protected $parser;

  /**
   * Loads the necessary files for testing.
   */
  protected function setUp()
  {
    require_once dirname(__FILE__, 2) . '/src/BigramParser/Parser.php';
    require_once dirname(__FILE__, 2) . '/src/BigramParser/GenericFunctions.php';

    $this->parser = new \BigramParser\Parser();
  }

  /**
   * Testing of Parser function getPairs
   */
  public function testGetPairs()
  {
    $this->assertEquals(
        array(
        "test|text" => 1
        ),
        $this->parser->getPairs("test text", "")
    );

    $this->assertEquals(
        array(
        "test|text" => 2,
        "text|test" => 1
        ),
        $this->parser->getPairs("test text Test Text", "")
    );

    $this->assertEquals(
        array(
        "quick|brown" => 1,
        "fox|and" => 1,
        "quick|blue" => 1,
        "hare|ran" => 1,
        "ran|alongside" => 1,
        "alongside|the" => 1,
        "slow|blue" => 1,
        "hare|and" => 1,
        "slow|brown" => 1,
        "the|quick" => 2,
        "brown|fox" => 2,
        "and|the" => 2,
        "blue|hare" => 2,
        "the|slow" => 2
        ),
        $this->parser->getPairs(
            "!!!!The quick brown fox and the quick blue hare ran alongside the "
            . "slow blue hare and the slow brown fox!!!!",
            ""
        )
    );
  }

  /**
   * Tests the project root directory.
   * TODO: this should go in another class
   */
  public function testGetProjectRoot()
  {
    $this->assertEquals(
        'C:\xampp\htdocs\dev.achristiansen.com\BigramParser\\',
        \BigramParser\GenericFunctions::getProjectRoot()
    );
  }
}
