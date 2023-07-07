ALTER TABLE `educational_background` ADD `ispresent` BOOLEAN NOT NULL AFTER `To`;

UPDATE `educational_background` SET `Level`='Graduate Studies' WHERE `Level`="Masteral" OR `Level`='Doctoral';

UPDATE `educational_background` SET `Level`='Secondary' WHERE `Level`="High School";