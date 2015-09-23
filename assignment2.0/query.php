<!DOCTYPE html>
<html lang="en">
    <head>
        <title>A SQL to my first site</title>
        <meta charset="utf-8">
        <meta name="author" content="Mark Me Wright">
        <meta name="description" content="A website edited for an assignment by a smartass college kid who thinks of himself as pretty funny.">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/sin/trunk/html5.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="css/base.css" type="text/css" media="screen">
        <?php
                if (!empty($_GET)) {
            $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
            foreach ($_GET as $key => $value) {
                $_GET[$key] = sanitize($value, false);
            }
        }
        ?>
    </head>
    <body>
    	<!-- Assignment Here -->
    	<?php
    		echo "<p><pre>$_GET['q']</pre></p>"
    	?>  
    </body>
</html>