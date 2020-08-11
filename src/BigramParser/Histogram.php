<?php

/**
 * Creates a Histogram.
 *
 * PHP version 7
 *
 * @category Default
 * @package  BigramParser
 * @author   Allison Christiansen <allison@achristiansen.com>
 * @link     https://dev.achristiansen.com/BigramParser/
 */

namespace BigramParser;

class Histogram
{

  /**
   * Constructor to create the Histogram object
   */
  public function __construct()
  {
  }

  /**
   * Generates the histogram.
   *
   * @param Array $data An array of data that will be used to plot the graph.
   * @return String A string containing the encoded image data for the img src.
   */
  public function getHistogram($data = array())
  {
    $encoded_image = null;
    $width = 500;
    $height = 500;
    $phplot = $this->createPhplotObject($width, $height);
    $array_count = GenericFunctions::getArrayCount($data);

    if($array_count > 0)
    {
      //$phplot = false; //TODO: comment out when done testing

      if($phplot)
      {
        $encoded_image = $this->getHistogramPhplot($phplot, $data);

      }
      else
      {
        $encoded_image = $this->generatePlaintextHistogram($data);
      }
    }
    return $encoded_image;
  }

  /**
   * TODO
   */
  private function getHistogramPhplot($phplot, $data)
  {
    $encoded_image = FALSE;
    if (isset($data))
    {
      $this->setPhplotSettings($phplot);
      //Set the data
      $transformed_data = $this->transformDataForPhplot($data);
      $phplot->SetDataValues($transformed_data);
      $phplot->DrawGraph();
      $encoded_image = $phplot->EncodeImage();
    }

    return $encoded_image;
  }

  /**
   * Sets settings for the Phplot graph
   * @param Phplot $phplot A Phplog object
   */
  private function setPhplotSettings($phplot)
  {
    $phplot->SetPlotType("thinbarline");
    $phplot->SetDataType("text-data-yx");

    //Labels
    $phplot->setTitle("Bigram Histogram");
    $phplot->SetXLabel("Count");
    $phplot->SetYLabel("Bigram");

    //Format
    $phplot->SetXTickIncrement(1);
    $phplot->SetPrintImage(false);
    $phplot->SetYTickIncrement(1);
  }

  /**
   * Gets a PHPlot object if the class exists.
   *
   * @param int $width Image width in pixels
   * @param int $height Image height in pixels
   *
   * @return PHPlot  Returns a PHPlot object.
   */
  private function createPhplotObject($width, $height)
  {
    $phplot = false;
    $filename = "../phplot/phplot.php"; //TODO: put this in config file
    if (GenericFunctions::includeClass($filename, "PHPlot"))
    {
      $phplot = new \PHPlot($width, $height);
    }
    return $phplot;
  }

  /**
   * Transforms the array for the PHPlot object into the correct format.
   *
   * @param Array $data The array to transform.
   *
   * @return Array The transformed array.
   */
  private function transformDataForPhplot($data)
  {
    //TODO: vaidate $data
    $transform = array();
    asort($data);
    foreach($data as $pair => $count)
    {
      $transform[] = array($pair, $count);
    }
    return $transform;
  }

  /**
   * Generates a plaintext histogram
   *
   * @param Array $data An array of data that will be used to plot the graph.
   */
  private function generatePlaintextHistogram($data)
  {
    $table_width = $this->getTableWidth($data);
    $word_width = $this->getMaxStringLength($data);
    //var_dump($table_width);
    //echo $word_width;
    //echo $table_width;
    //echo max($data);
    //$content = "<table>";
    $content = "";
    //TODO: generate another way
    $font_height = 21;
    $font_width = 9;
    $array_count = count($data);
    //var_dump($data);
    $img_height = $font_height * $array_count;
    $img_width = $font_width * $table_width;
//echo $table_width;
    $im = imagecreate($img_width + $font_width , $img_height + $font_height);
    $bg = imagecolorallocate($im, 255, 255, 255);
    $textcolor = imagecolorallocate($im, 0, 0, 255);

    $i = 0;

    foreach ($data as $word => $count)
    {
      $i += 1;
      //$content .= "<tr><td>$word</td><td>" . $this->generateTickmark($count) . "</td></tr>";
      $content = $word . $this->padWord($word, $word_width). $this->generateTickmark($count);
      imagestring($im, 5, 0, $font_height * $i, $content, $textcolor);
    }
    //$content .= "</table>";

    //echo "<pre>$content</pre>";

    $image = $this->convertImage($im);
    return $image;
    //return $content;
  }

  /**
   * TODO
   * @param type $word
   * @param type $word_count
   * @param type $word_width
   * @return type
   */
  private function padWord($word, $word_width)
  {
    $content = "";
    $count = strlen($word);
    //$count = $word_count + strlen($word);
    //echo "<br>$word | $word_count | $count | $word_width";
    if ($count < $word_width)
    {
      $content .= $this->generateTickmark($word_width-$count, ".");
    }
    return $content;
  }

  /**
   * TODO
   * @param type $array
   * @return type
   */
  private function getTableWidth($array)
  {
    $width = 0;

    if (is_array($array))
    {
      $max = max($array);
      $max_str = $this->getMaxStringLength($array);
      if (is_int($max) && is_int($max_str))
      {
        $width = $max + $max_str;
      }
    }

    return $width;
  }

  /**
   * TODO
   * @param type $array
   * @return type
   */
  private function getMaxStringLength($array)
  {
    $max = 0;
    if (is_array($array))
    {
      $max = max(array_map('strlen', array_keys($array)));
    }
    return $max;
  }


  /**
   * TODO
   * @param type $im
   * @return string
   */
  private function convertImage($im)
  {
    ob_start();
    imagepng($im);
    $image = 'data:image/png;base64,'.base64_encode(ob_get_clean());

    imagedestroy($im);
    return $image;
  }


  /**
   * TODO
   * @param type $count
   * @param type $char
   * @return string
   */
  private function generateTickmark($count, $char = "*")
  {
    $content = "";
    for ($i = 0; $i < $count; $i++)
    {
      $content .= $char;
    }
    $content .= "";
    return $content;
  }
}
