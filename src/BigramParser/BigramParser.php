<?php

/**
 * Main file for BigramParser.
 *
 * PHP version 7
 *
 * @category Default
 * @package  BigramParser
 * @author   Allison Christiansen <allison@achristiansen.com>
 * @link     https://dev.achristiansen.com/BigramParser
 */

namespace BigramParser;

class BigramParser
{
  /**
   * An array containing the configuration elements.
   * @var Array
   */
  private $configuration;

  /**
   * The text that will be used to generate the Bigrams.
   * @var String
   */
  private $input_text;

  /**
   * An array of Bigrams pairs and their count.
   * @var Array
   */
  private $pairs;

  /**
   * A string containing the image source for the histogram.
   * @var String
   */
  private $histogram_image;

  /**
   * Constructor: Calls functions to set configuration, input text, pairs, and histogram_image
   */
  public function __construct()
  {
    $config = new \BigramParser\Configuration();
    $config->setConfiguration();
    $this->configuration = $config->getConfiguration();
    $this->input_text = $config->getInputText();
    ////TODO: put the table/graph greatest number first.
    ////TODO: keep numbers together ex 1500s
    //$this->setInputText();

    $parser = new \BigramParser\Parser();
    $charlist = $config->getCharlist();
    $this->pairs = $parser->getPairs($this->input_text, $charlist);

    $threshold = $config->getThreshold();

    $this->removePairs($this->pairs, $threshold);

    $histogram = new \BigramParser\Histogram();
    $this->histogram_image = $histogram->getHistogram($this->pairs);
  }

  /**
   * Calls the appropriate HTML methods to generate  HTML output
   *
   * @return Array of elements for use in template file(s)
   */
  public function getOutput()
  {
    $html = new \BigramParser\HtmlGenerator();

    $output = array(
        "logo" => "logo",
        "navigation" =>  $this->getNavigation(),
        "config" => $html->generateTableFromArray($this->configuration),
        "input" => $this->input_text,
        "data" => $html->generateTableFromArray($this->pairs, array("Pair", "Count")),
        "graph" => $html->generateImageTag($this->histogram_image, $alt = "Histogram"),
        "footer" => "footer",
    );
    return $output;
  }

  /**
   * //TODO
   * @return string
   */
  private function getNavigation()
  {
    $navigation = array(
        0 => array("href" => "#", "text" => "Home"),
        1 => array("href" => "docs", "text" => "Documentation"),
        2 => array("href" => "https://github.com/nnyit/bigramparser", "text" => "Github"),
    );
    $output = "<ul>";
    foreach ($navigation as $value)
    {
      $output .= "<li><a href='" . $value["href"] . "'>" . $value["text"] . "</a>";
    }
    $output .= "</ul>";
    return $output;
  }

  /**
   * Removes bigrams that do not meet the threshold count
   * @param type $data
   * @param type $threshold
   * @return type
   */
  private function removePairs(&$data, $threshold)
  {
    $new_data = array();

    if ($threshold > 0)
    {
      foreach ($data as $key => $count)
      {
        if ($count < $threshold)
        {
          $new_data[$key] = $count;
          unset($data[$key]);
        }
      }
    }
    return $new_data;
  }





  //TODO: there is already some validation going on in Parser.php
}
