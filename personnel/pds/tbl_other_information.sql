CREATE TABLE `tbl_other_information` (
  `id` varchar(17) NOT NULL,
  `hasthirddegree` bit(1) NOT NULL DEFAULT 0,
  `hasfourthdegree` bit(1) NOT NULL DEFAULT 0,
  `relateddetails` varchar(50) NOT NULL,
  `wasguilty` bit(1) NOT NULL DEFAULT 0,
  `guiltydetails` varchar(50) NOT NULL,
  `wascharged` bit(1) NOT NULL DEFAULT 0,
  `datefiled` date NOT NULL DEFAULT 0,
  `casestatus` varchar(50) NOT NULL,
  `wasconvicted` bit(1) NOT NULL DEFAULT 0,
  `convicteddetails` varchar(50) NOT NULL,
  `wasseparated` bit(1) NOT NULL DEFAULT 0,
  `separateddetails` varchar(50) NOT NULL,
  `wascandidate` bit(1) NOT NULL DEFAULT 0,
  `candidatedetails` varchar(50) NOT NULL,
  `resigned` bit(1) NOT NULL DEFAULT 0,
  `resigneddetails` varchar(50) NOT NULL,
  `immigrant` bit(1) NOT NULL DEFAULT 0,
  `immigrantcountry` varchar(100) NOT NULL,
  `isindigenous` bit(1) NOT NULL DEFAULT 0,
  `indigenousspecify` varchar(50) NOT NULL,
  `isdifferentlyabled` bit(1) NOT NULL DEFAULT 0,
  `differentlyabledspecify` varchar(50) NOT NULL,
  `issoloparent` bit(1) NOT NULL DEFAULT 0,
  `soloparentspecify` varchar(50) NOT NULL,
  `cardtype` varchar(100) NOT NULL,
  `cardidno` varchar(20) NOT NULL,
  `carddate` date NOT NULL,
  `cardplace` varchar(300) NOT NULL
);

ALTER TABLE `tbl_other_information`
  ADD PRIMARY KEY (`id`);