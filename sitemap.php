<!DOCTYPE html>
<html lang="en"><head>
<title>Main Index</title>
<meta charset="utf-8">
<meta name="author" content="Will Barnwell wwbarnwell@gmail.com">
<meta name="description" content="Sitemap of Will Barnwell's CS148 folder">

<!--This is my favicon-->
<link rel="icon" href="favicon.ico">

<!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/sin/trunk/html5.js"></script>
<![endif]-->

</head>
    <body>
        <h1>Main Index</h1>
        <?php
            $path = '.';

            $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
            foreach($objects as $name => $object)
            {
                echo "<p>$name\n<p>";
            }
        ?>
    </body>
</html>