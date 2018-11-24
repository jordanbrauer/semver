<?php

namespace Semver {
    if (!function_exists('semver')) {
        /**
         * Instantiate a new instance of Semver.
         *
         * @param string $version A valid semver string.
         * @return Semver
         */
        function semver(string $version = null): Semver
        {
            return new Semver($version);
        }
    }
}
