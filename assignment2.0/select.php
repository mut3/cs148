<?php
    include "top.php";
?>
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
        <a href="?q=09">
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
<div class="half">
<?php
    switch ($_GET["q"]) {
        case 01:
            $columns = 1;
            $query = "SELECT pmkNetID FROM tblTeachers";
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 02:
            $columns = 1;
            $query = "SELECT fldDepartment FROM tblCourses WHERE fldCourseName LIKE 'introduction%'";
            $wheres = 1;
            $conditions = 0;
            $quotes = 2;
            $symbols = 0;
            break;
        case 03:
            $columns = 12;
            $query = "SELECT * FROM tblSections WHERE fldStart='13:10:00' AND fldBuilding='KALKIN'";
            $wheres = 1;
            $conditions = 0;
            $quotes = 4;
            $symbols = 0;
            break;
        case 04:
            $columns = 12;
            $query = "SELECT * FROM tblSections WHERE fldCRN=91954";
            $wheres = 1;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 05:
            $columns = 2;
            $query = "SELECT fldFirstName,fldLastName FROM tblTeachers WHERE pmkNetID LIKE 'r%o'";
            $wheres = 1;
            $conditions = 0;
            $quotes = 2;
            $symbols = 0;
            break;
        case 06:
            $columns = 1;
            $query = "SELECT fldCourseName FROM tblCourses WHERE fldCourseName LIKE '%data%' AND NOT fldDepartment='CS'";
            $wheres = 1;
            $conditions = 0;
            $quotes = 4;
            $symbols = 0;
            break;
        case 07:
            $columns = 1;
            $query = "SELECT COUNT( DISTINCT fldDepartment) FROM tblCourses";
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 2;
            break;
        case 08:
            $columns = 2;
            $query = "SELECT fldBuilding, COUNT(fldSection) FROM tblSections GROUP BY fldBuilding";
            $wheres = 0;
            $conditions = 1;
            $quotes = 0;
            $symbols = 2;
            break;
        case 09:
            $columns = 2;
            $query = "SELECT fldBuilding,SUM(fldNumStudents) FROM tblSections WHERE fldDays LIKE '%W%' GROUP BY fldBuilding ORDER BY SUM(fldNumStudents) desc";
            $wheres = 1;
            $conditions = 1;
            $quotes = 2;
            $symbols = 0;
            break;
        case 10:
            $columns = 2;
            $query = "SELECT fldBuilding,SUM(fldNumStudents) FROM tblSections WHERE fldDays LIKE '%F%' GROUP BY fldBuilding ORDER BY SUM(fldNumStudents) desc";
            $wheres = 1;
            $conditions = 1;
            $quotes = 2;
            $symbols = 0;
            break;
        case 11:
            $columns = 2;
            $query = "";
            $wheres = 0;
            $conditions = 0;
            $quotes = 0;
            $symbols = 0;
            break;
        case 12:
            $columns = 2;
            $query = "";
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
print '</div>';
include "footer.php";
?>
