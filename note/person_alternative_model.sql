-- สลับฐานข้อมูลเป็น person_db
-- \c person_db

-- สร้างตาราง MaritalStatusType
CREATE TABLE MaritalStatusType (
    MaritalStatusTypeID SERIAL PRIMARY KEY,
    Description VARCHAR(255) NOT NULL
);

-- สร้างตาราง PhysicalCharacteristicType
CREATE TABLE PhysicalCharacteristicType (
    CharacteristicTypeID SERIAL PRIMARY KEY,
    Description VARCHAR(255) NOT NULL
);

-- สร้างตาราง PersonNameType
CREATE TABLE PersonNameType (
    PersonNameTypeID SERIAL PRIMARY KEY,
    Description VARCHAR(255) NOT NULL
);

-- สร้างตาราง GenderType
CREATE TABLE GenderType (
    GenderTypeID SERIAL PRIMARY KEY,
    GenderCode CHAR(1) NOT NULL,
    Description VARCHAR(255) NOT NULL
);

-- สร้างตาราง Country
CREATE TABLE Country (
    CountryID SERIAL PRIMARY KEY,
    ISOCode CHAR(2) NOT NULL,
    CountryName VARCHAR(255) NOT NULL
);



-- สร้างตาราง MaritalStatus
CREATE TABLE MaritalStatus (
    MaritalStatusID SERIAL PRIMARY KEY,
    MaritalStatusTypeID INT,
    FromDate DATE,
    ThruDate DATE,
    FOREIGN KEY (MaritalStatusTypeID) REFERENCES MaritalStatusType(MaritalStatusTypeID) ON DELETE SET NULL
);

-- สร้างตาราง PhysicalCharacteristic
CREATE TABLE PhysicalCharacteristic (
    PhysicalCharacteristicID SERIAL PRIMARY KEY,
    CharacteristicTypeID INT,
    FromDate DATE,
    ThruDate DATE,
    PhysicalCharacteristicValue INT,
    FOREIGN KEY (CharacteristicTypeID) REFERENCES PhysicalCharacteristicType(CharacteristicTypeID) ON DELETE SET NULL
);

-- สร้างตาราง PersonName
CREATE TABLE PersonName (
    PersonNameID SERIAL PRIMARY KEY,
    FromDate DATE,
    ThruDate DATE,
    FullName VARCHAR(255),
    PersonNameTypeID INT,
    FOREIGN KEY (PersonNameTypeID) REFERENCES PersonNameType(PersonNameTypeID) ON DELETE SET NULL
);

-- สร้างตาราง Passport
CREATE TABLE Passport (
    PassportID SERIAL PRIMARY KEY,
    PassportNum VARCHAR(50),
    IssueDate DATE,
    ExpirationDate DATE
);

-- สร้างตาราง Citizenship
CREATE TABLE Citizenship (
    CitizenshipID SERIAL PRIMARY KEY,
    FromDate DATE,
    ThruDate DATE,
    CountryID INT NOT NULL,
    FOREIGN KEY (CountryID) REFERENCES Country(CountryID) ON DELETE SET NULL,
    PassportID INT NOT NULL,
    FOREIGN KEY (PassportID) REFERENCES Passport(PassportID) ON DELETE SET NULL
);

-- สร้างตาราง Person
CREATE TABLE Person (
    PersonID SERIAL PRIMARY KEY,
    BirthDate DATE NOT NULL,
    MothersMaidenName VARCHAR(255),
    SocialSecurityNo VARCHAR(20),
    UNIQUE (SocialSecurityNo),
    TotalYearsWorkExperience INT,
    Comment VARCHAR(255),
    GenderTypeID INT,
    FOREIGN KEY (GenderTypeID) REFERENCES GenderType(GenderTypeID) ON DELETE SET NULL,
    CitizenshipID INT NOT NULL,
    FOREIGN KEY (CitizenshipID) REFERENCES Citizenship(CitizenshipID) ON DELETE SET NULL,
    PersonNameID INT NOT NULL,
    FOREIGN KEY (PersonNameID) REFERENCES PersonName(PersonNameID) ON DELETE SET NULL,
    PhysicalCharacteristicID INT NOT NULL,
    FOREIGN KEY (PhysicalCharacteristicID) REFERENCES PhysicalCharacteristic(PhysicalCharacteristicID) ON DELETE SET NULL,
    MaritalStatusID INT NOT NULL,
    FOREIGN KEY (MaritalStatusID) REFERENCES MaritalStatus(MaritalStatusID) ON DELETE SET NULL
);


/* insert data */

-- สลับฐานข้อมูลเป็น person_db

-- \c person_db

-- แทรกข้อมูลลงใน MaritalStatusType
-- เพิ่มข้อมูลลงในตาราง MaritalStatusType
INSERT INTO MaritalStatusType (Description) VALUES ('Single');
INSERT INTO MaritalStatusType (Description) VALUES ('Married');
INSERT INTO MaritalStatusType (Description) VALUES ('Divorced');
INSERT INTO MaritalStatusType (Description) VALUES ('Widowed');

-- เพิ่มข้อมูลลงในตาราง PhysicalCharacteristicType
INSERT INTO PhysicalCharacteristicType (Description) VALUES ('Height');
INSERT INTO PhysicalCharacteristicType (Description) VALUES ('Weight');
INSERT INTO PhysicalCharacteristicType (Description) VALUES ('Eye Color');
INSERT INTO PhysicalCharacteristicType (Description) VALUES ('Hair Color');

-- เพิ่มข้อมูลลงในตาราง PersonNameType
INSERT INTO PersonNameType (Description) VALUES ('Legal Name');
INSERT INTO PersonNameType (Description) VALUES ('Nick Name');

-- เพิ่มข้อมูลลงในตาราง GenderType
INSERT INTO GenderType (GenderCode, Description) VALUES ('M', 'Male');
INSERT INTO GenderType (GenderCode, Description) VALUES ('F', 'Female');
INSERT INTO GenderType (GenderCode, Description) VALUES ('O', 'Other');

-- เพิ่มข้อมูลลงในตาราง Country
INSERT INTO Country (ISOCode, CountryName) VALUES ('US', 'United States');
INSERT INTO Country (ISOCode, CountryName) VALUES ('CA', 'Canada');
INSERT INTO Country (ISOCode, CountryName) VALUES ('GB', 'United Kingdom');
INSERT INTO Country (ISOCode, CountryName) VALUES ('AU', 'Australia');

-- เพิ่มข้อมูลลงในตาราง MaritalStatus
INSERT INTO MaritalStatus (MaritalStatusTypeID, FromDate, ThruDate) VALUES (1, '2010-01-01', NULL);
INSERT INTO MaritalStatus (MaritalStatusTypeID, FromDate, ThruDate) VALUES (2, '2015-06-15', NULL);
INSERT INTO MaritalStatus (MaritalStatusTypeID, FromDate, ThruDate) VALUES (3, '2020-03-10', '2023-05-20');

-- เพิ่มข้อมูลลงในตาราง PhysicalCharacteristic
INSERT INTO PhysicalCharacteristic (CharacteristicTypeID, FromDate, ThruDate, PhysicalCharacteristicValue) VALUES (1, '2023-01-01', NULL, 180);
INSERT INTO PhysicalCharacteristic (CharacteristicTypeID, FromDate, ThruDate, PhysicalCharacteristicValue) VALUES (2, '2023-01-01', NULL, 75);
INSERT INTO PhysicalCharacteristic (CharacteristicTypeID, FromDate, ThruDate, PhysicalCharacteristicValue) VALUES (3, '2023-01-01', NULL, 2); -- 2 for Blue eyes
INSERT INTO PhysicalCharacteristic (CharacteristicTypeID, FromDate, ThruDate, PhysicalCharacteristicValue) VALUES (4, '2023-01-01', NULL, 1); -- 1 for Black hair

-- เพิ่มข้อมูลลงในตาราง PersonName
INSERT INTO PersonName (FromDate, ThruDate, FullName, PersonNameTypeID) VALUES ('2023-01-01', NULL, 'John Doe', 1);
INSERT INTO PersonName (FromDate, ThruDate, FullName, PersonNameTypeID) VALUES ('2023-01-01', NULL, 'Jane Smith', 1);
INSERT INTO PersonName (FromDate, ThruDate, FullName, PersonNameTypeID) VALUES ('2023-01-01', NULL, 'Johnny', 2);

-- เพิ่มข้อมูลลงในตาราง Passport
INSERT INTO Passport (PassportNum, IssueDate, ExpirationDate) VALUES ('123456789', '2020-01-01', '2030-01-01');
INSERT INTO Passport (PassportNum, IssueDate, ExpirationDate) VALUES ('987654321', '2021-02-15', '2031-02-15');

-- เพิ่มข้อมูลลงในตาราง Citizenship
INSERT INTO Citizenship (FromDate, ThruDate, CountryID, PassportID) VALUES ('2010-01-01', NULL, 1, 1);
INSERT INTO Citizenship (FromDate, ThruDate, CountryID, PassportID) VALUES ('2015-06-15', NULL, 2, 2);

-- เพิ่มข้อมูลลงในตาราง Person
INSERT INTO Person (BirthDate, MothersMaidenName, SocialSecurityNo, TotalYearsWorkExperience, Comment, GenderTypeID, CitizenshipID, PersonNameID, PhysicalCharacteristicID, MaritalStatusID)
VALUES ('1990-01-01', 'Doe', '123-45-6789', 10, 'No comments', 1, 1, 1, 1, 1);
INSERT INTO Person (BirthDate, MothersMaidenName, SocialSecurityNo, TotalYearsWorkExperience, Comment, GenderTypeID, CitizenshipID, PersonNameID, PhysicalCharacteristicID, MaritalStatusID)
VALUES ('1985-05-20', 'Smith', '987-65-4321', 15, 'No comments', 2, 2, 2, 2, 2);
