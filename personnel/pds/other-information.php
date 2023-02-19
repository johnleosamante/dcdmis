<?php
$otherInformations = mysqli_query($con, "SELECT * FROM tbl_other_information WHERE Emp_ID='" . $_SESSION['EmpID'] . "' LIMIT 1;");

if (mysqli_num_rows($otherInformations) > 0) {
  $information = mysqli_fetch_assoc($otherInformations);
  $hasThirdDegree = $information['hasthirddegree'];
  $hasFourthDegree = $information['hasfourthdegree'];
  $relatedDetails = $information['relateddetails'];
  $wasGuilty = $information['wasguilty'];
  $guiltyDetails = $information['guiltydetails'];
  $wasCharged = $information['wascharged'];
  $dateFiled = ToDateString($information['datefiled'], '', "Y-m-d");
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
} else {
  $hasThirdDegree = $hasFourthDegree = $wasGuilty = $wasCharged = $wasConvicted = $wasSeparated = $wasCandidate = $resigned = $immigrant = $isIndigenous = $isDifferentlyAbled = $isSoloParent = '0';
  $relatedDetails = $guiltyDetails = $dateFiled = $caseStatus = $convictedDetails = $separatedDetails = $candidateDetails = $resignedDetails = $immigrantCountry = $isIndigenousSpecify = $isDifferentlyAbledSpecify = $soloParentSpecify = '';
}
?>

<div class="tab-pane fade<?php echo SetActiveNavigationTab(isset($_SESSION['pdstab']) && $_SESSION['pdstab'] === 'other-information'); ?>" id="other-information">
  <div class="d-sm-flex justify-content-between my-3">
    <h3 class="h4 mb-0">Other Information</h3>
  </div>

  <form class="row mt-3" action="" Method="POST" enctype="multipart/form-data">
    <div class="col table-responsive">
      <table width="100%" class="table table-striped table-bordered mb-0">
        <tbody>
          <tr>
            <td width="100%">
              <p class="mb-1">Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed,</p>
              <ol type="a" class="mb-0">
                <li>within the third degree?
                  <div class="py-1">
                    <input id="hasThirdDegreeYes" type="radio" name="hasThirdDegree" value="1" <?php echo SetRadioButtonChecked($hasThirdDegree === '1');
                                                                                                ?> required>
                    <label for="hasThirdDegreeYes" class="px-1 mr-3">Yes</label>

                    <input id="hasThirdDegreeNo" type="radio" name="hasThirdDegree" value="0" <?php echo SetRadioButtonChecked($hasThirdDegree === '0');
                                                                                              ?> required>
                    <label for="hasThirdDegreeNo" class="px-1">No</label>
                  </div>
                </li>

                <li>within the fourth degree (for Local Government Uniy - Career Employees)?
                  <div class="py-1">
                    <input id="hasFourthDegreeYes" type="radio" name="hasFourthDegree" value="1" <?php echo SetRadioButtonChecked($hasFourthDegree === '1');
                                                                                                  ?> required>
                    <label for="hasFourthDegreeYes" class="px-1 mr-3">Yes</label>

                    <input id="hasFourthDegreeNo" type="radio" name="hasFourthDegree" value="0" <?php echo SetRadioButtonChecked($hasFourthDegree === '0');
                                                                                                ?> required>
                    <label for="hasFourthDegreeNo" class="px-1">No</label>
                  </div>
                </li>
              </ol>

              <div class="form-group mb-0 pl-3">
                <label for="relatedDetails" class="m-0">If YES, give details:</label>
                <input id="relatedDetails" type="text" name="relatedDetails" value="<?php echo $relatedDetails;
                                                                                    ?>" class="form-control"></label>
              </div>
            </td>
          </tr>

          <tr>
            <td width="100%">
              <ol type="a" class="pl-3 mb-0">
                <li>Have you ever been found guilty of any administrative offense?
                  <div class="py-1">
                    <input id="wasGuiltyYes" type="radio" name="wasGuilty" value="1" <?php echo SetRadioButtonChecked($wasGuilty === '1');
                                                                                      ?> required>
                    <label for="wasGuiltyYes" class="px-1 mr-3">Yes</label>

                    <input id="wasGuiltyNo" type="radio" name="wasGuilty" value="0" <?php echo SetRadioButtonChecked($wasGuilty === '0');
                                                                                    ?> required>
                    <label for="wasGuiltyNo" class="px-1">No</label>

                    <div class="form-group">
                      <label for="guiltyDetails" class="m-0">If YES, give details:</label>
                      <input id="guiltyDetails" type="text" name="guiltyDetails" value="<?php echo $guiltyDetails;
                                                                                        ?>" class="form-control"></label>
                    </div>
                  </div>
                </li>

                <li>Have you been criminally charged before any court?
                  <div class="py-1">
                    <input id="wasChargedYes" type="radio" name="wasCharged" value="1" <?php echo SetRadioButtonChecked($wasCharged === '1');
                                                                                        ?> required>
                    <label for="wasChargedYes" class="px-1 mr-3">Yes</label>

                    <input id="wasChargedNo" type="radio" name="wasCharged" value="0" <?php echo SetRadioButtonChecked($wasCharged === '0');
                                                                                      ?> required>
                    <label for="wasChargedNo" class="px-1">No</label>

                    <div class="mb-1">If YES, give details:</div>

                    <div class="form-group mb-2">
                      <label for="dateFiled" class="m-0">Date Filed:</label>
                      <input id="dateFiled" type="date" name="dateFiled" value="<?php echo $dateFiled;
                                                                                ?>" class="form-control"></label>
                    </div>

                    <div class="form-group mb-0">
                      <label for="caseStatus" class="m-0">Status of Cases/s:</label>
                      <input id="caseStatus" type="text" name="caseStatus" value="<?php echo $caseStatus;
                                                                                  ?>" class="form-control"></label>
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
                <input id="wasconvictedYes" type="radio" name="wasConvicted" value="1" <?php echo SetRadioButtonChecked($wasConvicted === '1');
                                                                                        ?> required>
                <label for="wasconvictedYes" class="px-1 mr-3">Yes</label>

                <input id="wasconvictedNo" type="radio" name="wasConvicted" value="0" <?php echo SetRadioButtonChecked($wasConvicted === '0');
                                                                                      ?> required>
                <label for="wasconvictedNo" class="px-1">No</label>

                <div class="form-group mb-0">
                  <label for="convictedDetails" class="mb-0">If YES, give details:</label>
                  <input id="convictedDetails" type="text" name="convictedDetails" value="<?php echo $convictedDetails;
                                                                                          ?>" class="form-control"></label>
                </div>
              </div>
            </td>
          </tr>

          <tr>
            <td width="100%">
              <p class="mb-1">Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</p>

              <div class="pl-3">
                <input id="wasSeparatedYes" type="radio" name="wasSeparated" value="1" <?php echo SetRadioButtonChecked($wasSeparated === '1');
                                                                                        ?> required>
                <label for="wasSeparatedYes" class="px-1 mr-3">Yes</label>

                <input id="wasSeparatedNo" type="radio" name="wasSeparated" value="0" <?php echo SetRadioButtonChecked($wasSeparated === '0');
                                                                                      ?> required>
                <label for="wasSeparatedNo" class="px-1">No</label>

                <div class="form-group mb-0">
                  <label for="separatedDetails" class="mb-0">If YES, give details:</label>
                  <input id="separatedDetails" type="text" name="separatedDetails" value="<?php echo $separatedDetails;
                                                                                          ?>" class="form-control"></label>
                </div>
              </div>
            </td>
          </tr>

          <tr>
            <td width="100%">
              <ol type="a" class="pl-3 mb-0">
                <li>Have you ever been a candidate in a national or local election (except Barangay election)?
                  <div class="my-1">
                    <input id="wasCandidateYes" type="radio" name="wasCandidate" value="1" <?php echo SetRadioButtonChecked($wasCandidate === '1');
                                                                                            ?> required>
                    <label for="wasCandidateYes" class="px-1 mr-3">Yes</label>

                    <input id="wasCandidateNo" type="radio" name="wasCandidate" value="0" <?php echo SetRadioButtonChecked($wasCandidate === '0');
                                                                                          ?> required>
                    <label for="wasCandidateNo" class="px-1">No</label>

                    <div class="form-group">
                      <label for="candidateDetails" class="m-0">If YES, give details:</label>
                      <input id="candidateDetails" type="text" name="candidateDetails" value="<?php echo $candidateDetails;
                                                                                              ?>" class="form-control"></label>
                    </div>
                  </div>
                </li>

                <li>Have you resigned from the government service during the three (3)-month period the last election to promote/actively campaign for a national or local candidate?
                  <div class="my-1">
                    <input id="resignedYes" type="radio" name="resigned" value="1" <?php echo SetRadioButtonChecked($resigned === '1');
                                                                                    ?> required>
                    <label for="resignedYes" class="px-1 mr-3">Yes</label>

                    <input id="resignedNo" type="radio" name="resigned" value="0" <?php echo SetRadioButtonChecked($resigned === '0');
                                                                                  ?> required>
                    <label for="resignedNo" class="px-1">No</label>

                    <div class="form-group mb-0">
                      <label for="resignedDetails" class="m-0">If YES, give details:</label>
                      <input id="resignedDetails" type="text" name="resignedDetails" value="<?php echo $resignedDetails;
                                                                                            ?>" class="form-control"></label>
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
                <input id="immigrantYes" type="radio" name="immigrant" value="1" <?php echo SetRadioButtonChecked($immigrant === '1');
                                                                                  ?> required>
                <label for="immigrantYes" class="px-1 mr-3">Yes</label>

                <input id="immigrantNo" type="radio" name="immigrant" value="0" <?php echo SetRadioButtonChecked($immigrant === '0');
                                                                                ?> required>
                <label for="immigrantNo" class="px-1">No</label>

                <div class="form-group mb-0">
                  <label for="immigrantCountry" class="m-0">If YES, give details (country):</label>
                  <input id="immigrantCountry" type="text" name="immigrantCountry" value="<?php echo $immigrantCountry;
                                                                                          ?>" class="form-control"></label>
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
                    <input id="isIndigenousYes" type="radio" name="isIndigenous" value="1" <?php echo SetRadioButtonChecked($isIndigenous === '1');
                                                                                            ?> required>
                    <label for="isIndigenousYes" class="px-1 mr-3">Yes</label>

                    <input id="isIndigenousNo" type="radio" name="isIndigenous" value="0" <?php echo SetRadioButtonChecked($isIndigenous === '0');
                                                                                          ?> required>
                    <label for="isIndigenousNo" class="px-1">No</label>

                    <div class="form-group mb-0">
                      <label for="indigenousSpecify" class="m-0">If YES, please specify:</label>
                      <input id="indigenousSpecify" type="text" name="indigenousSpecify" value="<?php echo $isIndigenousSpecify;
                                                                                                ?>" class="form-control"></label>
                    </div>
                  </div>
                </li>
                <li>Are you differently abled?
                  <div class="my-1">
                    <input id="isDifferentlyAbledYes" type="radio" name="isDifferentlyAbled" value="1" <?php echo SetRadioButtonChecked($isDifferentlyAbled === '1');
                                                                                                        ?> required>
                    <label for="isDifferentlyAbledYes" class="px-1 mr-3">Yes</label>

                    <input id="isDifferentlyAbledNo" type="radio" name="isDifferentlyAbled" value="0" <?php echo SetRadioButtonChecked($isDifferentlyAbled === '0');
                                                                                                      ?> required>
                    <label for="isDifferentlyAbledNo" class="px-1">No</label>

                    <div class="form-group mb-0">
                      <label for="differentlyAbledSpecify" class="m-0">If YES, please specify ID No:</label>
                      <input id="differentlyAbledSpecify" type="text" name="differentlyAbledSpecify" value="<?php echo $isDifferentlyAbledSpecify;
                                                                                                            ?>" class="form-control"></label>
                    </div>
                  </div>
                </li>
                <li>Are you a solo parent?
                  <div class="my-1">
                    <input id="isSoloParentYes" type="radio" name="isSoloParent" value="1" <?php echo SetRadioButtonChecked($isSoloParent === '1');
                                                                                            ?> required>
                    <label for="isSoloParentYes" class="px-1 mr-3">Yes</label>

                    <input id="isSoloParentNo" type="radio" name="isSoloParent" value="0" <?php echo SetRadioButtonChecked($isSoloParent === '0');
                                                                                          ?> required>
                    <label for="isSoloParentNo" class="px-1">No</label>

                    <div class="form-group mb-0">
                      <label for="soloParentSpecify" class="m-0">If YES, please specify ID No:</label>
                      <input id="soloParentSpecify" type="text" name="soloParentSpecify" value="<?php echo $soloParentSpecify;
                                                                                                ?>" class="form-control"></label>
                    </div>
                  </div>
                </li>
              </ol>
            </td>
          </tr>
        </tbody>
      </table>

      <button type="submit" name="UpdateOtherInformation" class="btn btn-primary btn-block form-control mt-3"><i class="fas fa-save fa-fw"></i> Update Other Information</button>
    </div><!-- .col -->
  </form>
</div>