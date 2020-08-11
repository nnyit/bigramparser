<?php

/**
 * Loads necessary classes/files for main program.
 *
 * PHP version 7
 *
 * @category Default
 * @package  BigramParser
 * @author   Allison Christiansen <allison@achristiansen.com>
 * @link     https://dev.achristiansen.com/BigramParser/
 */

namespace BigramParser;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


spl_autoload_register(function ($class_name) {

  $path =  dirname(__FILE__). "/src/" . str_replace("\\", "/", $class_name) . '.php';

  include $path;
  if (file_exists($path))
  {
    //include $path;
  }
  else
  {
    echo "error loading class $class_name | $path";
  }
});


if (class_exists("\BigramParser\BigramParser"))
{
  $bp = new \BigramParser\BigramParser();
  $output = $bp->getOutput();
}
else
{
  echo "class does not exist";
  $output = array("logo" => "", "navigation" => "", "config" => "", "input" => "", "data" => "", "graph" => "", "footer" => "");
}
require_once "resources/templates/index.php";

//TODO: generate php documentation
//TODO: Links to Github project, Home, documentation
//Finish comments
//TODO: phpdocumentor graphic
