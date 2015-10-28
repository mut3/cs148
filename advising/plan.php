 <?php
    include "top.php";   

    $columns = 1;
    $wheres = 1;
    $conditions = 0;
    $quotes = 0;
    $symbols = 0;

    $query = "
        SELECT DISTINCT tblStudents.fldFirstName, tblStudents.fldLastName, tbl4yPlan.fldMajor, tbl4yPlan.fldMinor,
            tblAdvisors.fldAdvisorFirstName, tblAdvisors.fldAdvisorLastName, tblSemesterPlan.fnkYear, tblSemesterPlan.fnkTerm, tblCourses.fldCourseName, tblCourses.fldDepartment, tblCourses.fldCourseNumber 
            FROM tblCourses 
            INNER JOIN tblSemesterPlanCourses ON tblCourses.pmkCourseId = tblSemesterPlanCourses.fnkCourseId 
            INNER JOIN tblSemesterPlan ON tblSemesterPlanCourses.fnkTerm = tblSemesterPlan.fnkTerm AND tblSemesterPlanCourses.fnkYear = tblSemesterPlan.fnkYear 
            INNER JOIN tbl4yPlan ON tblSemesterPlan.fnkPlanId = tbl4yPlan.pmkPlanId 
            INNER JOIN tblStudents ON tbl4yPlan.fnkStudentNetId = tblStudents.pmkNetId 
            INNER JOIN tblAdvisors ON tbl4yPlan.fnkAdvisorNetId = tblAdvisors.pmkNetId 
            ORDER BY tblSemesterPlanCourses.fldDisplayOrder 
        ";
    echo '<div class="half">';

    echo "<pre>$query</pre>";

    echo "</div>";

    echo '<div class="half">';
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