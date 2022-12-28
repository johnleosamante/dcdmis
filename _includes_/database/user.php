<?php
function GetUser($email, $password='') {
  if (strlen($password) === 0) {
    $sql = "SELECT usercode, username, position, Station AS station, `Status` AS activity, Link AS portal FROM tbl_user WHERE `username`='$email' LIMIT 1;";
  } else {
    $sql = "SELECT usercode, username, position, Station AS station, `Status` AS activity, Link AS portal FROM tbl_user WHERE `username`='$email' AND `password`='$password' LIMIT 1;";
  }

  return DBQuery($sql);
}

function UserLogin($userid, $dateTime) {
  DBNonQuery("UPDATE tbl_user SET Last_login='$dateTime', Current_Status='Online' WHERE usercode='$userid' LIMIT 1;");
}
?>