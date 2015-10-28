INSERT INTO tblStudents (pmkNetId, fldFirstName, fldMinit, fldLastName, fldEmail) VALUES
("wbarnwel", "Will", "", "Barnwell", "wbarnwel@uvm.edu");

INSERT INTO tblAdvisers (pmkNetId, fldFirstName, fldMinit, fldLastName, fldEmail) VALUES
("jlhorton", "Jacky", "L", "Horton", "jlhorton@uvm.edu");

INSERT INTO tbl4yPlan (fnkAdviserNetId, fnkStudentNetId, fldCatalogYear, fldMajor, fldMinor) VALUES
("jlhorton", "wbarnwel", 2013, "Computer Science", "-");

INSERT INTO tblSemesterPlan (fnkPlanId, fldYear, fldTerm, fldDisplayOrder) VALUES
(SELECT pmkId FROM tbl4yPlan WHERE fnkStudentNetId="wbarnwel", 2013, "Fa", 1);

INSERT INTO tblSemesterPlanCourses (fnkPlanId, fnkYear, fnkTerm, fnkCourseId, fldDisplayOrder) VALUES
(SELECT pmkId FROM tbl4yPlan WHERE fnkStudentNetId="wbarnwel", 2013, "Fa", SELECT pmkId FROM tblCourses WHERE fldDepartment="CS" AND fldNumber=008, 1);

INSERT INTO tblCourses (fldDepartment, fldNumber, fldName, fldCredits) VALUES
("CS", 008, "Intro to Web Design", "2");
