<?php
// includes/database/eligibility.php

function eligibilities($id) {
  return query("SELECT `No` AS `no`, Carrer_Service AS eligibility, Rating AS rating, Date_of_Examination AS `date`, Place_of_Examination AS `place`, Number_of_Hour AS `license`, isapplicabledate AS isapplicable, Date_of_Validity AS `validity`, Emp_ID AS `id` FROM civil_service WHERE Emp_ID='{$id}' ORDER BY Date_of_Examination ASC;");
}

function eligibility($id, $no) {
  return query("SELECT `No` AS `no`, Carrer_Service AS eligibility, Rating AS rating, Date_of_Examination AS `date`, Place_of_Examination AS `place`, Number_of_Hour AS `license`, isapplicabledate AS isapplicable, Date_of_Validity AS `validity`, Emp_ID AS `id` FROM civil_service WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function create_eligibility($career, $rating, $exam_date, $exam_place, $license, $is_applicable, $validity, $id) {
  non_query("INSERT INTO civil_service (`Carrer_Service`, `Rating`, `Date_of_Examination`, `Place_of_Examination`, `Number_of_Hour`, `isapplicabledate`, `Date_of_Validity`, `Emp_ID`) VALUES ('{$career}', '{$rating}', '{$exam_date}', '{$exam_place}', '{$license}', '{$is_applicable}', '{$validity}', '{$id}');");
}

function update_eligibility($career, $rating, $exam_date, $exam_place, $license, $is_applicable, $validity, $id, $no) {
  non_query("UPDATE civil_service SET `Carrer_Service`='{$career}', `Rating`='{$rating}', `Date_of_Examination`='{$exam_date}', `Place_of_Examination`='{$exam_place}', `Number_of_Hour`='{$license}', `isapplicabledate`='{$is_applicable}', `Date_of_Validity`='{$validity}' WHERE `Emp_ID`='{$id}' AND `No`='{$no}' LIMIT 1;");
}

function delete_eligibility($id, $no) {
  non_query("DELETE FROM civil_service WHERE Emp_ID='{$id}' AND `No`='{$no}' LIMIT 1;");
}
?>