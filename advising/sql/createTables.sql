DROP TABLE IF EXISTS tblStudents, tblAdvisers, tbl4yPlan, tblSemesterPlan, tblSemesterPlanCourses, tblCourses;

CREATE TABLE IF NOT EXISTS tblStudents
(
  pmkId int NOT NULL AUTO_INCREMENT,
  fldFirstName varchar(63) NOT NULL,
  fldMinit varchar(7),
  fldLastName varchar(63) NOT NULL,
  fldEmail varchar(255) NOT NULL,
  PRIMARY KEY(pmkId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS tblAdvisers
(
  pmkId int NOT NULL AUTO_INCREMENT,
  fldFirstName varchar(63) NOT NULL,
  fldMinit varchar(7),
  fldLastName varchar(63) NOT NULL,
  fldEmail varchar(255) NOT NULL,
  PRIMARY KEY(pmkId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS tbl4yPlan
(
  pmkId int NOT NULL AUTO_INCREMENT,
  fldCreateDate Date NOT NULL,
  fldCatalogYear tinyInt(4) NOT NULL,
  fldMajor varchar(255) NOT NULL,
  fldMinor varchar(255),
  PRIMARY KEY(pmkId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TRIGGER tbl4yPlan BEFORE INSERT ON `tbl`
  FOR EACH ROW SET NEW.fldCreateDate = NOW() ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS tblSemesterPlan
(
  fnkPlanId int NOT NULL,
  fldYear tinyInt(4) NOT NULL,
  fldTerm char(2) NOT NULL,
  fldDisplayOrder tinyInt(2),
  PRIMARY KEY(fnkPlanId, fldYear, fldTerm)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS tblSemesterPlanCourses
(
  fnkPlanId int NOT NULL,
  fnkYear tinyInt(4) NOT NULL,
  fnkTerm char(2) NOT NULL,
  fnkCourseId int NOT NULL,
  fldDisplayOrder tinyInt(2),
  PRIMARY KEY(fnkPlanId, fnkYear, fnkTerm, fnkCourseId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS tblCourses
(
  pmkId int NOT NULL AUTO_INCREMENT,
  fldDepartment varchar(4) NOT NULL,
  fldNumber tinyInt(3) NOT NULL,
  fldName varchar(255) NOT NULL,
  fldCredits tinyInt(1) NOT NULL,
  PRIMARY KEY(pmkId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
