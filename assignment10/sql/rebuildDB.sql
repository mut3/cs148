DROP TABLE IF EXISTS tblUser;
DROP TABLE IF EXISTS tblItem;
DROP TABLE IF EXISTS tblAdmin;
DROP TABLE IF EXISTS tblWannabeAdmin;
CREATE TABLE tblUser
(
	pmkUserId int NOT NULL AUTO_INCREMENT,
	fldUsername varchar(8) NOT NULL,
	fldEmail varchar(255),
	fldSciFi int,
	fldAdmin boolean,
	PRIMARY KEY(pmkUserId)
);
CREATE TABLE tblItem
(
	pmkItemId int NOT NULL AUTO_INCREMENT,
	fnkOwnerId int NOT NULL,
	fldItemName varchar(255) NOT NULL,
	PRIMARY KEY(pmkItemId)
);
CREATE TABLE tblAdmin
(
	pmkAdminId int NOT NULL AUTO_INCREMENT,
	fnkUserId int,
	fldAdminUsername varchar(8) NOT NULL,
	PRIMARY KEY(pmkAdminId)
);
CREATE TABLE tblWannabeAdmin
(
	pmkAdminId int NOT NULL AUTO_INCREMENT,
	fnkLuserId int,
	PRIMARY KEY(pmkAdminId, fnkLuserId)
);

INSERT INTO tblUser (fldUsername, fldEmail, fldSciFi, fldAdmin) VALUES
	('wbarnwel', 'wbarnwel@uvm.edu', 0, TRUE);

-- INSERT INTO tblItem (fnkOwnerId, fldItemName) VALUES
-- 	(0, 'Dread About This Project');

INSERT INTO tblAdmin (fnkUserId, fldAdminUsername) VALUES
	(NULL, 'wbarnwel'),
	(NULL, 'rerickso'),
	(NULL, 'adatta');