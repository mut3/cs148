<?php
    include "top.php";
    $startRec = 0;
    $numRec = 10;
    $startRec =(int) $_GET["startRecord"];
    $numRec =(int) $_GET["numRecord"];
    if ($startRec < 0){$startRec = 0;}
    $vars = "";
    $columns = 8;
    $query = "SELECT * FROM tblStudents ORDER BY fldLastName, fldFirstName LIMIT " . $startRec . "," . $numRec;
    $wheres = 0;
    $conditions = 1;
    $quotes = 0;
    $symbols = 0;

echo '<div class="half">';
    
echo '<p>';
echo $query;
echo '</p>';

echo '<a href="?numRecord=' . $numRec . '&startRecord=' . ($startRec - 10) . '"> Prev 10</a>';
echo '<a href="?numRecord=' . $numRec . '&startRecord=' . ($startRec + 10) . '"> Next 10 </a>';

echo '</div>';
echo '<div class="half">';

    
    
    $thisDatabaseReader->testQuery($query, $vars, $wheres, $conditions, $quotes, $symbols);
    $info2 = $thisDatabaseReader->select($query, $vars, $wheres, $conditions, $quotes, $symbols);
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
