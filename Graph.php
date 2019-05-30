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
class Graph
{
    private $width = 0;
    private $height = 0;
    private $title = "";
    private $label_x = "";
    private $label_y = "";
    private $increment_y = 0;
  
    /**
     * Description
     */
    public function __construct() 
    {
        $this->setWidth(500);
        $this->setHeight(500);
        $this->setLabelX("Count");
        $this->setLabelY("Bigram");
        $this->setTitle("Bigram Histogram");
    }

    //Getters/setters
    /**
     * Description
     * 
     * @param type $width Description
     * 
     * @return type Description
     */
    public function setWidth($width) 
    {
        if (is_numeric($width) && $width >= 0) {
            $this->width = $width;
        }
    }

    /**
     * Description
     * 
     * @param type $height Description
     * 
     * @return type Description
     */
    public function setHeight($height) 
    {
        if (is_numeric($height) && $height >= 0) {
            $this->height = $height;
        }
    }

    /**
     * Description
     * 
     * @param type $label_x Description
     * 
     * @return type Description
     */
    public function setLabelX($label_x) 
    {
        if (is_string($label_x)) {
            $this->label_x = $label_x;
        }
    }

    /**
     * Description
     * 
     * @param type $label_y Description
     * 
     * @return type Description
     */
    public function setLabelY($label_y) 
    {
        if (is_string($label_y)) {
            $this->label_y = $label_y;
        }
    }

    /**
     * Description
     * 
     * @param type $title Description
     * 
     * @return type Description
     */
    public function setTitle($title) 
    {
        if (is_string($title)) {
            $this->title = $title;
        }
    }

    /**
     * Description
     * 
     * @param type $data Description
     * 
     * @return \PHPlot
     */
    public function plot($data) 
    {
        if (is_array($data) && count($data) > 0) {
            if (class_exists("PHPlot")) {
                $this->increment_y = $this->calculateIncrement($data);


                $graph = new \PHPlot($this->width, $this->height); 
                if ($graph) {
                    $this->setGraphOptions($graph);

                    //Set the data
                    $graph->SetDataValues($data);
                    $graph->DrawGraph();
                    return $graph;
        
                } else {
                    error("Cannot create PHPlot object", "Graph.plot");
                }
            } else {
                error("Class PHPlot does not exist", "Graph.plot");
            }
        } else {
            error("data array not set", "Graph.plot");
        }


    }

    /**
     * Description
     * 
     * @param type $data Description
     * 
     * @return string
     */
    public function htmlTextOutput($data) 
    {
        $content = "<table><tr><th>Pair</th><th>Count</th></tr>";
        if (is_array($data)) {
            foreach ($data as $pair => $count) {
                $content .= "<tr><td>$pair</td><td>$count</td></tr>";
            }
        }
        $content .= "</table>";
        return $content;
    }

    /**
     * Description
     * 
     * @param type $graph Description
     * 
     * @return type
     */
    public function htmlImageOutput($graph) 
    {
        $encode = $graph->EncodeImage();
        if ($encode) {
            return "<img src='$encode'  alt='graph'>";
        }
        else {
            error("Cannot get encoded graph data", "Graph.htmlOutput");
        }
    }

    /**
     * Description 
     * 
     * @param type $graph Description
     * 
     * @return type Description
     */
    private function setGraphOptions($graph) 
    {
        $graph->SetPlotType("thinbarline");
        $graph->SetDataType("text-data-yx");
        //Labels
        $graph->setTitle($this->title);
        $graph->SetXLabel($this->label_x);
        $graph->SetYLabel($this->label_y);

        //Format 
        //$graph->SetXLabelAngle(90);
        $graph->SetXTickIncrement(1);

        $graph->SetPrintImage(false);
        $graph->SetYTickIncrement($this->increment_y);


    }

    /**
     * Description
     * 
     * @param type $data Description
     * 
     * @return int
     */
    private function calculateIncrement($data) 
    {
        //TODO: calculate based on data values
        return 1;
    }
}
