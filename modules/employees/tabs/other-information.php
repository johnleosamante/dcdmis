<?php
// modules/employees/tabs/other-information.php
$information = otherInformation($employeeId);
$hasThirdDegree = $hasFourthDegree = $wasGuilty = $wasCharged = $wasConvicted = $wasSeparated = $wasCandidate = $resigned = $immigrant = $isIndigenous = $isDifferentlyAbled = $isSoloParent = '0';
$relatedDetails = $guiltyDetails = $caseStatus = $convictedDetails = $separatedDetails = $candidateDetails = $resignedDetails = $immigrantCountry = $isIndigenousSpecify = $isDifferentlyAbledSpecify = $soloParentSpecify = '';
$dateFiled = '0001-01-01';

if ($information) {
    $hasThirdDegree = $information['has_third_degree'];
    $hasFourthDegree = $information['has_fourth_degree'];
    $relatedDetails = $information['relation_details'];
    $wasGuilty = $information['was_guilty'];
    $guiltyDetails = $information['guilty_details'];
    $wasCharged = $information['was_charged'];
    $dateFiled = $wasCharged ? toDate($information['date_filed'], 'Y-m-d') : date('Y-m-d');
    $caseStatus = $information['case_status'];
    $wasConvicted = $information['was_convicted'];
    $convictedDetails = $information['conviction_details'];
    $wasSeparated = $information['was_separated'];
    $separatedDetails = $information['separation_details'];
    $wasCandidate = $information['was_candidate'];
    $candidateDetails = $information['candidacy_details'];
    $resigned = $information['have_resigned'];
    $resignedDetails = $information['resignation_details'];
    $immigrant = $information['is_immigrant'];
    $immigrantCountry = $information['immigrant_country_id'];
    $isIndigenous = $information['is_indigenous'];
    $isIndigenousSpecify = $information['indigenous_group'];
    $isDifferentlyAbled = $information['with_disability'];
    $isDifferentlyAbledSpecify = $information['disability'];
    $isSoloParent = $information['is_solo_parent'];
    $soloParentSpecify = $information['solo_parent_id'];
}

$specify_other_indigenous_value = '';
$is_indigenous_others = false;

if (isset($employee['specify_other_ethnic_group']) && !empty($employee['specify_other_ethnic_group']) && $employee['specify_other_ethnic_group'] !== 'Not Applicable') {
    $isIndigenous = '1';
    $is_indigenous_others = true;
    $specify_other_indigenous_value = $employee['specify_other_ethnic_group'];
    $isIndigenousSpecify = 'Others';
} elseif (isset($employee['ethnic_group_id']) && !empty($employee['ethnic_group_id'])) {
    $ethnic_list_all = ethnic_groups();
    foreach ($ethnic_list_all as $eg_item) {
        if ((int)$eg_item['id'] === (int)$employee['ethnic_group_id']) {
            if (!empty($eg_item['is_indigenous'])) {
                $isIndigenous = '1';
                $isIndigenousSpecify = $eg_item['name'];
            } else {
                $isIndigenous = '0';
                $isIndigenousSpecify = '';
            }
            break;
        }
    }
} elseif (isset($employee['specify_other_ethnic_group']) && $employee['specify_other_ethnic_group'] === 'Not Applicable') {
    $isIndigenous = '0';
    $isIndigenousSpecify = '';
}

if ($isIndigenous === '1' || $isIndigenous === 1) {
    $indigenous_list_check = indigenous_groups();
    $known_indigenous_names = array_column($indigenous_list_check, 'name');
    if (!empty($isIndigenousSpecify) && !in_array($isIndigenousSpecify, $known_indigenous_names, true)) {
        $is_indigenous_others = true;
        if (empty($specify_other_indigenous_value) && $isIndigenousSpecify !== 'Others') {
            $specify_other_indigenous_value = $isIndigenousSpecify;
        }
        $isIndigenousSpecify = 'Others';
    }
}
?>

<div class="tab-pane fade<?= setActiveNavigation(isset($activeTab) && $activeTab === 'other-information', 'show active') ?>"
    id="other-information">
    <?php if ($editMode): ?>
        <form action="" method="POST">
            <?= csrf_field(); ?>
        <?php endif ?>

        <div class="mt-3">
            <p class="mb-1">Are you related by consanguinity or affinity to the appointing or recommending authority, or
                to the chief of bureau or office or to the person who has immediate supervision over you in the Office,
                Bureau or Department where you will be appointed,</p>

            <ol type="a" class="mb-0 pl-3">
                <li>within the third degree?
                    <div class="py-1">
                        <input id="has-third-degree-yes" name="has-third-degree" type="radio" value="1"
                            <?= setActiveItem($hasThirdDegree, '1', 'checked');
                            echo !$editMode ? ' disabled' : '' ?>>
                        <label for="has-third-degree-yes" class="px-1 mr-3">Yes</label>

                        <input id="has-third-degree-no" name="has-third-degree" type="radio" value="0"
                            <?= setActiveItem($hasThirdDegree, '0', 'checked');
                            echo !$editMode ? ' disabled' : '' ?>>
                        <label for="has-third-degree-no" class="px-1">No</label>
                    </div>
                </li>

                <li>within the fourth degree (for Local Government Unit - Career Employees)?
                    <div class="py-1">
                        <input id="has-fourth-degree-yes" name="has-fourth-degree" type="radio" value="1"
                            <?= setActiveItem($hasFourthDegree, '1', 'checked');
                            echo !$editMode ? ' disabled' : '' ?>>
                        <label for="has-fourth-degree-yes" class="px-1 mr-3">Yes</label>

                        <input id="has-fourth-degree-no" name="has-fourth-degree" type="radio" value="0"
                            <?= setActiveItem($hasFourthDegree, '0', 'checked');
                            echo !$editMode ? ' disabled' : '' ?>>
                        <label for="has-fourth-degree-no" class="px-1">No</label>
                    </div>
                </li>
            </ol>

            <div class="form-group mb-0 pl-3" id="related-details-group">
                <label for="related-details" class="m-0">If YES, give details:</label>
                <input id="related-details" name="related-details" type="text" value="<?= e($relatedDetails) ?>"
                    class="form-control" title="Leave blank if NO" <?= !$editMode ? ' readonly' : '' ?>>
            </div>
        </div>

        <hr class="my-4">

        <div>
            <ol type="a" class="pl-3 mb-0">
                <li>Have you ever been found guilty of any administrative offense?
                    <div class="py-1">
                        <input id="was-guilty-yes" name="was-guilty" type="radio" value="1" <?= setActiveItem($wasGuilty, '1', 'checked');
                        echo !$editMode ? ' disabled' : '' ?>>
                        <label for="was-guilty-yes" class="px-1 mr-3">Yes</label>

                        <input id="was-guilty-no" name="was-guilty" type="radio" value="0" <?= setActiveItem($wasGuilty, '0', 'checked');
                        echo !$editMode ? ' disabled' : '' ?>>
                        <label for="was-guilty-no" class="px-1">No</label>

                        <div class="form-group" id="guilty-details-group">
                            <label for="guilty-details" class="m-0">If YES, give details:</label>
                            <input id="guilty-details" name="guilty-details" type="text" value="<?= e($guiltyDetails) ?>"
                                class="form-control" title="Leave blank if NO" <?= !$editMode ? ' readonly' : '' ?>>
                        </div>
                    </div>
                </li>

                <li>Have you been criminally charged before any court?
                    <div class="py-1">
                        <input id="was-charged-yes" name="was-charged" type="radio" value="1"
                            <?= setActiveItem($wasCharged, '1', 'checked');
                            echo !$editMode ? ' disabled' : '' ?>>
                        <label for="was-charged-yes" class="px-1 mr-3">Yes</label>

                        <input id="was-charged-no" name="was-charged" type="radio" value="0"
                            <?= setActiveItem($wasCharged, '0', 'checked');
                            echo !$editMode ? ' disabled' : '' ?>>
                        <label for="was-charged-no" class="px-1">No</label>

                        <div id="charged-details-group">
                            <div class="mb-1">If YES, give details:</div>

                            <div class="form-group mb-2">
                                <label for="date-filed" class="m-0">Date Filed:</label>
                                <input id="date-filed" name="date-filed" type="date"
                                    value="<?= $wasCharged ? $dateFiled : date('Y-m-d') ?>" class="form-control"
                                    title="Required field if YES" <?= !$editMode ? ' readonly' : '' ?>>
                            </div>

                            <div class="form-group mb-0">
                                <label for="case-status" class="m-0">Status of Case/s:</label>
                                <input id="case-status" name="case-status" type="text" value="<?= e($caseStatus) ?>"
                                    class="form-control" title="Leave blank if NO" <?= !$editMode ? ' readonly' : '' ?>>
                            </div>
                        </div>
                    </div>
                </li>
            </ol>
        </div>

        <hr class="my-4">

        <div>
            <p class="mb-1">Have you ever been convicted of any crime or violation of any law, decree, ordinance or
                regulation by any court or tribunal?</p>

            <div class="pl-3">
                <input id="was-convicted-yes" name="was-convicted" type="radio" value="1"
                    <?= setActiveItem($wasConvicted, '1', 'checked');
                    echo !$editMode ? ' disabled' : '' ?>>
                <label for="was-convicted-yes" class="px-1 mr-3">Yes</label>

                <input id="was-convicted-no" name="was-convicted" type="radio" value="0" <?= setActiveItem($wasConvicted, '0', 'checked');
                echo !$editMode ? ' disabled' : '' ?>>
                <label for="was-convicted-no" class="px-1">No</label>

                <div class="form-group mb-0" id="convicted-details-group">
                    <label for="convicted-details" class="mb-0">If YES, give details:</label>
                    <input id="convicted-details" name="convicted-details" type="text" value="<?= e($convictedDetails) ?>"
                        class="form-control" title="Leave blank if NO" <?= !$editMode ? ' readonly' : '' ?>>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div>
            <p class="mb-1">Have you ever been separated from the service in any of the following modes: resignation,
                retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out
                (abolition) in the public or private sector?</p>

            <div class="pl-3">
                <input id="was-separated-yes" name="was-separated" type="radio" value="1"
                    <?= setActiveItem($wasSeparated, '1', 'checked');
                    echo !$editMode ? ' disabled' : '' ?>>
                <label for="was-separated-yes" class="px-1 mr-3">Yes</label>

                <input id="was-separated-no" name="was-separated" type="radio" value="0" <?= setActiveItem($wasSeparated, '0', 'checked');
                echo !$editMode ? ' disabled' : '' ?>>
                <label for="was-separated-no" class="px-1">No</label>

                <div class="form-group mb-0" id="separated-details-group">
                    <label for="separated-details" class="mb-0">If YES, give details:</label>
                    <input id="separated-details" name="separated-details" type="text" value="<?= e($separatedDetails) ?>"
                        class="form-control" title="Leave blank if NO" <?= !$editMode ? ' readonly' : '' ?>>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div>
            <ol type="a" class="pl-3 mb-0">
                <li>Have you ever been a candidate in a national or local election (except Barangay election)?
                    <div class="my-1">
                        <input id="was-candidate-yes" name="was-candidate" type="radio" value="1"
                            <?= setActiveItem($wasCandidate, '1', 'checked');
                            echo !$editMode ? ' disabled' : '' ?>>
                        <label for="was-candidate-yes" class="px-1 mr-3">Yes</label>

                        <input id="was-candidate-no" name="was-candidate" type="radio" value="0"
                            <?= setActiveItem($wasCandidate, '0', 'checked');
                            echo !$editMode ? ' disabled' : '' ?>>
                        <label for="was-candidate-no" class="px-1">No</label>

                        <div class="form-group" id="candidate-details-group">
                            <label for="candidate-details" class="m-0">If YES, give details:</label>
                            <input id="candidate-details" name="candidate-details" type="text"
                                value="<?= e($candidateDetails) ?>" class="form-control" title="Leave blank if NO"
                                <?= !$editMode ? ' readonly' : '' ?>>
                        </div>
                    </div>
                </li>

                <li>Have you resigned from the government service during the three (3)-month period the last election to
                    promote/actively campaign for a national or local candidate?
                    <div class="my-1">
                        <input id="resigned-yes" name="resigned" type="radio" value="1" <?= setActiveItem($resigned, '1', 'checked');
                        echo !$editMode ? ' disabled' : '' ?>>
                        <label for="resigned-yes" class="px-1 mr-3">Yes</label>

                        <input id="resigned-no" name="resigned" type="radio" value="0" <?= setActiveItem($resigned, '0', 'checked');
                        echo !$editMode ? ' disabled' : '' ?>>
                        <label for="resigned-no" class="px-1">No</label>

                        <div class="form-group mb-0" id="resigned-details-group">
                            <label for="resigned-details" class="m-0">If YES, give details:</label>
                            <input id="resigned-details" name="resigned-details" type="text"
                                value="<?= e($resignedDetails) ?>" class="form-control" title="Leave blank if NO"
                                <?= !$editMode ? ' readonly' : '' ?>>
                        </div>
                    </div>
                </li>
            </ol>
        </div>

        <hr class="my-4">

        <div>
            <p class="mb-1">Have you acquired the status of an immigrant or permanent resident of another country?</p>

            <div class="pl-3">
                <input id="immigrant-yes" name="immigrant" type="radio" value="1" <?= setActiveItem($immigrant, '1', 'checked');
                echo !$editMode ? ' disabled' : '' ?>>
                <label for="immigrant-yes" class="px-1 mr-3">Yes</label>

                <input id="immigrant-no" name="immigrant" type="radio" value="0" <?= setActiveItem($immigrant, '0', 'checked');
                echo !$editMode ? ' disabled' : '' ?>>
                <label for="immigrant-no" class="px-1">No</label>

                <div class="form-group mb-0" id="immigrant-details-group">
                    <label for="immigrant-country" class="m-0">If YES, give details (country):</label>
                    <?php if (!$editMode): ?>
                        <?php
                        $immigrantCountryName = 'N/A';
                        $immigrantCountry = country($immigrantCountry);
                        if ($immigrantCountry) {
                            $immigrantCountryName = $immigrantCountry['name'];
                        }
                        ?>
                        <input id="immigrant-country" name="immigrant-country" type="text"
                            value="<?= e($immigrantCountryName) ?>" class="form-control" readonly>
                    <?php else: ?>
                        <select class="form-control" id="immigrant-country" name="immigrant-country">
                            <?php $countries = countries();
                            foreach ($countries as $country): ?>
                                <option value="<?= e($country['id']) ?>" <?= setOptionSelected($country['id'], $immigrantCountry) ?>><?= e($country['name']) ?></option>
                            <?php endforeach ?>
                        </select>
                    <?php endif ?>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="mb-3">
            <p class="mb-1">Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA
                7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972); please answer the following items:</p>

            <ol type="a" class="mb-0 pl-3">
                <li>Are you a member of any indigenous group?
                    <div class="my-1">
                        <input id="is-indigenous-yes" name="is-indigenous" type="radio" value="1"
                            <?= setActiveItem($isIndigenous, '1', 'checked');
                            echo !$editMode ? ' disabled' : '' ?> onchange="updateOtherInfoToggles(); syncIndigenousToEthnic();">
                        <label for="is-indigenous-yes" class="px-1 mr-3">Yes</label>

                        <input id="is-indigenous-no" name="is-indigenous" type="radio" value="0"
                            <?= setActiveItem($isIndigenous, '0', 'checked');
                            echo !$editMode ? ' disabled' : '' ?> onchange="updateOtherInfoToggles(); syncIndigenousToEthnic();">
                        <label for="is-indigenous-no" class="px-1">No</label>

                        <div class="form-group mb-0" id="indigenous-details-group">
                            <label for="indigenous-specify" class="m-0">If YES, please specify:</label>
                            <?php if (!$editMode): ?>
                                <input id="indigenous-specify" type="text" value="<?= e($isIndigenousSpecify) ?>" class="form-control" readonly>
                                <?php if ($is_indigenous_others): ?>
                                    <div class="form-group mt-2">
                                        <label for="indigenous-group-specify" class="mb-0 small text-secondary">Specify Indigenous Group</label>
                                        <input id="indigenous-group-specify" type="text" class="form-control" value="<?= e($specify_other_indigenous_value) ?>" readonly>
                                    </div>
                                <?php endif ?>
                            <?php else: ?>
                                <?php
                                $indigenous_list = indigenous_groups();
                                $indigenous_by_category = [];
                                foreach ($indigenous_list as $ig) {
                                    $cat_name = !empty($ig['category_name']) ? $ig['category_name'] : 'Others';
                                    $indigenous_by_category[$cat_name][] = $ig;
                                }
                                ?>
                                <select id="indigenous-specify" name="indigenous-specify" class="form-control" onchange="toggleIndigenousGroupSpecify(this); syncIndigenousToEthnic();">
                                    <option value="">-- Select --</option>
                                    <?php foreach ($indigenous_by_category as $category_name => $groups): ?>
                                        <?php if (!empty($groups)): ?>
                                            <optgroup label="<?= e($category_name) ?>">
                                                <?php foreach ($groups as $ig): ?>
                                                    <option value="<?= e($ig['name']) ?>" <?= setOptionSelected($ig['name'], $isIndigenousSpecify) ?>><?= e($ig['name']) ?></option>
                                                <?php endforeach ?>
                                            </optgroup>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                    <option value="Others" <?= setOptionSelected('Others', $isIndigenousSpecify) ?>>Others</option>
                                </select>
                                <div id="indigenous-group-specify-group" class="form-group mt-2" style="display: <?= $is_indigenous_others ? 'block' : 'none' ?>;">
                                    <label for="indigenous-group-specify" class="mb-0 small text-secondary">Specify Indigenous Group</label>
                                    <input id="indigenous-group-specify" name="indigenous_group_specify" type="text" class="form-control" value="<?= e($specify_other_indigenous_value) ?>" <?= $is_indigenous_others ? 'required' : '' ?> oninput="syncIndigenousSpecifyToEthnic(this)">
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </li>
                <li>Are you differently abled?
                    <div class="my-1">
                        <input id="is-differently-abled-yes" name="is-differently-abled" type="radio" value="1"
                            <?= setActiveItem($isDifferentlyAbled, '1', 'checked');
                            echo !$editMode ? ' disabled' : '' ?>>
                        <label for="is-differently-abled-yes" class="px-1 mr-3">Yes</label>

                        <input id="is-differently-abled-no" name="is-differently-abled" type="radio" value="0"
                            <?= setActiveItem($isDifferentlyAbled, '0', 'checked');
                            echo !$editMode ? ' disabled' : '' ?>>
                        <label for="is-differently-abled-no" class="px-1">No</label>

                        <div class="form-group mb-0" id="differently-abled-details-group">
                            <label for="differently-abled-specify" class="m-0">If YES, please specify ID No:</label>
                            <input id="differently-abled-specify" name="differently-abled-specify" type="text"
                                value="<?= e($isDifferentlyAbledSpecify) ?>" title="Leave blank if NO" class="form-control"
                                <?= !$editMode ? ' readonly' : '' ?>>
                        </div>
                    </div>
                </li>
                <li>Are you a solo parent?
                    <div class="my-1">
                        <input id="is-solo-parent-yes" name="is-solo-parent" type="radio" value="1"
                            <?= setActiveItem($isSoloParent, '1', 'checked');
                            echo !$editMode ? ' disabled' : '' ?>>
                        <label for="is-solo-parent-yes" class="px-1 mr-3">Yes</label>

                        <input id="is-solo-parent-no" name="is-solo-parent" type="radio" value="0"
                            <?= setActiveItem($isSoloParent, '0', 'checked');
                            echo !$editMode ? ' disabled' : '' ?>>
                        <label for="is-solo-parent-no" class="px-1">No</label>

                        <div class="form-group mb-0" id="solo-parent-details-group">
                            <label for="solo-parent-specify" class="m-0">If YES, please specify ID No:</label>
                            <input id="solo-parent-specify" name="solo-parent-specify" type="text"
                                value="<?= e($soloParentSpecify) ?>" class="form-control" title="Leave blank if NO"
                                <?= !$editMode ? ' readonly' : '' ?>>
                        </div>
                    </div>
                </li>
            </ol>
        </div>

        <?php if ($editMode): ?>
            <div class="form-group mb-3">
                <input type="hidden" name="verifier" value="<?= cipher($employeeId) ?>">
                <button class="btn btn-primary btn-block" name="update-other-information"><i
                        class="fas fa-save fa-fw"></i>Update Other Information</button>
            </div>
        </form>
    <?php endif ?>
</div>

<script>
    (function () {
        function toggleGroup(containerId, show) {
            const group = document.getElementById(containerId);
            if (group) {
                group.style.display = show ? 'block' : 'none';
            }
        }

        function getRadioValue(name) {
            const checked = document.querySelector(`input[name="${name}"]:checked`);
            return checked ? checked.value : '0';
        }

        function updateOtherInfoToggles() {
            // 1. Consanguinity / Affinity details (shows if 3rd degree OR 4th degree is Yes)
            const thirdDegree = getRadioValue('has-third-degree') === '1';
            const fourthDegree = getRadioValue('has-fourth-degree') === '1';
            toggleGroup('related-details-group', thirdDegree || fourthDegree);

            // 2. Guilty of administrative offense
            toggleGroup('guilty-details-group', getRadioValue('was-guilty') === '1');

            // 3. Criminally charged
            toggleGroup('charged-details-group', getRadioValue('was-charged') === '1');

            // 4. Convicted of any crime
            toggleGroup('convicted-details-group', getRadioValue('was-convicted') === '1');

            // 5. Separated from service
            toggleGroup('separated-details-group', getRadioValue('was-separated') === '1');

            // 6. Candidate in election
            toggleGroup('candidate-details-group', getRadioValue('was-candidate') === '1');

            // 7. Resigned to campaign
            toggleGroup('resigned-details-group', getRadioValue('resigned') === '1');

            // 8. Immigrant status
            toggleGroup('immigrant-details-group', getRadioValue('immigrant') === '1');

            // 9. Indigenous group
            toggleGroup('indigenous-details-group', getRadioValue('is-indigenous') === '1');

            // 10. Differently abled
            toggleGroup('differently-abled-details-group', getRadioValue('is-differently-abled') === '1');

            // 11. Solo parent
            toggleGroup('solo-parent-details-group', getRadioValue('is-solo-parent') === '1');
        }

        const radioNames = [
            'has-third-degree',
            'has-fourth-degree',
            'was-guilty',
            'was-charged',
            'was-convicted',
            'was-separated',
            'was-candidate',
            'resigned',
            'immigrant',
            'is-indigenous',
            'is-differently-abled',
            'is-solo-parent'
        ];

        radioNames.forEach(function (name) {
            const radios = document.querySelectorAll(`input[name="${name}"]`);
            radios.forEach(function (radio) {
                radio.addEventListener('change', updateOtherInfoToggles);
            });
        });

        // Initialize toggle states on load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', updateOtherInfoToggles);
        } else {
            updateOtherInfoToggles();
        }
    })();

    window.toggleIndigenousGroupSpecify = function (selectElement) {
        const group = document.getElementById('indigenous-group-specify-group');
        const specifyInput = document.getElementById('indigenous-group-specify');
        if (selectElement && selectElement.value === 'Others') {
            if (group) group.style.display = 'block';
            if (specifyInput) specifyInput.setAttribute('required', 'required');
        } else {
            if (group) group.style.display = 'none';
            if (specifyInput) {
                specifyInput.removeAttribute('required');
                specifyInput.value = '';
            }
        }
    };

    window.syncIndigenousToEthnic = function () {
        const yesRadio = document.getElementById('is-indigenous-yes');
        const isIndigenous = yesRadio && yesRadio.checked;
        const indigenousSelect = document.getElementById('indigenous-specify');
        const indigenousVal = indigenousSelect ? indigenousSelect.value : '';
        const ethnicSelect = document.getElementById('ethnic-group');
        const ethnicSpecifyGroup = document.getElementById('ethnic-group-specify-group');
        const ethnicSpecifyInput = document.getElementById('ethnic-group-specify');
        const indigenousSpecifyGroup = document.getElementById('indigenous-group-specify-group');
        const indigenousSpecifyInput = document.getElementById('indigenous-group-specify');

        if (!ethnicSelect) return;

        if (!isIndigenous) {
            ethnicSelect.value = 'Not Applicable';
            if (ethnicSpecifyGroup) ethnicSpecifyGroup.style.display = 'none';
            if (ethnicSpecifyInput) {
                ethnicSpecifyInput.removeAttribute('required');
                ethnicSpecifyInput.value = '';
            }
            if (indigenousSpecifyGroup) indigenousSpecifyGroup.style.display = 'none';
            if (indigenousSpecifyInput) {
                indigenousSpecifyInput.removeAttribute('required');
                indigenousSpecifyInput.value = '';
            }
        } else if (indigenousVal === 'Others') {
            ethnicSelect.value = 'Others';
            if (ethnicSpecifyGroup) ethnicSpecifyGroup.style.display = 'block';
            if (ethnicSpecifyInput) {
                ethnicSpecifyInput.setAttribute('required', 'required');
                if (indigenousSpecifyInput) {
                    ethnicSpecifyInput.value = indigenousSpecifyInput.value;
                }
            }
            if (indigenousSpecifyGroup) indigenousSpecifyGroup.style.display = 'block';
            if (indigenousSpecifyInput) indigenousSpecifyInput.setAttribute('required', 'required');
        } else if (indigenousVal !== '') {
            let matchedOptionValue = null;
            for (let i = 0; i < ethnicSelect.options.length; i++) {
                const opt = ethnicSelect.options[i];
                if (opt.getAttribute('data-name') === indigenousVal) {
                    matchedOptionValue = opt.value;
                    break;
                }
            }
            if (matchedOptionValue !== null) {
                ethnicSelect.value = matchedOptionValue;
                if (ethnicSpecifyGroup) ethnicSpecifyGroup.style.display = 'none';
                if (ethnicSpecifyInput) {
                    ethnicSpecifyInput.removeAttribute('required');
                    ethnicSpecifyInput.value = '';
                }
                if (indigenousSpecifyGroup) indigenousSpecifyGroup.style.display = 'none';
                if (indigenousSpecifyInput) {
                    indigenousSpecifyInput.removeAttribute('required');
                    indigenousSpecifyInput.value = '';
                }
            }
        }
    };

    window.syncIndigenousSpecifyToEthnic = function (inputElement) {
        const ethnicSpecifyInput = document.getElementById('ethnic-group-specify');
        if (ethnicSpecifyInput && inputElement) {
            ethnicSpecifyInput.value = inputElement.value;
        }
    };
</script>