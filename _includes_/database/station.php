<?php
# _includes_/database/station.php

function InsertStation($appointmentDate, $position, $station, $category, $office, $age, $employeeID) {
  DBNonQuery("INSERT INTO tbl_station VALUES (NULL, '$appointmentDate', '$position', '$station', '$category', '$office', '$age', '$employeeID');");
}
?>