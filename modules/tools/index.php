<?php
// tools/index.php

contentTitle('Monitoring Tools');
?>

<div class="row mt-4">
    <?php
    cardMini('Procurement Monitoring', 'https://docs.google.com/spreadsheets/d/1GJedbErwA0BFT4LfM-5QTBJMQeliHXMK/edit?gid=1975740446#gid=1975740446', 'fa-file-excel', 'primary', true);
    cardMini('Agency Action Plan and Status of Implementation', 'https://docs.google.com/spreadsheets/d/15UW4kGOiJvMIViW-muOG7KTCX3Io5HcX9ZyRgj8rXAc/edit?usp=sharing', 'fa-file-excel', 'primary', true);
    cardMini('Project CHIEF', 'https://depedph-my.sharepoint.com/:x:/g/personal/nur_hussien_deped_gov_ph/IQDsNFGvmEPFT79ZSoyQHxdpAYwuC5CAVxKo_4Ua4vajSvo?e=3BrEAi&fbclid=IwY2xjawQR5SxleHRuA2FlbQIxMQBzcnRjBmFwcF9pZAEwAAEe6G2zEsEnEhevADQniaiyEoa6Hge2INXw1rWOpvUIBWmtOIv0T0_Yid5G8z4_aem_bNHrnmNi8Pq5N8yl4-yXSQ', 'fa-file-excel', 'orange', true);
    cardMini('Project One Drive, One Data Management', 'https://depedph-my.sharepoint.com/:x:/g/personal/smme_dipolog_deped_gov_ph/Eccc1Z9Bi8hJiQgXX_WbQhsBxHgNljGwKUHOZMhixltFpw?e=j54Pne&fbclid=IwY2xjawQR521leHRuA2FlbQIxMQBzcnRjBmFwcF9pZAEwAAEebYJqACyofMKxXSMvziJnaBiQkryQZrBQW6JKHiQlDnvzc5LzNGCboR0MVYc_aem_nUwz_RBdjJRubvz6UIYALQ', 'fa-file-excel', 'orange', true);
    cardMini('SGOD Sub-AROs Monitoring', 'https://docs.google.com/spreadsheets/d/1HhxfiUdDbzZFddKwi48TfrqEscGPaZtC/edit?gid=609413157#gid=609413157', 'fa-file-excel', 'orange', true);

    $userPositionId = position($userId)['position_id'];
    $allowedPositions = ['SDS', 'ASDS', 'CES', 'ATY3', 'ITO1', 'A3', 'ADOF5', 'PSDS', 'EPS'];
    $showFilledUnfilledItems = in_array($userPositionId, $allowedPositions, true) || ($userPositionId === 'ADOF4' && $isPersonnel);
    if ($showFilledUnfilledItems) {
        cardMini(
            'Filled and Unfilled Items',
            'https://depedph-my.sharepoint.com/:x:/g/personal/love_ricafort_deped_gov_ph/IQALaDK4t-BhRI-wKJCb6qvAAR45KtJb8sRJwflKUZ1XJDU?e=gi7Njk&fbclid=IwY2xjawSKAEVleHRuA2FlbQIxMABicmlkETFIalZjVmNMOUZLanp0M3BHc3J0YwZhcHBfaWQQMjIyMDM5MTc4ODIwMDg5MgABHoPs_8vDS_7XrlUXvaWJ1II2sYCXvTirrxXi6Jy_tLjL0vBmkPhgF2AOpdX8_aem_Sqcv-SPKcNW10XD3TZeXrg',
            'fa-file-excel',
            'primary',
            true
        );
    }
    ?>
</div>