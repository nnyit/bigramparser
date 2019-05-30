<?php
/**
 * Short Description
 * 
 * Long Description
 * 
 * PHP version 7
 * 
 * @category Category
 * @package  Package
 * @author   Allison Christiansen <allison@achristiansen.com>
 * @license  url 
 * @link     url
 */
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);
require_once "bigramparser.php";

$bp = new BigramParser();
$bp->bpInit();

$graph = $bp->getGraphOutput();
$data = $bp->getTextOutput();
$errors = $bp->getErrorOutput();
$input = "TEST";
?>

<!DOCTYPE html>

<html>
  <head>
    <title>BigramParser</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="bigramparser.css" />
  </head>
  <body>
    
    <div id="input">
        <?php echo $input;?>
    </div>
    <div id="data">
        <?php echo $data;?>
    </div>
    <div id="graph">
        <?php echo $graph;?>
    </div>
    <div id="errors">
        <?php echo $errors;?>
    </div>
  </body>
</html>


<?php


/**
 * Description
 * 
 * @param type $message Description
 * @param type $function_name Description
 * 
 * @return type Description
 */
function error($message, $function_name) 
{
    echo "<div class='error'>Error: $function_name: $message</div>";
}