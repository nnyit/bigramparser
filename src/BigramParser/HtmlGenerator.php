<?php

/**
 * Generates HTML.
 *
 * PHP version 7
 *
 * @category Default
 * @package  BigramParser
 * @author   Allison Christiansen <allison@achristiansen.com>
 * @link     https://dev.achristiansen.com/BigramParser/
 */

namespace BigramParser;

class HtmlGenerator
{

  /**
   * Constructor
   */
  public function __construct()
  {
  }

  /**
   * Generates an HTML table
   *
   * @param Array $data Table data
   * @param Array $header Table header
   *
   * @return string HTML table
   */
  public function generateTableFromArray($data, $header = array("key", "value"))
  {
    $output = "<table>";

    if(GenericFunctions::validateArray($header))
    {
      $output .= "<tr>";
      foreach($header as $value)
      {
        $output .= "<th>$value</th>";
      }
      $output .= "</tr>";
    }

    if(GenericFunctions::validateArray($data))
    {
      foreach($data as $key => $value)
      {
        $output .= "<tr><td>$key</td><td>$value</td></tr>";
      }
    }
    $output .= "</table>";
    return $output;
  }

  /**
   * Generates an HTML image tag
   *
   * @param String $image_source Image source/data
   * @param String $alt Image alt. text
   *
   * @return String HTML image tag
   */
  public function generateImageTag($image_source, $alt = "")
  {
    $image_tag = "";

    if(GenericFunctions::validateString($image_source))
    {
      $image_tag = "<img src='$image_source'  alt='$alt' />";
    }

    return $image_tag;
  }
}
