SELECT fldFirstName, fldPhone, fldSalary FROM tblTeachers WHERE fldSalary < (SELECT avg(fldSalary) FROM tblTeachers) 
