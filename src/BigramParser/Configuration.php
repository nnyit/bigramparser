<?php

/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * PHP version 7
 *
 * @category Name
 * @package  Name
 * @author   Allison Christiansen <allison@achristiansen.com>
 * @link     URL description
 */

namespace BigramParser;

class Configuration
{

  /**
   * An array containing the configuration elements.
   * @var Array
   */
  private $configuration;

  private $input_text;

  /**
   * Short description for function
   */
  public function __construct()
  {
    $this->init();
  }

  /**
   * TODO
   */
  private function init()
  {
    $this->configuration = array(
        "input_type" => array("type" => "string", "value" => "text"),
        "charlist" => "",
        "devel" => "",
        "source" => "",
        "threshold" => "",
    );

    $this->input_text = "";
  }

// <editor-fold defaultstate="collapsed" desc="Get methods">

  /**
   * Gets the configuration object.
   * @return Array Returns an array containing configuration objects.
   */
  public function getConfiguration()
  {
    return $this->configuration;
  }

  /**
   * TODO
   * @return type TODO
   */
  public function getInputText()
  {
    return $this->input_text;
  }

  /**
   * TODO
   * @return type
   */
  public function getCharlist()
  {
    //TODO: if(GenericFunctions::validateArrayKey($this->configuration, "charlist"))
    return $this->configuration["charlist"];
  }

  /**
   *
   * @return type
   */
  public function getThreshold()
  {
    return $this->configuration["threshold"];
  }


// </editor-fold>

  /**
   * Sets the input type in the configuration array.
   *
   * @param String $input_type The type of input that will be used in parsing.
   */
  private function setInputType($input_type)
  {
    //var_dump(gettype($input_type));
    $valid_input_types = array("file", "text", "url");
    if ((in_array($input_type, $valid_input_types)))
    {
      $this->configuration["input_type"] = $input_type;
    }
  }




  /**
   * Sets the charlist in the configuration array.
   *
   * @param String $charlist A list of additional characters which will be considered as 'word'
   */
  private function setCharlist($charlist)
  {
    if ((GenericFunctions::validateString($charlist)))
    {
      $this->configuration["charlist"] = $charlist;
    }
  }


  /**
   * Sets the devel in the configuration array
   *
   * @param Boolean $devel Whether to show debugging information.
   */
  private function setDevel($devel)
  {
     //TODO: setDevel - more validation?
    //var_dump($devel);
    if ((GenericFunctions::validateBoolean($devel)))
    {
      $this->configuration["devel"] = $devel;
    }
    //var_dump($this->configuration["devel"]);
  }




  /**
   * Sets the source in the configuration array
   * @param String $source Source configuration value
   */
  private function setsource($source)
  {
    //TODO: more validation
    if (GenericFunctions::validateString($source))
    {
      $this->configuration["source"] = $source;
    }
  }

  /**
   * TODO
   * @param type $threshold
   */
  private function setThreshold($threshold)
  {
    if (GenericFunctions::validateInteger($threshold))
    {
      $this->configuration["threshold"] = $threshold;
    }
  }



  /**
   * Sets this configuration array
   *
   */
  public function setConfiguration()
  {



    $filename = "config/config.json";

    $json_array = $this->readConfigFile($filename);


    if(GenericFunctions::validateArray($json_array))
    {
      $this->setInputType($json_array["input_type"]);
      $this->setCharlist($json_array["charlist"]);
      $this->setDevel($json_array["devel"]);
      $this->setsource($json_array["source"]);
      $this->setThreshold($json_array['threshold']);
    }

    $this->setInputText();
  }

  /**
   *
   * @param type $filename
   * @return type
   */
  private function readConfigFile($filename)
  {
    $json_array = null;
    $json_obj = GenericFunctions::getJsonFromFile($filename);
    //TODO: output json_obj
    if(GenericFunctions::validateObject($json_obj))
    {
      $json_array = (array) $json_obj;
    }
    return $json_array;
  }

  /**
   * Sets the input_text property based on the input type
   */
  private function setInputText()
  {
    $input_text = "";
    if (GenericFunctions::validateArrayKey($this->configuration, "input_type"))
    {
      switch($this->configuration["input_type"])
      {
        case "file":
              $input_text = GenericFunctions::getFileContents($this->configuration["source"]);
              break;

        case "text":
              $input_text = $this->configuration["source"];
              break;

        case "url":
              $input_text = GenericFunctions::getUrlContents($this->configuration["source"]);
              break;
      }
    }

    $this->input_text = $this->cleanInputText($input_text);;
  }

  /**
   * Clean input text.
   *
   * @param String $input_text Input text
   *
   * @return String Input text.
   */
  private function cleanInputText($input_text)
  {
    //remove ' unless it's in between a word = contraction
    //TODO: convert to an associative array for the replacement values for readability
    //TODO:  //what to do about things like 1500s; name abbreviated as 'H."
    $input_text = str_replace(array(" '", "' ", "',", ".'"), array(" ", " ", ",", "."), $input_text);
    return $input_text;
  }
}
