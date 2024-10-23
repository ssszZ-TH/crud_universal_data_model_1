-- Drop existing tables if they exist
DROP TABLE IF EXISTS MARITALSTATUSTYPE CASCADE;
DROP TABLE IF EXISTS MARITALSTATUS CASCADE;
DROP TABLE IF EXISTS PHYSICALCHARACTORISTICTYPE CASCADE;
DROP TABLE IF EXISTS PHYSICALCHARACTORISTIC CASCADE;
DROP TABLE IF EXISTS PERSONNAMETYPE CASCADE;
DROP TABLE IF EXISTS PERSONNAME CASCADE;
DROP TABLE IF EXISTS PERSON CASCADE;
DROP TABLE IF EXISTS CITIZENSHIP CASCADE;
DROP TABLE IF EXISTS COUNTRY CASCADE;
DROP TABLE IF EXISTS PASSPORT CASCADE;
DROP TABLE IF EXISTS GENDERTYPE CASCADE;

-- create table
CREATE TABLE MARITALSTATUSTYPE (maritalstatustypeid SERIAL NOT NULL, description varchar(20) NOT NULL, PRIMARY KEY (maritalstatustypeid));
CREATE TABLE MARITALSTATUS (maritalstatusid SERIAL NOT NULL, fromdate date NOT NULL, thrudate date, MARITALSTATUSTYPEmaritalstatustypeid int4 NOT NULL, PRIMARY KEY (maritalstatusid));
CREATE TABLE PHYSICALCHARACTORISTICTYPE (charactoristictypeid SERIAL NOT NULL, description varchar(20) NOT NULL, PRIMARY KEY (charactoristictypeid));
CREATE TABLE PHYSICALCHARACTORISTIC (physicalcharactoristicid SERIAL NOT NULL, fromdate date NOT NULL, thrudate date, value float4 NOT NULL, PHYSICALCHARACTORISTICTYPEcharactoristictypeid int4 NOT NULL, PRIMARY KEY (physicalcharactoristicid));
CREATE TABLE PERSONNAMETYPE (personnametypeid SERIAL NOT NULL, description varchar(20) NOT NULL, PRIMARY KEY (personnametypeid));
CREATE TABLE PERSONNAME (personnameid SERIAL NOT NULL, fromdate date NOT NULL, thrudate date, fullname varchar(255) NOT NULL, PERSONNAMETYPEpersonnametypeid int4 NOT NULL, PRIMARY KEY (personnameid));
CREATE TABLE PERSON (personid SERIAL NOT NULL, birthdate date NOT NULL, mothersmaidenname varchar(255), socialsecurityno varchar(20), totalyearworkexperience int4, comment varchar(255), MARITALSTATUSmaritalstatusid int4 NOT NULL, PHYSICALCHARACTORISTICphysicalcharactoristicid int4 NOT NULL, PERSONNAMEpersonnameid int4 NOT NULL, CITIZENSHIPcitizenshipid int4 NOT NULL, GENDERTYPEgendertypeid int4 NOT NULL, PRIMARY KEY (personid));
CREATE TABLE CITIZENSHIP (citizenshipid SERIAL NOT NULL, fromdate date NOT NULL, thrudate date, COUNTRYcountryid int4 NOT NULL, PASSPORTpassportid int4 NOT NULL, PRIMARY KEY (citizenshipid));
CREATE TABLE COUNTRY (countryid SERIAL NOT NULL, isocode char(2) NOT NULL, countryname varchar(20) NOT NULL, PRIMARY KEY (countryid));
CREATE TABLE PASSPORT (passportid SERIAL NOT NULL, pasportnum varchar(20) NOT NULL, fromdate date NOT NULL, thrudate date NOT NULL, PRIMARY KEY (passportid));
CREATE TABLE GENDERTYPE (gendertypeid SERIAL NOT NULL, gendercode char(1) NOT NULL, description varchar(255) NOT NULL, PRIMARY KEY (gendertypeid));
ALTER TABLE MARITALSTATUS ADD CONSTRAINT FKMARITALSTA641867 FOREIGN KEY (MARITALSTATUSTYPEmaritalstatustypeid) REFERENCES MARITALSTATUSTYPE (maritalstatustypeid);
ALTER TABLE PHYSICALCHARACTORISTIC ADD CONSTRAINT FKPHYSICALCH411680 FOREIGN KEY (PHYSICALCHARACTORISTICTYPEcharactoristictypeid) REFERENCES PHYSICALCHARACTORISTICTYPE (charactoristictypeid);
ALTER TABLE PERSONNAME ADD CONSTRAINT FKPERSONNAME804946 FOREIGN KEY (PERSONNAMETYPEpersonnametypeid) REFERENCES PERSONNAMETYPE (personnametypeid);
ALTER TABLE PERSON ADD CONSTRAINT FKPERSON252212 FOREIGN KEY (MARITALSTATUSmaritalstatusid) REFERENCES MARITALSTATUS (maritalstatusid);
ALTER TABLE PERSON ADD CONSTRAINT FKPERSON791048 FOREIGN KEY (PHYSICALCHARACTORISTICphysicalcharactoristicid) REFERENCES PHYSICALCHARACTORISTIC (physicalcharactoristicid);
ALTER TABLE PERSON ADD CONSTRAINT FKPERSON343508 FOREIGN KEY (PERSONNAMEpersonnameid) REFERENCES PERSONNAME (personnameid);
ALTER TABLE CITIZENSHIP ADD CONSTRAINT FKCITIZENSHI258123 FOREIGN KEY (COUNTRYcountryid) REFERENCES COUNTRY (countryid);
ALTER TABLE CITIZENSHIP ADD CONSTRAINT FKCITIZENSHI141419 FOREIGN KEY (PASSPORTpassportid) REFERENCES PASSPORT (passportid);
ALTER TABLE PERSON ADD CONSTRAINT FKPERSON74091 FOREIGN KEY (CITIZENSHIPcitizenshipid) REFERENCES CITIZENSHIP (citizenshipid);
ALTER TABLE PERSON ADD CONSTRAINT FKPERSON767757 FOREIGN KEY (GENDERTYPEgendertypeid) REFERENCES GENDERTYPE (gendertypeid);


-- insert example data

INSERT INTO MARITALSTATUSTYPE (description) VALUES
('Single'),
('Married'),
('Divorced'),
('Widowed'),
('Separated'),
('Engaged'),
('In a relationship'),
('Complicated'),
('Partnered'),
('Other');

INSERT INTO MARITALSTATUS (fromdate, thrudate, MARITALSTATUSTYPEmaritalstatustypeid) VALUES
('2020-01-01', '2021-01-01', 1),
('2021-02-01', NULL, 2),
('2019-03-15', '2020-02-15', 3),
('2022-04-10', NULL, 4),
('2018-05-20', '2019-05-20', 5),
('2023-06-25', NULL, 6),
('2017-07-30', '2018-07-30', 7),
('2022-08-05', NULL, 8),
('2021-09-12', '2022-09-12', 9),
('2023-10-18', NULL, 10);

INSERT INTO PHYSICALCHARACTORISTICTYPE (description) VALUES
('Height'),
('Weight'),
('Eye Color'),
('Hair Color'),
('Shoe Size'),
('Blood Type'),
('Skin Tone'),
('Body Type'),
('Handedness'),
('Vision');

INSERT INTO PHYSICALCHARACTORISTIC (fromdate, thrudate, value, PHYSICALCHARACTORISTICTYPEcharactoristictypeid) VALUES
('2022-01-01', NULL, 175.5, 1),
('2021-02-15', '2022-02-15', 70.3, 2),
('2020-03-20', NULL, 1, 3),
('2019-04-25', '2020-04-25', 2, 4),
('2023-05-30', NULL, 42, 5),
('2018-06-12', '2019-06-12', 0, 6),
('2021-07-05', NULL, 3, 7),
('2017-08-17', '2018-08-17', 2, 8),
('2022-09-21', NULL, 1, 9),
('2023-10-22', '2024-10-22', 1, 10);

INSERT INTO PERSONNAMETYPE (description) VALUES
('Full Name'),
('First Name'),
('Last Name'),
('Middle Name'),
('Nickname'),
('Alias'),
('Legal Name'),
('Previous Name'),
('Birth Name'),
('Adopted Name');

INSERT INTO PERSONNAME (fromdate, thrudate, fullname, PERSONNAMETYPEpersonnametypeid) VALUES
('2022-01-01', NULL, 'John Doe', 1),
('2021-02-15', '2022-02-15', 'Jane Smith', 2),
('2020-03-20', NULL, 'Robert Brown', 3),
('2019-04-25', '2020-04-25', 'Emily Davis', 4),
('2023-05-30', NULL, 'Michael Johnson', 5),
('2018-06-12', '2019-06-12', 'David Wilson', 6),
('2021-07-05', NULL, 'Mary Lee', 7),
('2017-08-17', '2018-08-17', 'Daniel Martinez', 8),
('2022-09-21', NULL, 'Sophia Garcia', 9),
('2023-10-22', '2024-10-22', 'Chris Robinson', 10);

INSERT INTO COUNTRY (isocode, countryname) VALUES
('US', 'United States'),
('CA', 'Canada'),
('GB', 'United Kingdom'),
('AU', 'Australia'),
('FR', 'France'),
('DE', 'Germany'),
('JP', 'Japan'),
('CN', 'China'),
('IN', 'India'),
('BR', 'Brazil');

INSERT INTO PASSPORT (pasportnum, fromdate, thrudate) VALUES
('A12345678', '2020-01-01', '2030-01-01'),
('B87654321', '2021-02-15', '2031-02-15'),
('C11223344', '2019-03-20', '2029-03-20'),
('D99887766', '2022-04-25', '2032-04-25'),
('E44556677', '2018-05-30', '2028-05-30'),
('F77889900', '2023-06-12', '2033-06-12'),
('G55667788', '2021-07-05', '2031-07-05'),
('H33221100', '2017-08-17', '2027-08-17'),
('I99887722', '2022-09-21', '2032-09-21'),
('J77665544', '2023-10-22', '2033-10-22');

INSERT INTO GENDERTYPE (gendercode, description) VALUES
('M', 'Male'),
('F', 'Female'),
('N', 'Non-binary'),
('O', 'Other'),
('P', 'Prefer not to say'),
('T', 'Transgender'),
('X', 'Genderqueer'),
('A', 'Agender'),
('B', 'Bigender'),
('G', 'Genderfluid');

INSERT INTO CITIZENSHIP (fromdate, thrudate, COUNTRYcountryid, PASSPORTpassportid) VALUES
('2020-01-01', NULL, 1, 1),
('2021-02-15', '2031-02-15', 2, 2),
('2019-03-20', '2029-03-20', 3, 3),
('2022-04-25', '2032-04-25', 4, 4),
('2018-05-30', '2028-05-30', 5, 5),
('2023-06-12', '2033-06-12', 6, 6),
('2021-07-05', '2031-07-05', 7, 7),
('2017-08-17', '2027-08-17', 8, 8),
('2022-09-21', '2032-09-21', 9, 9),
('2023-10-22', '2033-10-22', 10, 10);

INSERT INTO PERSON (birthdate, mothersmaidenname, socialsecurityno, totalyearworkexperience, comment, MARITALSTATUSmaritalstatusid, PHYSICALCHARACTORISTICphysicalcharactoristicid, PERSONNAMEpersonnameid, CITIZENSHIPcitizenshipid, GENDERTYPEgendertypeid) VALUES
('1990-01-01', 'Johnson', '123-45-6789', 10, 'No comments', 1, 1, 1, 1, 1),
('1985-02-15', 'Smith', '234-56-7890', 15, 'Employee of the Month', 2, 2, 2, 2, 2),
('1978-03-20', 'Brown', '345-67-8901', 20, 'Excellent performance', 3, 3, 3, 3, 3),
('1995-04-25', 'Davis', '456-78-9012', 5, 'Promising talent', 4, 4, 4, 4, 1),
('2000-05-30', 'Wilson', '567-89-0123', 2, 'Recent graduate', 5, 5, 5, 5, 2),
('1988-06-12', 'Taylor', '678-90-1234', 12, 'Punctual and reliable', 6, 6, 6, 6, 3),
('1975-07-05', 'Moore', '789-01-2345', 25, 'Veteran employee', 7, 7, 7, 7, 4),
('1993-08-17', 'Miller', '890-12-3456', 8, 'Team player', 8, 8, 8, 8, 5),
('1980-09-21', 'Garcia', '901-23-4567', 18, 'Good communication skills', 9, 9, 9, 9, 1),
('1998-10-22', 'Martinez', '012-34-5678', 4, 'Creative thinker', 10, 10, 10, 10, 2)
