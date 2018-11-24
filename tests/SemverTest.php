<?php

declare(strict_types = 1);

namespace Semver\Tests;

use function Semver\Semver;
use PHPUnit\Framework\TestCase;
use Semver\Semver;

final class SemverTest extends TestCase
{
    public function testSemverEquality(): void
    {   
        $semver = semver();
        
        $this->assertInstanceOf(Semver::class, $semver);
        $this->assertEquals(Semver::DEFAULT_VERSION, $semver);
        $this->assertSame(Semver::DEFAULT_VERSION, (string) $semver);
        $this->assertSame($semver, $semver);
        $this->assertEquals(semver(), $semver);
        $this->assertNotSame(semver(), $semver);
    }

    public function testSimpleSemverScheme(): void
    {
        $scheme = PHP_VERSION;
        $semver = semver($scheme);

        $this->assertEquals($scheme, $semver);

        $parts = $this->extractParts($scheme);
        
        $this->assertEquals($parts['major'], $semver->getMajor());
        $this->assertEquals($parts['minor'], $semver->getMinor());
        $this->assertEquals($parts['patch'], $semver->getPatch());
    }

    public function testComplexSemverScheme(): void
    {
        $this->markTestSkipped('To be implemented!');
    }

    public function testOptionalPrefixScheme(): void
    {
        $this->markTestSkipped('To be implemented!');
    }

    public function testOptionalBuildScheme(): void
    {
        $this->markTestSkipped('To be implemented!');
    }

    public function testOptionalPreReleaseScheme(): void
    {
        $this->markTestSkipped('To be implemented!');
    }

    public function testExplicitlySettingSemverScheme(): void
    {
        $semver = semver();
        $scheme = '69.69.69';

        $this->assertEquals(Semver::DEFAULT_VERSION, $semver);

        $semver->setVersion($scheme);

        $this->assertNotEquals(Semver::DEFAULT_VERSION, $semver);
        $this->assertEquals($scheme, $semver);

        $parts = $this->extractParts($scheme);
        
        $this->assertEquals($parts['major'], $semver->getMajor());
        $this->assertEquals($parts['minor'], $semver->getMinor());
        $this->assertEquals($parts['patch'], $semver->getPatch());   
    }

    public function testBumpingMajorVersion(): void
    {
        array_map(function (Semver $semver) {
            $this->assertSame('1.1.0', (string) $semver);
        }, [
            semver()->bump(),
            semver()->bump(Semver::MAJOR),
            # TODO: add more bumping/incrementing methods here
        ]);
    }

    public function testBumpingMinorVersion(): void
    {
        array_map(function (Semver $semver) {
            $this->assertSame('0.2.0', (string) $semver);
        }, [
            semver()->bump(Semver::MINOR),
            # TODO: add more bumping/incrementing methods here
        ]);
    }

    public function testBumpingPatchVersion(): void
    {
        array_map(function (Semver $semver) {
            $this->assertSame('0.1.1', (string) $semver);
        }, [
            semver()->bump(Semver::PATCH),
            # TODO: add more bumping/incrementing methods here
        ]);
    }

    public function testBumpingMajorMinorVersion(): void
    {
        array_map(function (Semver $semver) {
            $this->assertSame('1.2.0', (string) $semver);
        }, [
            semver()->bump(Semver::MAJOR | Semver::MINOR),
            # TODO: add more bumping/incrementing methods here
        ]);
    }

    public function testBumpingMinorPatchVersions(): void
    {
        array_map(function (Semver $semver) {
            $this->assertSame('0.2.1', (string) $semver);
        }, [
            semver()->bump(Semver::MINOR | Semver::PATCH),
            # TODO: add more bumping/incrementing methods here
        ]);
    }

    public function testBumpingPatchMajorVersions(): void
    {
        array_map(function (Semver $semver) {
            $this->assertSame('1.1.1', (string) $semver);
        }, [
            semver()->bump(Semver::PATCH | Semver::MAJOR),
            # TODO: add more bumping/incrementing methods here
        ]);
    }

    public function testBumpingMajorMinorPatchVersions(): void
    {
        array_map(function (Semver $semver) {
            $this->assertSame('1.2.1', (string) $semver);
        }, [
            semver()->bump(Semver::MAJOR | Semver::MINOR | Semver::PATCH),
            # TODO: add more bumping/incrementing methods here
        ]);
    }

    public function testGreaterThanComparator(): void
    {
        $semver = semver('1.0.0');

        $this->assertTrue($semver->gt(semver()));
        $this->assertTrue($semver->gt(semver('0.0.999999')));
        $this->assertFalse($semver->gt(semver('1.0.1')));
        $this->assertFalse($semver->gt(semver('1.0.01')));
        # TODO: add more assertions for builds, prefix, pre-release, etc.
    }

    public function testGreaterThanOrEqualToComparator(): void
    {
        $semver = semver('1.0.0');

        $this->assertTrue($semver->ge(semver()));
        $this->assertTrue($semver->ge(semver('0.0.999999')));
        $this->assertTrue($semver->ge(semver('1.0.0')));
        $this->assertFalse($semver->ge(semver('1.0.1')));
        $this->assertFalse($semver->ge(semver('1.0.01')));
        # TODO: add more assertions for builds, prefix, pre-release, etc.
    }

    public function testLessThanComparator(): void
    {
        $semver = semver('1.0.0');

        $this->assertFalse($semver->lt(semver()));
        $this->assertFalse($semver->lt(semver('0.0.999999')));
        $this->assertTrue($semver->lt(semver('1.0.1')));
        $this->assertTrue($semver->lt(semver('1.0.01')));
        # TODO: add more assertions for builds, prefix, pre-release, etc.
    }

    public function testLessThanOrEqualToComparator(): void
    {
        $semver = semver('1.0.0');

        $this->assertFalse($semver->le(semver()));
        $this->assertFalse($semver->le(semver('0.0.999999')));
        $this->assertTrue($semver->le(semver('1.0.0')));
        $this->assertTrue($semver->le(semver('1.0.1')));
        $this->assertTrue($semver->le(semver('1.0.01')));
        # TODO: add more assertions for builds, prefix, pre-release, etc.
    }

    public function testEqualToComparator(): void
    {
        $semver = semver('1.0.0');

        $this->assertTrue($semver->eq(semver('1.0.0')));
        $this->assertFalse($semver->eq(semver()));
        $this->assertFalse($semver->eq(semver('0.0.999999')));
        $this->assertFalse($semver->eq(semver('1.0.1')));
        $this->assertFalse($semver->eq(semver('1.0.01')));
        # TODO: add more assertions for builds, prefix, pre-release, etc.
    }

    public function testNotEqualToComparator(): void
    {
        $semver = semver('1.0.0');

        $this->assertFalse($semver->ne(semver('1.0.0')));
        $this->assertTrue($semver->ne(semver()));
        $this->assertTrue($semver->ne(semver('0.0.999999')));
        $this->assertTrue($semver->ne(semver('1.0.1')));
        $this->assertTrue($semver->ne(semver('1.0.01')));
        # TODO: add more assertions for builds, prefix, pre-release, etc.
    }

    /**
     * Helper method to quickly break apart a **simple** semver scheme.
     *
     * @param string $scheme A valid semver scheme.
     * @return array
     */
    private function extractParts(string $scheme): array
    {
        return array_combine(['major', 'minor', 'patch'], explode('.', $scheme));
    }
}