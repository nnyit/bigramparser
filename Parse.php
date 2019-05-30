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
class Parse
{

    private $_words = array();
    private $_charlist = "";
    private $_pairs = array();

    /**
     * Description
     * 
     * @param type $charlist description
     */
    public function __construct($charlist) 
    {
        $this->setCharList($charlist);
    }

    /**
     * Description
     * 
     * @param type $charlist description
     * 
     * @return type Description
     */
    public function setCharList($charlist) 
    {
        $this->_charlist = $charlist;
    }

    /**
     * Description
     * 
     * @return int
     */
    public function getPairs() 
    {
        $i = 0;
        $count = 0;
        $pairs = array();
        $concat = "";
        $formatted = "";

        if (is_array($this->_words)) {
            $count = count($this->_words);
            for ($i; $i < $count; $i++) {

                if (array_key_exists($i, $this->_words) 
                    && array_key_exists($i + 1, $this->_words)
                ) {
                    $concat = ($this->_words[$i]) . "|" . ($this->_words[$i + 1]);
                    $pairs[$concat] += 1;
                }
            }
        }
        arsort($pairs);
        return $pairs;
    }

    /**
     * Description
     * 
     * @param type $string description
     * 
     * @return type Description
     */
    public function addWords($string) 
    {
        if (isset($string)) {
            $new_array = str_word_count(strtolower($string), 1, $this->_charlist);
            if (is_array($this->_words)) {
                
                $this->_words = array_merge($this->_words, $new_array);
            }
        } else {
            error("string is not set", "Parse.addWords");
        }
    }

    /**
     * Description
     * 
     * @param type $handle description
     * 
     * @return type Description
     */
    public function addWordsFromFile($handle) 
    {

        if ($handle) {
            while (($line = fgets($handle))) {
                $this->addWords($line);
            }
            fclose($handle);
        } else {
            error("File handle is false", "Parse.addWordsFromFile");
        }
    }

    /**
     * Description
     * 
     * @param type $pairs description
     * 
     * @return type
     */
    public function transformPairs($pairs) 
    {

        $transform = array();
        foreach ($pairs as $pair => $count) {
            $transform[] = array($pair, $count);
        }
        return $transform;
    }

}
