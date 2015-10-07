<?php
    include "top.php";

    $queries = [];
    $i = 1;
    foreach (new DirectoryIterator('queries/') as $file) {
        if($file->isDot()) continue;
        $fileHandle = fopen($file->getFilename(), "r");
        $queries[$i] = fread($fileHandle, filesize($file->getFilename()));
        fclose($fileHandle);
    }

    print_r($queries);

    echo '<div class="half">';

    for ($i=1; $i < count($queries)+1; $i++) { 
        echo '<p> q' . $i . '. <a href="?q=' . $i .'"> SQL: </a> ' . $queries[$i] . ' </p>';
    }
?>
<!-- 
<div class="half">
    
    <p>
        q01. 
        <a href="?q=01">
            SQL:
        </a>
        SELECT pmkNetID FROM tblTeachers
    </p>
    
    <p>
        q02. 
        <a href="?q=02">
            SQL:
        </a>
        SELECT fldDepartment FROM tblCourses WHERE fldCourseName LIKE 'introduction%'
    </p>
    
    <p>
        q03. 
        <a href="?q=03">
            SQL:
        </a>
        SELECT * FROM tblSections WHERE fldStart='13:10:00' AND fldBuilding='KALKIN'
    </p>
    
    <p>
        q04. 
        <a href="?q=04">
            SQL:
        </a>
        SELECT * FROM tblSections WHERE fldCRN=91954
    </p>
    
    <p>
        q05. 
        <a href="?q=05">
            SQL:
        </a>
        SELECT fldFirstName,fldLastName FROM tblTeachers WHERE pmkNetID LIKE 'r%o'
    </p>
    
    <p>
        q06. 
        <a href="?q=06">
            SQL:
        </a>
        SELECT fldCourseName FROM tblCourses WHERE fldCourseName LIKE '%data%' AND NOT fldDepartment='CS'
    </p>
    
    <p>
        q07. 
        <a href="?q=07">
            SQL:
        </a>
        SELECT COUNT( DISTINCT fldDepartment) FROM tblCourses
    </p>
    
    <p>
        q08. 
        <a href="?q=08">
            SQL:
        </a>
        SELECT fldBuilding, COUNT(fldSection) FROM tblSections GROUP BY fldBuilding
    </p>
    
    <p>
        q09. 
        <a href="?q=9">
            SQL:
        </a>
        SELECT fldBuilding,SUM(fldNumStudents) FROM tblSections WHERE fldDays LIKE '%W%' GROUP BY fldBuilding ORDER BY SUM(fldNumStudents) desc
    </p>
    
    <p>
        q10. 
        <a href="?q=10">
            SQL:
        </a>
        SELECT fldBuilding,SUM(fldNumStudents) FROM tblSections WHERE fldDays LIKE '%F%' GROUP BY fldBuilding ORDER BY SUM(fldNumStudents) desc
    </p>
    
    <p>
        q11. 
        <a href="?q=11">
            SQL:
        </a>
        
    </p>
    
    <p>
        q12. 
        <a href="?q=12">
            SQL:
        </a>
        
    </p>
</div>
 -->
 <?php
    echo "</div>";
    echo '<div class="half">';
    // echo $_GET["q"];
    switch ($_GET["q"]) {
        case 01:
            $columns = 1;
            $query = $queries[1];
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 02:
            $columns = 1;
            $query = $queries[2];
            $wheres = 1;
            $conditions = 0;
            $quotes = 2;
            $symbols = 0;
            break;
        case 03:
            $columns = 12;
            $query = $queries[3];
            $wheres = 1;
            $conditions = 1;
            $quotes = 4;
            $symbols = 0;
            break;
        case 04:
            $columns = 12;
            $query = $queries[4];
            $wheres = 1;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 05:
            $columns = 2;
            $query = $queries[5];
            $wheres = 1;
            $conditions = 0;
            $quotes = 2;
            $symbols = 0;
            break;
        case 06:
            $columns = 1;
            $query = $queries[6];
            $wheres = 1;
            $conditions = 2;
            $quotes = 4;
            $symbols = 0;
            break;
        case 07:
            $columns = 1;
            $query = $queries[7];
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 8:
            $columns = 2;
            $query = $queries[8];
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
