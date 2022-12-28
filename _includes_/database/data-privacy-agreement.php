<?php
# _includes_/database/data-privacy-agreement.php

function GetDataPrivacyAgreement($userID) {
  return DBQuery("SELECT * FROM tbl_data_privacy_aggrement WHERE Emp_ID='$userID';");
} 

function InsertDataPrivacyAgreement($dateTime, $userID, $clientIP) {
  DBNonQuery("INSERT INTO tbl_data_privacy_aggrement (date_time_aggreement, Emp_ID, Type_of_aggrement, IPAddressess) VALUES ('$dateTime', '$userID', 'Login', '$clientIP');");
}
?>