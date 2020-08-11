<?php

/**
 * Template file.
 *
 * PHP version 7
 *
 * @category Default
 * @package  BigramParser
 * @author   Allison Christiansen <allison@achristiansen.com>
 * @link    https://dev.achristiansen.com/BigramParser/
 */

?>

<!doctype html>
<html lang="en">
    <head>
      <title>Title</title>
      <link rel="stylesheet" type="text/css" href="public/css/bigramparser.css" />
    </head>

    <body>
        <div id="wrapper">
            <header>
                <div id="logo"><?php echo $output['logo']; ?></div>
                <nav><?php echo $output['navigation']; ?></nav>
            </header>

            <div id="output">
                <div>
                  <h3>Configuration</h3>
                  <div id="config"><?php echo $output['config']; ?></div>
                </div>

                <div>
                  <h3>Input</h3>
                  <div id="input"><pre><?php echo $output['input']; ?></pre></div>
                </div>

                <div>
                  <h3>Data</h3>
                  <div id="data"><?php echo $output['data']; ?></div>
                </div>

                <div>
                  <h3>Graph</h3>
                  <div id="graph"><?php echo $output['graph']; ?></div>
                </div>

            </div>

            <footer>
                <?php echo $output['footer']; ?>
            </footer>
        </div>

    </body>
</html>
