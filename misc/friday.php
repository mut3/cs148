<?php
    include "top.php";
?>
<div class="half">
    
    <p>
        SQL: SELECT * FROM tblStudents ORDER BY fldLastName, fldFirstName LIMIT 1000, 10
    </p>
    
</div>
<div class="half">
<?php
    
    $columns = 1;
    $query = "SELECT * FROM tblStudents ORDER BY fldLastName, fldFirstName LIMIT 1000, 10";
    $wheres = 0;
    $conditions = 0;
    $quotes = 0;
    $symbols = 0;
    
    $thisDatabaseReader->testQuery($query, "", $wheres, $conditions, $quotes, $symbols);
    $info2 = $thisDatabaseReader->select($query, "", $wheres, $conditions, $quotes, $symbols);
    $headerFields = array_keys($info2[0]);
    print_r ('<pre><p>' . $headerFields . '</p></pre>');
    $headerArray = array_filter($headerFields, "is_string");
    print_r ('<pre><p>' . $headerArray . '</p></pre>');

    echo "<h2> Records: " . count($info2) . "</h2>";
    print '<table>';

    //header block
    print '<tr class="tblHeaders">';
    foreach ($headerArray as $key) {
        $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));

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
