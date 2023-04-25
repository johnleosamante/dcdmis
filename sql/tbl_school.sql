ALTER TABLE `tbl_school` ADD `telephone` VARCHAR(100) NOT NULL AFTER `SchoolLogo`, ADD `email` VARCHAR(100) NOT NULL AFTER `telephone`, ADD `website` VARCHAR(100) NOT NULL AFTER `email`, ADD `fb_page` VARCHAR(100) NOT NULL AFTER `website`;

UPDATE tbl_school SET SchoolLogo='assets/img/division.png';

UPDATE tbl_school SET SchoolLogo='assets/img/division.png', telephone='(065) 908-2583', email='dipolog.city@deped.gov.ph', website='https://dipologcitydivision.net', fb_page='https://facebook.com/depeddipologcity' WHERE SchoolID='143';