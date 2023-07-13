<?php
// includes/database/utility.php
function stationName($id) {
  $station = section($id, true);

  if (numRows($station) > 0) {
    return fetchAssoc($station)['name'];
  }

  $station = schoolByAlias($id);

  if (numRows($station) > 0) {
    return fetchAssoc($station)['name'];
  }

  $station = schoolById($id);

  if (numRows($station) > 0) {
    return fetchAssoc($station)['name'];
  }

  return $id;
}

function userName($id) {
  $users = employee($id);

  if (numRows($users) > 0) {
    $user = fetchAssoc($users);
    return toName($user['lname'], $user['fname'], $user['mname'], $user['ext'], true);
  }
  
  return $id;
}

function pdsProgress($id) {
  $progress = 35;

  if (numRows(educationalBackgrounds($id)) > 0) {
    $progress += 15;
  }

  if (numRows(eligibilities($id)) > 0) {
    $progress += 15;
  }

  if (numRows(experiences($id)) > 0) {
    $progress += 15;
  }

  if (numRows(learningAndDevelopments($id)) > 0) {
    $progress += 15;
  }

  if (numRows(specialSkills($id)) > 0) {
    $progress += 5;
  }

  return $progress;
}
?>