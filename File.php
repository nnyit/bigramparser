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
namespace BigramParser;

/**
 * Description of parse
 * 
 * @category Value
 * @package  Value
 * @author   Allison Christiansen <allison@achristiansen.com>
 * @license  https://www.something.com Description
 * @link     Value
 */
class File
{
  
    /**
     * Description
     */
    function __construct()
    {

    }
  
    /**
     * Description
     * 
     * @param type $filename Description
     * 
     * @return type
     */
    private function checkFile($filename) 
    {
        $valid = (is_file($filename) && is_readable($filename)); 
        if (!valid) {
            error("file not valid", "checkFile");
        }
        return $valid;
    }
  
    /**
     * Description
     * 
     * @param type $filename Description
     * 
     * @return type
     */
    public function getFileHandle($filename) 
    {
        $handle = false;

        if ($this->checkFile($filename)) {
            $handle = fopen($filename, "r");
        } else {
            error("Could not open file $filename", "File.getFileHandle");
        }

        return $handle;
    }
  
    /**
     * Description
     * 
     * @param type $filename Description
     * 
     * @return type
     */
    public function getJSON($filename)
    {
        $json_array = false;
        $contents = false;

        if ($this->checkFile($filename)) {
            $contents = file_get_contents($filename);
        } else {
            error("getJSON check file $filname false", "File.getJSON");
        }
        if ($contents) {
            $json_array = json_decode($contents, true);
        }

        return $json_array;
    }
}

