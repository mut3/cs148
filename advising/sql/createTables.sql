DROP TABLE IF EXISTS tblStudents, tblAdvisers, tbl4yPlan, tblSemesterPlan, tblSemesterPlanCourses, tblCourses;

CREATE TABLE IF NOT EXISTS tblStudents
(
  pmkNetId varchar(8) NOT NULL,
  fldFirstName varchar(63) NOT NULL,
  fldMinit varchar(7),
  fldLastName varchar(63) NOT NULL,
  fldEmail varchar(255) NOT NULL,
  PRIMARY KEY(pmkNetId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS tblAdvisers
(
  pmkAdvNetId varchar(8) NOT NULL,
  fldAdvFirstName varchar(63) NOT NULL,
  fldAdvMinit varchar(7),
  fldAdvLastName varchar(63) NOT NULL,
  fldAdvEmail varchar(255) NOT NULL,
  PRIMARY KEY(pmkAdvNetId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS tbl4yPlan
(
  pmkPlanId int NOT NULL AUTO_INCREMENT,
  fnkAdviserNetId varchar(8),
  fnkStudentNetId varchar(8),
  fldCreateDate Date NOT NULL,
  fldCatalogYear int(4) NOT NULL,
  fldMajor varchar(255) NOT NULL,
  fldMinor varchar(255),
  PRIMARY KEY(pmkPlanId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- CREATE TRIGGER tbl4yPlan BEFORE INSERT ON `tbl`
  -- FOR EACH ROW SET NEW.fldCreateDate = NOW();

CREATE TABLE IF NOT EXISTS tblSemesterPlan
(
  fnkPlanId int NOT NULL,
  fldYear int(4) NOT NULL,
  fldTerm char(2) NOT NULL,
  fldDisplayOrder tinyInt(2),
  PRIMARY KEY(fnkPlanId, fldYear, fldTerm)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS tblSemesterPlanCourses
(
  fnkPlanId int NOT NULL,
  fnkYear int(4) NOT NULL,
  fnkTerm char(2) NOT NULL,
  fnkCourseId int NOT NULL,
  fldDisplayOrder tinyInt(2),
  PRIMARY KEY(fnkPlanId, fnkYear, fnkTerm, fnkCourseId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS tblCourses
(
  pmkCourseId int NOT NULL AUTO_INCREMENT,
  fldDepartment varchar(4) NOT NULL,
  fldNumber int(3) NOT NULL,
  fldName varchar(255) NOT NULL,
  fldCredits tinyInt(1) NOT NULL,
  PRIMARY KEY(pmkCourseId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

