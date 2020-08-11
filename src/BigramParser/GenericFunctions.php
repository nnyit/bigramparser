<?php

/**
 * Generic functions that can be used for any class.
 *
 * PHP version 7
 *
 * @category Default
 * @package  BigramParser
 * @author   Allison Christiansen <allison@achristiansen.com>
 * @link     https://dev.achristiansen.com/BigramParser/
 */

namespace BigramParser;

class GenericFunctions
{

  /**
   * Constructor for GenericFunctions
   */
  public function __construct()
  {
  }

  /**
   * Wrapper for function file_get_contents
   *
   * @param String $filename The file to get the contents of
   *
   * @return String The contents of the file or false
   * @link https://www.php.net/manual/en/function.file-exists.php
   * @link https://www.php.net/manual/en/function.file-get-contents.php
   */
  public static function getFileContents($filename)
  {
    $contents = false;
    if(file_exists($filename))
    {
      $contents = file_get_contents($filename);
    }
    else
    {
      GenericFunctions::error("file does not exist: $filename");
    }
    return $contents;
  }

  /**
   * TODO
   * @param type $filename
   * @return type
   */
  public static function getUrlContents($filename)
  {
    $contents = "";

    $code = "";
    if (GenericFunctions::validateString($filename) && "" != $filename)
    {
      $code = file_get_contents($filename);
    }
    $doc = new \DOMDocument();
    if ($doc)
    {
      libxml_use_internal_errors(true);

      if (GenericFunctions::validateString($code) && "" != $code)
      {
        $doc->loadHTML($code);
      }

      libxml_use_internal_errors(false);

      $element = $doc->getElementById("Panes");
      if ($element)
      {
        $contents = $element->nodeValue;
      }
    }

    return $contents;
  }

  /**
   * Gets the project's root directory based on the current file's path
   *
   * @return String Representing the project's src directory
   */
  public static function getProjectRoot()
  {
    //echo "dirname" . dirname(__DIR__, 2) . "<br>";
    return str_replace("src" . DIRECTORY_SEPARATOR . __NAMESPACE__, "", __DIR__);
  }

  /**
   * This function gets the file contents of a json file, parses it and turns it into a PHP Object.
   * @param string $filename The json file to parse.
   * @return Object|null Returns the value encoded in json in the Object PHP type.
   * @link https://www.php.net/manual/en/function.json-decode.php
   */
  public static function getJsonFromFile($filename)
  {
    $json_obj = null;
    $filename = GenericFunctions::getProjectRoot() . $filename;

    $contents = GenericFunctions::getFileContents($filename);

    if (GenericFunctions::validateString($contents))
    {
      $json_decode = json_decode($contents);
      if(GenericFunctions::validateObject($json_decode))
      {
        $json_obj = $json_decode;
      }
    }
    return $json_obj;
  }

  /**
   * Handle error messages. This function's purpose is so that errors can be handled in a standard way,
   * in which the implementation can be changed later.
   *
   * @param String $message The error message.
   * @param Boolean $debug Whether to get the backtrace information.
   */
  public static function error($message, $debug = false)
  {
    //echo "<div>$message</div>";
    if($debug)
    {
      //var_dump(debug_backtrace());
    }
    //error_log($mesage, $message_type, $destination, $extra_headers);
  }

  /**
   * Validates a variable to see if it is an Object.
   * @param Mixed $var Variable to test
   * @return Boolean Whether variable is set and is type: object.
   */
  public static function validateObject($var)
  {
    return (isset($var) && is_object($var));
  }

  /**
   * Validates a variable to see if it is a String.
   * @param Mixed $var Variable to test
   * @return Boolean Whether variable is set and is type: String.
   */
  public static function validateString($var)
  {
    return (isset($var) && is_string($var));
  }

  /**
   * Validates a variable to see if it is an array.
   * @param Mixed $var Variable to test
   * @return Boolean Whether variable is set and is type: Array.
   */
  public static function validateArray($var)
  {
    return (isset($var) && is_array($var));
  }

  /**
   * Validates an array key
   * @param Array $array THe array to check in.
   * @param Mixxed $key The key to check.
   * @return Boolean Whether array is set and array key exists
   */
  public static function validateArrayKey($array, $key)
  {
    return (GenericFunctions::validateArray($array) && array_key_exists($key, $array));
  }

  /**
   * Validates a variable to see if it is a Boolean.
   * @param Mixed $var Variable to test
   * @return Boolean Whether variable is set and is type: Boolean.
   */
  public static function validateBoolean($var)
  {
    //var_dump($var);
    if (isset($var))
    {
      if (is_bool($var))
      {

      }
      else
      {
        if ("true" == $var)
        {
          $var = true;
        }
      }
    }
    //TODO: test  passing in false
    return (isset($var) && is_bool($var));
  }

  /**
   * TODO
   * @param type $var
   * @return type
   */
  public static function validateInteger($var)
  {
    if (isset($var) && is_numeric($var))
    {
      $var = (int) $var;
    }
    return (isset($var) && is_int($var));
  }

  /**
   * Gets the count of an array if it is a valid array.
   * @param Array $array The array to get the count of.
   * @return Integer The count of array or 0.
   */
  public static function getArrayCount($array)
  {
    $count = 0;
    if (GenericFunctions::validateArray($array))
    {
      $count = count($array);
    }
    return $count;
  }

  /**
   * Checks to see if a file exists and if so, includes the file and checks to see if the class exists within the file.
   * @param String $filename Path to the file or directory.
   * @param String $class_name The class name. The name is matched in a case-insensitive manner.
   *
   * @return Boolean Returns true if the file and class exist.
   * @link https://www.php.net/manual/en/function.class-exists.php
   */
  public static function includeClass($filename, $class_name)
  {
    $valid = false;
    if(file_exists($filename))
    {
      require_once $filename;
      $valid = (class_exists($class_name));
    }
    return $valid;
  }
}
