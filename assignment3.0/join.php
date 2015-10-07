<?php
    include "top.php";

    $queries = [];
    foreach (new DirectoryIterator('queries/') as $file) {
        if($file->isDot()) continue;
        $fileName = $file->getFilename();
        $fileNum = substr($fileName, 1, -4);
        $fileLoc = "./queries/" . $fileName;
        $queries[$fileNum] = file_get_contents("./queries/" . $fileName);
    }
    ksort($queries);
    echo '<div class="half">';

    foreach ($queries as $qNum => $q) {
        echo '<p class = "query"> q' . $qNum . '. <a href="?q=' . $qNum .'"> SQL: </a> ' . $q . ' </p>';
    }
    echo "</div>";
    echo '<div class="half">';
    // echo $_GET["q"];

    $query = $queries[$_GET["q"]];

    switch ($_GET["q"]) {
        case 01:
            $columns = 1;
            $wheres = 1;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 02:
            $columns = 3;
            $wheres = 1;
            $conditions = 1;
            $quotes = 4;
            $symbols = 0;
            break;
        case 03:
            $columns = 4;
            $wheres = 1;
            $conditions = 0;
            $quotes = 2;
            $symbols = 0;
            break;
        case 04:
            $columns = 3;
            $wheres = 1;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 05:
            $columns = 4;
            $wheres = 1;
            $conditions = 2;
            $quotes = 2;
            $symbols = 0;
            break;
        case 06:
            $columns = 3;
            $wheres = 1;
            $conditions = 0;
            $quotes = 0;
            $symbols = 1;
            break;
        case 07:
            $columns = 1;
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 08:
            $columns = 2;
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
    }

    $thisDatabaseReader->testQuery($query, "", $wheres, $conditions, $quotes, $symbols);
    $info2 = $thisDatabaseReader->select($query, "", $wheres, $conditions, $quotes, $symbols);
    $headerFields = array_keys($info2[0]);
    // echo '<pre><p>';
    // print_r ($headerFields);
    // echo '</p></pre>';
    $headerArray = array_filter($headerFields, "is_string");
    // echo '<pre><p>';
    // print_r ($headerArray);
    // echo '</p></pre>';

    echo "<h2> Records: " . count($info2) . "</h2>";
    print '<table>';

    //header block
    print '<tr class="tblHeaders">';
    foreach ($headerArray as $key) {
        $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));
        $message = "";
        foreach ($camelCase as $one) {
            $message .= $one . " ";
        }
        print '<th>' . $message . '</th>';
    }
    print '</tr>';

    //data printed to table
    $highlight = 0; // used to highlight alternate rows
    foreach ($info2 as $rec) {
        $highlight++;
        if ($highlight % 2 != 0) {
            $style = ' odd ';
        } else {
            $style = ' even ';
        }
        print '<tr class="' . $style . '">';
        for ($i = 0; $i < $columns; $i++) {
            print '<td>' . $rec[$i] . '</td>';
        }
        print '</tr>';
    }
    print '</table>';
print '</div>';
include "footer.php";
?>
