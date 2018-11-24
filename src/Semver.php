<?php 

declare(strict_types = 1);

namespace Semver;

/**
 * An object representation of a semantic version number scheme.
 * 
 * @version 0.0.1
 * @author Jordan Brauer
 * @license MIT
 * @copyright 2018 Jordan Brauer
 */
final class Semver
{
    /**
     * The default value for an undefined new semver instance.
     */
    const DEFAULT_VERSION = '0.1.0';

    /**
     * The default value to increment or decrement version numbers by.
     */
    const DEFAULT_MODIFIER = 1;
    
    /**
     * Binary integer mapped to the current major version number.
     */
    const MAJOR = 0b0001;

    /**
     * Binary integer mapped to the current minor version number.
     */
    const MINOR = 0b0010;
    
    /**
     * Binary integer mapped to the current patch version number.
     */
    const PATCH = 0b0100;
    
    /**
     * @var int Major release number.
     */
    private $major = 0;

    /**
     * @var int Minor release number.
     */
    private $minor = 1;

    /**
     * @var int Patch release number.
     */
    private $patch = 0;

    // TODO: add `prefix` property for things like 'v'
    // TODO: add `pre-release` suffix property
    // TODO: add `build` suffix property

    /**
     * Public constructor method.
     *
     * @param string $version The initial version to use.
     * @return self
     */
    public function __construct(string $version = null)
    {
        $this->setVersion($version ?? self::DEFAULT_VERSION);
    }

    /**
     * Magic method for casting to string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return \implode('.', [
            $this->getMajor(),
            $this->getMinor(),
            $this->getPatch(),
        ]);
    }

    /**
     * Bump any & all version segments by a given increment.
     *
     * @param integer $segments A bitmask of Semver segment constants.
     * @param integer $increment The value to increment by.
     * @return self
     */
    public function bump(int $segments = self::MAJOR, int $increment = null): self
    {
        $modifier = $increment ?? self::DEFAULT_MODIFIER;

        if ($segments & self::MAJOR) {
            $this->major += $modifier;
        }
        
        if ($segments & self::MINOR) {
            $this->minor += $modifier;
        }
        
        if ($segments & self::PATCH) {
            $this->patch += $modifier;
        }
        
        return $this;
    }

    /**
     * Explicitly set the version.
     *
     * @param string $version A valid semver string.
     * @throws RuntimeException If an invalid semver string is provided.
     * @return self
     */
    public function setVersion(string $version): self
    {
        $parts = \explode('.', $version);
        
        if (\count($parts) < 3) {
            throw new \RuntimeException('Invalid semver string was provided');
        }
        
        $this->major = (int) \array_shift($parts);
        $this->minor = (int) \array_shift($parts);
        $this->patch = (int) \array_shift($parts);
        
        return $this;
    }

    /**
     * Return the major version number.
     *
     * @return int
     */
    public function getMajor(): int
    {
        return $this->major;
    }

    /**
     * Return the minor version number.
     *
     * @return int
     */
    public function getMinor(): int
    {
        return $this->minor;
    }

    /**
     * Return the patch version number.
     *
     * @return int
     */
    public function getPatch(): int
    {
        return $this->patch;
    }

    /**
     * Check if the given semver is greater than the current instance.
     *
     * @param Semver $semver An instance of Semver.
     * @return bool
     */
    public function gt(self $semver): bool
    {
        return $this->compare((string) $semver, '>');
    }

    /**
     * Check if the given semver is greater than or equal to the current instance.
     *
     * @param Semver $semver An instance of Semver.
     * @return bool
     */
    public function ge(self $semver): bool
    {
        return $this->compare((string) $semver, '>=');
    }

    /**
     * Check if the given semver is less than the current instance.
     *
     * @param Semver $semver An instance of Semver.
     * @return bool
     */
    public function lt(self $semver): bool
    {
        return $this->compare((string) $semver, '<');
    }

    /**
     * Check if the given semver is less than or equal to the current instance.
     *
     * @param Semver $semver An instance of Semver.
     * @return bool
     */
    public function le(self $semver): bool
    {
        return $this->compare((string) $semver, '<=');
    }

    /**
     * Check if the given semver is equal to the current instance.
     *
     * @param Semver $semver An instance of Semver.
     * @return bool
     */
    public function eq(self $semver): bool
    {
        return $this->compare((string) $semver, '==');
    }

    /**
     * Check if the given semver is not equal to the current instance.
     *
     * @param Semver $semver An instance of Semver.
     * @return bool
     */
    public function ne(self $semver): bool
    {
        return $this->compare((string) $semver, '<>');
    }

    /**
     * Generic version omparator method.
     *
     * @param string $version A valid semver string.
     * @param string $operator A valid comparison operator.
     * @return bool
     */
    private function compare(string $version, string $operator = '=='): bool
    {
        return (bool) \version_compare((string) $this, $version, $operator);
    }
}