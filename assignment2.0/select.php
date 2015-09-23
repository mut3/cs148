<?php
    include "top.php";
?>
    <p>
        q01. 
        <a href="?q=01">
            SQL:
        </a>
        <?php 
            echo fopen("queries/q01.sql", "r");
            echo 00++;
        ?>
    </p>
<?php
    switch ($_GET["q"]) {
        case 01:
            $columns = 2;
            $query = 'SELECT * FROM tblSections';
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 02:
            $columns = 3;
            $query = 'SELECT * FROM ' . $tableName;
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 03:
            $columns = 2;
            $query = 'SELECT * FROM ' . $tableName;
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 04:
            $columns = 2;
            $query = 'SELECT * FROM ' . $tableName;
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 05:
            $columns = 2;
            $query = 'SELECT * FROM ' . $tableName;
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 06:
            $columns = 2;
            $query = 'SELECT * FROM ' . $tableName;
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 07:
            $columns = 2;
            $query = 'SELECT * FROM ' . $tableName;
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 08:
            $columns = 2;
            $query = 'SELECT * FROM ' . $tableName;
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 09:
            $columns = 2;
            $query = 'SELECT * FROM ' . $tableName;
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 10:
            $columns = 2;
            $query = 'SELECT * FROM ' . $tableName;
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 11:
            $columns = 2;
            $query = 'SELECT * FROM ' . $tableName;
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 12:
            $columns = 2;
            $query = 'SELECT * FROM ' . $tableName;
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
    }
    
    
    $thisDatabaseReader->testQuery($query, "", $wheres, $conditions, $quotes, $symbols);
    $info2 = $thisDatabaseReader->select($query, "", $wheres, $conditions, $quotes, $symbols);
    print '<table>';
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
?>