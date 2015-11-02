 <?php
    include "top.php";   

    $columns = 17;
    $wheres = 0;
    $conditions = 2;
    $quotes = 0;
    $symbols = 0;

    $query = "
        SELECT DISTINCT tblStudent.fldFirstName, tblStudent.fldLastName, tbl4yPlan.fldMajor, tbl4yPlan.fldMinor,
            tblAdviser.fldAdvFirstName, tblAdviser.fldAdvLastName, tblSemesterPlan.fldYear, tblSemesterPlan.fldTerm, tblCourse.fldCourseName, tblCourse.fldDepartment, tblCourse.fldCourseNumber 
            FROM tblCourse 
            INNER JOIN tblSemesterPlanCourse ON tblCourse.pmkCourseId = tblSemesterPlanCourse.fnkCourseId 
            INNER JOIN tblSemesterPlan ON tblSemesterPlanCourse.fnkTerm = tblSemesterPlan.fldTerm AND tblSemesterPlanCourse.fnkYear = tblSemesterPlan.fldYear 
            INNER JOIN tbl4yPlan ON tblSemesterPlan.fnkPlanId = tbl4yPlan.pmkPlanId 
            INNER JOIN tblStudent ON tbl4yPlan.fnkStudentNetId = tblStudent.pmkNetId 
            INNER JOIN tblAdviser ON tbl4yPlan.fnkAdviserNetId = tblAdviser.pmkAdvNetId 
            ORDER BY tblSemesterPlanCourse.fldDisplayOrder 
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

print '<div>';

//print plan in proper format

//initialize both credit counters

//initialize currentTerm to blank

//grab semseter started

//foreach row in record array
foreach ($info2 as $row) {
    //if new term close previous term, open new turn
    $thisTerm = $row['fldTerm'] . $row['fldYear'];
    if ($thisTerm != $currentTerm) {
        //if beginning of plan dont close previous block as it doesnt exist
        if ($currentTerm != '') {
            //close previous block
        }
        $currentTerm = $thisTerm;
        //open new block
    }
    //print out row contents
    //add to credit counters
}
//close last block
//print total credits
print '</div>';


include "footer.php";
?>

