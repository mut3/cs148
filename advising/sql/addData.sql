INSERT INTO tblStudents (pmkNetId, fldFirstName, fldMinit, fldLastName, fldEmail) VALUES
("wbarnwel", "Will", "", "Barnwell", "wbarnwel@uvm.edu");

INSERT INTO tblAdvisers (pmkNetId, fldFirstName, fldMinit, fldLastName, fldEmail) VALUES
("jlhorton", "Jacky", "L", "Horton", "jlhorton@uvm.edu");

INSERT INTO tbl4yPlan (fnkAdviserNetId, fnkStudentNetId, fldCatalogYear, fldMajor, fldMinor) VALUES
("jlhorton", "wbarnwel", 2013, "Computer Science", "-");

INSERT INTO tblSemesterPlan (fnkPlanId, fldYear, fldTerm, fldDisplayOrder) VALUES
(1, 2013, "Fa", 1),
(1, 2014, "Sp", 2);

INSERT INTO tblSemesterPlanCourses (fnkPlanId, fnkYear, fnkTerm, fnkCourseId, fldDisplayOrder) VALUES
(1, 2013, "Fa", 1, 1),
(1, 2013, "Fa", 2, 2),
(1, 2013, "Fa", 3, 3),
(1, 2013, "Fa", 4, 4),
(1, 2013, "Fa", 5, 5),
(1, 2014, "Sp", 6, 1),
(1, 2014, "Sp", 7, 2),
(1, 2014, "Sp", 8, 3),
(1, 2014, "Sp", 9, 4),
(1, 2014, "Sp", 10, 5),
;

INSERT INTO tblCourses (fldDepartment, fldNumber, fldName, fldCredits) VALUES
("CS", 008, "Intro to Web Design", "2"),
("CS", 021, "Intro to Programming: Python", "3"),
("ENG", 001, "Written Expression", "3"),
("EC", 011, "Micro Economics", "3"),
("MATH", 022, "Calculus II", "3"),
("EC", 012, "Macro Economics", "3"),
("CS", 064, "Discrete Math", "3"),
("CS", 110, "Intermediate Programming: Java", "3"),
("STAT", 151, "Applied Probability", "3"),
("CS", 142, "Surfing the Web with Bob", "3");
