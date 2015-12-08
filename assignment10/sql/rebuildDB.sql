DROP TABLE IF EXISTS tblUser, tblItem;
CREATE TABLE tblUser
(
	pmkUserId int NOT NULL AUTO_INCREMENT,
	fldUsername varchar(8) NOT NULL,
	fldEmail varchar(255),
	fldAdmin boolean,
	PRIMARY KEY(pmkUserId)
);
CREATE TABLE tblItem
(
	pmkItemId int NOT NULL AUTO_INCREMENT,
	fnkOwnerId int NOT NULL,
	fldItemName varchar(255) NOT NULL,
	PRIMARY KEY(pmkItemId),
	CONSTRAINT fk_OwnerId FOREIGN KEY (fnkOwnerId) REFERENCES tblUser(pmkUserId)
);

-- INSERT INTO tblUser (fldUsername, fldEmail, fldAdmin) VALUES
-- 	('wbarnwel', 'wbarnwel@uvm.edu', TRUE);

-- INSERT INTO tblItem (fnkOwnerId, fldItemName) VALUES
-- 	(0, 'Dread About This Project');