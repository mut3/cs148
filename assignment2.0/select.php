<?php
    include "top.php";

    //List files here

    switch ($_GET["q"]) {
    case 01:
        $columns = 2;
        $query = 'SELECT * FROM tblSections';
        $args = ["", 1, 0, 0, 0, false, false];
        break;
    case 02:
        $columns = 2;
        $query = 'SELECT * FROM ' . $tableName;
        $args = '"", 0, 0, 0, 0, false, false';
        break;
    case 03:
        $columns = 2;
        $query = 'SELECT * FROM ' . $tableName;
        $args = '"", 0, 0, 0, 0, false, false';
        break;
    case 04:
        $columns = 2;
        $query = 'SELECT * FROM ' . $tableName;
        $args = '"", 0, 0, 0, 0, false, false';
        break;
    case 05:
        $columns = 2;
        $query = 'SELECT * FROM ' . $tableName;
        $args = '"", 0, 0, 0, 0, false, false';
        break;
    case 06:
        $columns = 2;
        $query = 'SELECT * FROM ' . $tableName;
        $args = '"", 0, 0, 0, 0, false, false';
        break;
    case 07:
        $columns = 2;
        $query = 'SELECT * FROM ' . $tableName;
        $args = '"", 0, 0, 0, 0, false, false';
        break;
    case 08:
        $columns = 2;
        $query = 'SELECT * FROM ' . $tableName;
        $args = '"", 0, 0, 0, 0, false, false';
        break;
    case 09:
        $columns = 2;
        $query = 'SELECT * FROM ' . $tableName;
        $args = '"", 0, 0, 0, 0, false, false';
        break;
    case 10:
        $columns = 2;
        $query = 'SELECT * FROM ' . $tableName;
        $args = '"", 0, 0, 0, 0, false, false';
        break;
    case 11:
        $columns = 2;
        $query = 'SELECT * FROM ' . $tableName;
        $args = '"", 0, 0, 0, 0, false, false';
        break;
    case 12:
        $columns = 2;
        $query = 'SELECT * FROM ' . $tableName;
        $args = '"", 0, 0, 0, 0, false, false';
        break;
    }
    
    
    $thisDatabaseReader->testQuery($query, $args);
    $info2 = $thisDatabaseReader->select($query, $args);
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