<?php
namespace BigramParser;
class BigramParser
{
  public function getOutput(){}


  private $input;
  private $ngram_n;
  private $charlist;

  public function __construct()
  {
    /*$this->input = "";
    $this->ngram_n = 2;
    $this->charlist = "";




    $input = "“The boy is playing football”";
    $this->setInput($input);
    //echo $this->getInput();


    ($this->generateNGram($this->input, $this->ngram_n));
     *
     */
  }

  public function setInput($input)
  {
    $this->input = $input;
  }

  public function getInput()
  {
    return $this->input;
  }

  public function preprocessText()
  {

  }

  public function generateNGram($string, $ngram_n)
  {
    $format = 1; //returns an array containing all the words found inside the string
    $string = strtolower($string);

    $word_array = str_word_count($string, $format, $this->charlist);
    //var_dump($word_array);
    $ngram_array = array();
    for ($i = 0; $i < count($word_array); $i++ )
    {
      $ngram = "";
      for ($n = 0; $n < $ngram_n; $n++)
      {
        $key = ($i + $n);
       // echo "<br>$ngram_n| key: $key | i: $i | n: $n | " . $word_array[$key];
        if (array_key_exists($key, $word_array))
        {
          $ngram .= " " . $word_array[$key];
        }
        else
        {
          $ngram = "";
          break 2;
        }
      }
      $ngram = trim($ngram);
      //echo "<br>$ngram";
      if (array_key_exists($ngram, $ngram_array))
      {
        $ngram_array[$ngram]++;
      }
      else
      {
        $ngram_array[$ngram] = 1;
      }
    }
    return $ngram_array;
  }

  public function generateHistogram()
  {
    $x = $count;
    $y = $word;
    $bin_count = 0;
    $min = 0;
    $max = 0;
    $num_bins = 10;
    //https://www.statisticshowto.com/choose-bin-sizes-statistics/
  }

}

function testGenerateNGram($bg)
{
  $bg_result = $bg->generateNGram("The boy is playing football", 2);
  $expected = array(
    "the boy" => 1,
    "boy is" => 1,
    "is playing" => 1,
    "playing football" => 1,
  );
  assert($bg_result==$expected );
var_dump($bg_result);
  var_dump($expected);
}

function testGenerateTrigram($bg)
{
  $bg_result = $bg->generateNGram("The boy is playing football", 3);
  $expected = array(
    "the boy is" => 1,
    "boy is playing" => 1,
    "is playing football" => 1,
  );
  assert($bg_result==$expected );
  var_dump($bg_result);
  var_dump($expected);
}

$bg = new \BigramParser\BigramParser();
testGenerateNGram($bg);
testGenerateTrigram($bg);