<?php

/**
 * Parses texts to create bigrams.
 *
 * PHP version 7
 *
 * @category Default
 * @package  BigramParser
 * @author   Allison Christiansen <allison@achristiansen.com>
 * @link     https://dev.achristiansen.com/BigramParser/
 */

namespace BigramParser;

class Parser
{

  /**
   * Constructor to create the Parser object
   */
  public function __construct()
  {
  }

  /**
   * Validates the input text that will be parsed.
   *
   * @param String $text Text to be parsed.
   *
   * @return Boolean True, if input text is valid.
   */
  private function validateInputText($text)
  {
    /* TODO: this needs to set the value you is used globally, otherwise,
     * it does not do much good to call jsonencode if it is not a string.
     */
    if(!is_string($text))
    {
      $text = json_encode($text);
    }

    if (!GenericFunctions::validateString($text))
    {
      $text = "";
    }

    return $text;
  }



  /**
   * Generates array that is used to then generate the Bigram array
   *
   * @param String $text The input text to use
   * @param String $charlist A list of additional characters which will be considered as 'word'
   *
   * @return Array An array of bigram pairs.
   */
  public function getPairs($text, $charlist)
  {
    $words = $this->generateWordArray($text, $charlist);
    $pairs = $this->generatePairs($words);

    return $pairs;
  }

  /**
   * Generates a pair of words
   *
   * @param Array $words An array of words
   *
   * @return Array An array of bigrams and their count
   */
  private function generatePairs($words)
  {
    $pairs = array();

    $word_count = GenericFunctions::getArrayCount($words);


    for($i = 0; $i < $word_count; $i++)
    {
      if(array_key_exists($i, $words) && array_key_exists($i + 1, $words))
      {
        ////TODO: what happens if the text contains the | char?
        $concat = ($words[$i]) . "|" . ($words[$i + 1]);
        if(!array_key_exists($concat, $pairs))
        {
          $pairs[$concat] = 0;
        }

        $pairs[$concat] += 1;
      }
    }


    arsort($pairs);

    return $pairs;
  }

  /**
   * Creates an array containing all the words found inside the input string
   *
   * @param String $text The input text to use
   * @param String $charlist A list of additional characters which will be considered as 'word'
   *
   * @return Array Returns an array of the words in a string.
   * @link   https://www.php.net/manual/en/function.str-word-count.php
   */
  private function generateWordArray($text, $charlist = "")
  {
    $words = array();
    if(!GenericFunctions::validateString($charlist))
    {
      $charlist = "";
    }

    if($this->validateInputText($text))
    {
      $words = str_word_count(strtolower($text), 1, $charlist);
    }
    return $words;
  }
}
