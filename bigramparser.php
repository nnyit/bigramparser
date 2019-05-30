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
class BigramParser
{
  
    //config options
    private $filename = "";
    private $charlist = "";
    private $text = "";
    private $use_file = false;
    private $devel = false;

    //class
    private $bp_file;
    private $bp_graph;
    private $bp_parse;

    //
    private $text_output;
    private $graph_output;
    private $error_output;

    /**
     * Description
     */
    function __construct() 
    {

    }

    /**
     * Description
     * 
     * @return type Description
     */
    function bpInit()
    {

        $files = array("File.php", "Graph.php", "Parse.php");
        $this->config();
        $this->includeFiles($files);
        $this->includeFiles(array("../phplot/phplot.php"));
        $this->setClasses();
        $this->process();

    }

    /**
     * Description
     * 
     * @return type
     */
    public function getTextOutput() 
    {
        return $this->text_output;
    }

    /**
     * Description
     * 
     * @return type
     */
    public function getGraphOutput() 
    {
        return $this->graph_output;
    }

    /**
     * Description
     * 
     * @return type
     */
    public function getErrorOutput() 
    {
          return $this->error_output;
    }

    /**
     * Description
     * 
     * @return type Description
     */
    public function setClasses() 
    {
        if (class_exists("BigramParser\File")) {
            $this->bp_file = new BigramParser\File();
        } else {
            error("Class does not exist BigramParser\File", "BigramParser.setClasses");
        }
        if (class_exists("BigramParser\Graph")) {
            $this->bp_graph = new BigramParser\Graph();
        }
        if (class_exists("BigramParser\Parse")) {
            $this->bp_parse = new BigramParser\Parse($this->charlist);
        }
    }

    /**
     * Description
     * 
     * @param type $files Description
     * @param type $path Description
     * 
     * @return type Description
     */
    function includeFiles($files, $path = "") 
    {
        if (is_array($files)) {
            foreach ($files as $file) {
                $filepath = $path . $file; 
                if (file_exists($filepath)) {
                    require_once $filepath;
                } else {
                    $this->error("File does not exist $filepath");
                }
            }
        }
    }


    /**
     * Description
     * 
     * @return type Description
     */
    public function process()
    {
        $this->config();

        if ($this->bp_parse && $this->bp_graph) {
            if ($this->use_file) {
                $this->readFile();
            } else {
                if (isset($this->text)) {
                    $this->bp_parse->addWords($this->text);
                }

            }
            $this->pairs = $this->bp_parse->getPairs();


            $transform = $this->bp_parse->transformPairs($this->pairs);

            $graph = $this->bp_graph->plot($transform);
            $this->graph_output = $this->bp_graph->htmlImageOutput($graph);
            $this->text_output = $this->bp_graph->htmlTextOutput($this->pairs);
            $this->error_output = "test";
        }
    }

    /**
     * Description
     * 
     * @return type Description
     */
    private function readFile() 
    {
        $handle = $this->bp_file->getFileHandle($this->filename);
        $this->bp_parse->addWordsFromFile($handle);
    }

    /**
     * Description
     * 
     * @return type Description
     */
    private function config() 
    {
        $keys = array("use_file", "filename", "charlist", "devel", "text");
        $json_array = array();
        if ($this->bp_file) {
            $json_array = $this->bp_file->getJSON("config.json");
        }
        if (is_array($json_array)) {
            foreach ($keys as $key) {
                if (array_key_exists($key, $json_array)) {
                    $this->{$key} = $json_array[$key];
                }
            }
        }
    }
}
