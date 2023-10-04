UPDATE `work_experience` SET `From` = replace(`From`, '/', '-');
UPDATE `work_experience` SET `To` = replace(`To`, '/', '-');
UPDATE `work_experience` SET `To`=NULL WHERE `To`='present';
UPDATE `work_experience` SET `To`=NULL WHERE `To`='';