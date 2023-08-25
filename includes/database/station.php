<?php
// includes/database/station.php
// tbl_station
function station($id) {
  return query("SELECT `No`, Emp_Position AS position_id, Emp_Station AS station_id, Emp_ID AS id FROM tbl_station WHERE Emp_ID='{$id}' ORDER BY Emp_DOA DESC LIMIT 1;");
}

function createStation($date, $stationId, $positionId, $id) {
  nonQuery("INSERT INTO tbl_station (`Emp_DOA`, Emp_Station, Emp_Position, Emp_ID) VALUES ('{$date}', '{$stationId}', '{$positionId}', '{$id}');");
}

function updateStation($date, $stationId, $positionId, $id) {
  nonQuery("UPDATE tbl_station SET `Emp_DOA`='{$date}', Emp_Position='{$positionId}', Emp_Station='{$stationId}' WHERE Emp_ID='{$id}';");
}

function updateStationID($newStationId, $oldStationId) {
  nonQuery("UPDATE tbl_station SET `Emp_Station`='{$newStationId}' WHERE `Emp_Station`='{$oldStationId}';");
}
?>