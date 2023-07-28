<?php

class VersionComparator
{
    /**
     * Compare two versions with timezone change consideration.
     *
     * @param string $version1 The first version string.
     * @param string $version2 The second version string.
     * @return int Returns -1 if $version1 is lower than $version2,
     *              0 if they are equal, and 1 if $version1 is higher than $version2.
     */
    public static function compareWithTimezoneChange($version1, $version2)
    {
        // Extract version numbers and timezone information
        $pattern = '/^(\d+\.\d+\.\d+)(\+(.*))?$/';
        preg_match($pattern, $version1, $matches1);
        preg_match($pattern, $version2, $matches2);

        $versionNum1 = $matches1[1];
        $versionNum2 = $matches2[1];

        // Compare version numbers
        $versionComparison = version_compare($versionNum1, $versionNum2);

        if ($versionComparison === 0) {
            // If the version numbers are equal, compare timezone information
            $timezone1 = isset($matches1[3]) ? $matches1[3] : '';
            $timezone2 = isset($matches2[3]) ? $matches2[3] : '';

            // Prior to version 1.0.17+60, timezone was Europe/Berlin
            if ($timezone1 === '60') {
                $timezone1 = 'Europe/Berlin';
            }

            // After version 1.0.17+60, timezone is UTC
            if ($timezone2 === '60') {
                $timezone2 = 'UTC';
            }

            // Compare timezone
            $timezoneComparison = strcasecmp($timezone1, $timezone2);

            // If timezone is different and versions are equal, adjust versionComparison
            if ($timezoneComparison !== 0) {
                $versionComparison = ($timezoneComparison < 0) ? -1 : 1;
            }
        }

        return $versionComparison;
    }
}
