<?php

namespace Semver {
    if (!function_exists('semver')) {
        /**
         * Instantiate a new instance of Semver.
         *
         * @param string $version A valid semver string.
         * @return \Semver\Semver
         */
        function semver(string $version = null): \Semver\Semver
        {
            return new \Semver\Semver($version);
        }
    }
}
