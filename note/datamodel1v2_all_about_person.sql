SELECT
    p.birthdate AS "Birth Date",
    p.mothersmaidenname AS "Mother's Maiden Name",
    p.socialsecurityno AS "Social Security Number",
    p.totalyearworkexperience AS "Total Years of Work Experience",
    p.comment AS "Comment",
    mst.description AS "Marital Status",
    pc.value AS "Physical Characteristic Value",
    pct.description AS "Physical Characteristic Type",
    pn.fullname AS "Full Name",
    pnt.description AS "Name Type",
    c.countryname AS "Country",
    pass.pasportnum AS "Passport Number",
    pass.fromdate AS "Passport From Date",
    pass.thrudate AS "Passport Thru Date",
    gt.gendercode AS "Gender",
    gt.description AS "Gender Description"
FROM
    PERSON p
-- JOIN Marital Status and Marital Status Type
LEFT JOIN MARITALSTATUS ms ON p.MARITALSTATUSmaritalstatusid = ms.maritalstatusid
LEFT JOIN MARITALSTATUSTYPE mst ON ms.MARITALSTATUSTYPEmaritalstatustypeid = mst.maritalstatustypeid
-- JOIN Physical Characteristic and Physical Characteristic Type
LEFT JOIN PHYSICALCHARACTORISTIC pc ON p.PHYSICALCHARACTORISTICphysicalcharactoristicid = pc.physicalcharactoristicid
LEFT JOIN PHYSICALCHARACTORISTICTYPE pct ON pc.PHYSICALCHARACTORISTICTYPEcharactoristictypeid = pct.charactoristictypeid
-- JOIN Person Name and Person Name Type
LEFT JOIN PERSONNAME pn ON p.PERSONNAMEpersonnameid = pn.personnameid
LEFT JOIN PERSONNAMETYPE pnt ON pn.PERSONNAMETYPEpersonnametypeid = pnt.personnametypeid
-- JOIN Citizenship, Country, and Passport
LEFT JOIN CITIZENSHIP ci ON p.CITIZENSHIPcitizenshipid = ci.citizenshipid
LEFT JOIN COUNTRY c ON ci.COUNTRYcountryid = c.countryid
LEFT JOIN PASSPORT pass ON ci.PASSPORTpassportid = pass.passportid
-- JOIN Gender Type
LEFT JOIN GENDERTYPE gt ON p.GENDERTYPEgendertypeid = gt.gendertypeid;
