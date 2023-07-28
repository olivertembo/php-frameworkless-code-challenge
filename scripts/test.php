<?php

require_once '../VersionComparator.php';

$version1 = '1.0.17+42';
$version2 = '1.0.17+60';

$result = VersionComparator::compareWithTimezoneChange($version1, $version2);

if ($result === -1) {
    echo "$version1 is lower than $version2";
} elseif ($result === 1) {
    echo "$version1 is higher than $version2";
} else {
    echo "$version1 is equal to $version2";
}
