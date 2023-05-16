<?php
// modules/employees/view/other-information.php

$other_information = other_information($employee['id']);

$hasThirdDegree = $hasFourthDegree = $wasGuilty = $wasCharged = $wasConvicted = $wasSeparated = $wasCandidate = $resigned = $immigrant = $isIndigenous = $isDifferentlyAbled = $isSoloParent = '0';
$relatedDetails = $guiltyDetails = $caseStatus = $convictedDetails = $separatedDetails = $candidateDetails = $resignedDetails = $immigrantCountry = $isIndigenousSpecify = $isDifferentlyAbledSpecify = $soloParentSpecify = '';
$dateFiled = '0001-01-01';

if (num_rows($other_information) > 0) {
  $information = fetch_assoc($other_information);
  $hasThirdDegree = $information['hasthirddegree'];
  $hasFourthDegree = $information['hasfourthdegree'];
  $relatedDetails = $information['relateddetails'];
  $wasGuilty = $information['wasguilty'];
  $guiltyDetails = $information['guiltydetails'];
  $wasCharged = $information['wascharged'];
  $dateFiled = to_date($information['datefiled'], '', "Y-m-d");
  $caseStatus = $information['casestatus'];
  $wasConvicted = $information['wasconvicted'];
  $convictedDetails = $information['convicteddetails'];
  $wasSeparated = $information['wasseparated'];
  $separatedDetails = $information['separateddetails'];
  $wasCandidate = $information['wascandidate'];
  $candidateDetails = $information['candidatedetails'];
  $resigned = $information['resigned'];
  $resignedDetails = $information['resigneddetails'];
  $immigrant = $information['immigrant'];
  $immigrantCountry = $information['immigrantcountry'];
  $isIndigenous = $information['isindigenous'];
  $isIndigenousSpecify = $information['indigenousspecify'];
  $isDifferentlyAbled = $information['isdifferentlyabled'];
  $isDifferentlyAbledSpecify = $information['differentlyabledspecify'];
  $isSoloParent = $information['issoloparent'];
  $soloParentSpecify = $information['soloparentspecify'];
}
?>

<div class="tab-pane fade<?php echo set_active_navigation(isset($_SESSION[alias() . '_pds_tab']) && $_SESSION[alias() . '_pds_tab'] === 'other-information', 'show active'); ?>" id="other-information">
  <div class="row my-3">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered mb-0">
        <tbody>
          <tr>
            <td width="100%">
              <p class="mb-1">Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed,</p>
              <ol type="a" class="mb-0">
                <li>within the third degree?
                  <div class="py-1">
                    <input id="hasThirdDegreeYes" type="radio" value="1" <?php echo set_active_item($hasThirdDegree, '1', 'checked'); ?> disabled>
                    <label for="hasThirdDegreeYes" class="px-1 mr-3">Yes</label>

                    <input id="hasThirdDegreeNo" type="radio" value="0" <?php echo set_active_item($hasThirdDegree, '0', 'checked'); ?> disabled>
                    <label for="hasThirdDegreeNo" class="px-1">No</label>
                  </div>
                </li>

                <li>within the fourth degree (for Local Government Unit - Career Employees)?
                  <div class="py-1">
                    <input id="hasFourthDegreeYes" type="radio" value="1" <?php echo set_active_item($hasFourthDegree, '1', 'checked'); ?> disabled>
                    <label for="hasFourthDegreeYes" class="px-1 mr-3">Yes</label>

                    <input id="hasFourthDegreeNo" type="radio" value="0" <?php echo set_active_item($hasFourthDegree, '0', 'checked'); ?> disabled>
                    <label for="hasFourthDegreeNo" class="px-1">No</label>
                  </div>
                </li>
              </ol>

              <div class="form-group mb-0 pl-3">
                <label for="relatedDetails" class="m-0">If YES, give details:</label>
                <input id="relatedDetails" type="text" value="<?php echo $relatedDetails; ?>" class="form-control" readonly></label>
              </div>
            </td>
          </tr>

          <tr>
            <td width="100%">
              <ol type="a" class="pl-3 mb-0">
                <li>Have you ever been found guilty of any administrative offense?
                  <div class="py-1">
                    <input id="wasGuiltyYes" type="radio" value="1" <?php echo set_active_item($wasGuilty, '1', 'checked'); ?> disabled>
                    <label for="wasGuiltyYes" class="px-1 mr-3">Yes</label>

                    <input id="wasGuiltyNo" type="radio" value="0" <?php echo set_active_item($wasGuilty, '0', 'checked'); ?> disabled>
                    <label for="wasGuiltyNo" class="px-1">No</label>

                    <div class="form-group">
                      <label for="guiltyDetails" class="m-0">If YES, give details:</label>
                      <input id="guiltyDetails" type="text" value="<?php echo $guiltyDetails; ?>" class="form-control" readonly>
                    </div>
                  </div>
                </li>

                <li>Have you been criminally charged before any court?
                  <div class="py-1">
                    <input id="wasChargedYes" type="radio" value="1" <?php echo set_active_item($wasCharged, '1', 'checked'); ?> disabled>
                    <label for="wasChargedYes" class="px-1 mr-3">Yes</label>

                    <input id="wasChargedNo" type="radio" value="0" <?php echo set_active_item($wasCharged, '0', 'checked'); ?> disabled>
                    <label for="wasChargedNo" class="px-1">No</label>

                    <div class="mb-1">If YES, give details:</div>

                    <div class="form-group mb-2">
                      <label for="dateFiled" class="m-0">Date Filed:</label>
                      <input id="dateFiled" type="date" value="<?php echo $dateFiled; ?>" class="form-control" readonly>
                    </div>

                    <div class="form-group mb-0">
                      <label for="caseStatus" class="m-0">Status of Cases/s:</label>
                      <input id="caseStatus" type="text" value="<?php echo $caseStatus; ?>" class="form-control" readonly>
                    </div>
                  </div>
                </li>
              </ol>
            </td>
          </tr>

          <tr>
            <td width="100%">
              <p class="mb-1">Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?</p>

              <div class="pl-3">
                <input id="wasconvictedYes" type="radio" value="1" <?php echo set_active_item($wasConvicted, '1', 'checked'); ?> disabled>
                <label for="wasconvictedYes" class="px-1 mr-3">Yes</label>

                <input id="wasconvictedNo" type="radio" value="0" <?php echo set_active_item($wasConvicted, '0', 'checked'); ?> disabled>
                <label for="wasconvictedNo" class="px-1">No</label>

                <div class="form-group mb-0">
                  <label for="convictedDetails" class="mb-0">If YES, give details:</label>
                  <input id="convictedDetails" type="text" value="<?php echo $convictedDetails; ?>" class="form-control" readonly>
                </div>
              </div>
            </td>
          </tr>

          <tr>
            <td width="100%">
              <p class="mb-1">Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</p>

              <div class="pl-3">
                <input id="wasSeparatedYes" type="radio" value="1" <?php echo set_active_item($wasSeparated, '1', 'checked'); ?> disabled>
                <label for="wasSeparatedYes" class="px-1 mr-3">Yes</label>

                <input id="wasSeparatedNo" type="radio" value="0" <?php echo set_active_item($wasSeparated, '0', 'checked'); ?> disabled>
                <label for="wasSeparatedNo" class="px-1">No</label>

                <div class="form-group mb-0">
                  <label for="separatedDetails" class="mb-0">If YES, give details:</label>
                  <input id="separatedDetails" type="text" value="<?php echo $separatedDetails; ?>" class="form-control" readonly>
                </div>
              </div>
            </td>
          </tr>

          <tr>
            <td width="100%">
              <ol type="a" class="pl-3 mb-0">
                <li>Have you ever been a candidate in a national or local election (except Barangay election)?
                  <div class="my-1">
                    <input id="wasCandidateYes" type="radio" value="1" <?php echo set_active_item($wasCandidate, '1', 'checked'); ?> disabled>
                    <label for="wasCandidateYes" class="px-1 mr-3">Yes</label>

                    <input id="wasCandidateNo" type="radio" value="0" <?php echo set_active_item($wasCandidate, '0', 'checked'); ?> disabled>
                    <label for="wasCandidateNo" class="px-1">No</label>

                    <div class="form-group">
                      <label for="candidateDetails" class="m-0">If YES, give details:</label>
                      <input id="candidateDetails" type="text" value="<?php echo $candidateDetails; ?>" class="form-control" readonly>
                    </div>
                  </div>
                </li>

                <li>Have you resigned from the government service during the three (3)-month period the last election to promote/actively campaign for a national or local candidate?
                  <div class="my-1">
                    <input id="resignedYes" type="radio" value="1" <?php echo set_active_item($resigned, '1', 'checked'); ?> disabled>
                    <label for="resignedYes" class="px-1 mr-3">Yes</label>

                    <input id="resignedNo" type="radio" value="0" <?php echo set_active_item($resigned, '0', 'checked'); ?> disabled>
                    <label for="resignedNo" class="px-1">No</label>

                    <div class="form-group mb-0">
                      <label for="resignedDetails" class="m-0">If YES, give details:</label>
                      <input id="resignedDetails" type="text" value="<?php echo $resignedDetails; ?>" class="form-control" readonly>
                    </div>
                  </div>
                </li>
              </ol>
            </td>
          </tr>

          <tr>
            <td width="100%">
              <p class="mb-1">Have you acquired the status of an immigrant or permanent resident of another country?</p>

              <div class="pl-3">
                <input id="immigrantYes" type="radio" value="1" <?php echo set_active_item($immigrant, '1', 'checked'); ?> disabled>
                <label for="immigrantYes" class="px-1 mr-3">Yes</label>

                <input id="immigrantNo" type="radio" value="0" <?php echo set_active_item($immigrant, '0', 'checked'); ?> disabled>
                <label for="immigrantNo" class="px-1">No</label>

                <div class="form-group mb-0">
                  <label for="immigrantCountry" class="m-0">If YES, give details (country):</label>
                  <input id="immigrantCountry" type="text" value="<?php echo $immigrantCountry; ?>" class="form-control" readonly>
                </div>
              </div>
            </td>
          </tr>

          <tr>
            <td width="100%">
              <p class="mb-1">Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972); please answer the following items:</p>

              <ol type="a" class="mb-0">
                <li>Are you a member of any indigenous group?
                  <div class="my-1">
                    <input id="isIndigenousYes" type="radio" value="1" <?php echo set_active_item($isIndigenous, '1', 'checked'); ?> disabled>
                    <label for="isIndigenousYes" class="px-1 mr-3">Yes</label>

                    <input id="isIndigenousNo" type="radio" value="0" <?php echo set_active_item($isIndigenous, '0', 'checked'); ?> disabled>
                    <label for="isIndigenousNo" class="px-1">No</label>

                    <div class="form-group mb-0">
                      <label for="indigenousSpecify" class="m-0">If YES, please specify:</label>
                      <input id="indigenousSpecify" type="text" value="<?php echo $isIndigenousSpecify; ?>" class="form-control" readonly>
                    </div>
                  </div>
                </li>
                <li>Are you differently abled?
                  <div class="my-1">
                    <input id="isDifferentlyAbledYes" type="radio" value="1" <?php echo set_active_item($isDifferentlyAbled, '1', 'checked'); ?> disabled>
                    <label for="isDifferentlyAbledYes" class="px-1 mr-3">Yes</label>

                    <input id="isDifferentlyAbledNo" type="radio" value="0" <?php echo set_active_item($isDifferentlyAbled, '0', 'checked'); ?> disabled>
                    <label for="isDifferentlyAbledNo" class="px-1">No</label>

                    <div class="form-group mb-0">
                      <label for="differentlyAbledSpecify" class="m-0">If YES, please specify ID No:</label>
                      <input id="differentlyAbledSpecify" type="text" value="<?php echo $isDifferentlyAbledSpecify; ?>" class="form-control" readonly>
                    </div>
                  </div>
                </li>
                <li>Are you a solo parent?
                  <div class="my-1">
                    <input id="isSoloParentYes" type="radio" value="1" <?php echo set_active_item($isSoloParent, '1', 'checked'); ?> disabled>
                    <label for="isSoloParentYes" class="px-1 mr-3">Yes</label>

                    <input id="isSoloParentNo" type="radio" value="0" <?php echo set_active_item($isSoloParent, '0', 'checked'); ?> disabled>
                    <label for="isSoloParentNo" class="px-1">No</label>

                    <div class="form-group mb-0">
                      <label for="soloParentSpecify" class="m-0">If YES, please specify ID No:</label>
                      <input id="soloParentSpecify" type="text" value="<?php echo $soloParentSpecify; ?>" class="form-control" readonly>
                    </div>
                  </div>
                </li>
              </ol>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div><!-- .row -->
</div><!-- .tab-pane -->