<?php

namespace PhpLibrarySkeleton\Composer\IO;

use Composer\IO\IOInterface;

class IOHelper
{
    const DEFAULT_LICENSE = 'MIT';
    const DEFAULT_MINIMUM_PHP_VERSION = '5.6';
    const DEFAULT_MINIMUM_STABILITY = 'stable';
    const DEFAULT_PACKAGE_TYPE = 'library';
    
    /**
     * @var IOInterface
     */
    private $io;

    /**
     * @var string
     */
    private $authorName;

    /**
     * @var string
     */
    private $authorEmail;

    /**
     * @var string
     */
    private $classNamespace;

    /**
     * @var string
     */
    private $minimumPhpVersion;

    /**
     * @var string
     */
    private $packageDescription;

    /**
     * @var string[]
     */
    private $packageKeywords;

    /**
     * @var string
     */
    private $packageLicense;

    /**
     * @var string
     */
    private $packageMinimumStability;

    /**
     * @var string
     */
    private $packageName;
    
    /**
     * @var string
     */
    private $packageType;

    /**
     * IOHelper constructor.
     * @param IOInterface $io
     */
    public function __construct(IOInterface $io)
    {
        $this->io = $io;
    }

    /**
     * @param string $question
     * @param null $default
     * @return string
     * @throws \RuntimeException
     */
    public function askUntilTruthy($question, $default = null)
    {
        do {
            $answer = $this->io->ask($question, $default);
        } while (!$answer);

        return $answer;
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    public function getAuthorName()
    {
        if ($this->authorName === null) {
            $this->authorName = $this->askUntilTruthy('Author name: ');
        }

        return $this->authorName;
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    public function getAuthorEmail()
    {
        if ($this->authorEmail === null) {
            $this->authorEmail = $this->askUntilTruthy('Author e-mail: '); // TODO Validate.
        }

        return $this->authorEmail;
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    public function getClassNamespace()
    {
        if ($this->classNamespace === null) {
            $classNamespace = $this->askUntilTruthy('Class namespace: ');
            
            // Turn Foo\\Bar into Foo\Bar:
            $classNamespace = str_replace('\\\\', '\\', $classNamespace);
            
            $this->classNamespace = $classNamespace;
        }
        
        return $this->classNamespace;
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    public function getClassDirectory()
    {
        $classNamespace = $this->getClassNamespace();

        // Turn Foo\Bar into Foo/Bar:
        return str_replace('\\', '/', $classNamespace);
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    public function getMinimumPhpVersion()
    {
        if ($this->minimumPhpVersion === null) {
            $this->minimumPhpVersion = $this->askUntilTruthy(
                sprintf('Minimum PHP version [%s]: ', self::DEFAULT_MINIMUM_PHP_VERSION),
                self::DEFAULT_MINIMUM_PHP_VERSION
            );
        }

        return $this->minimumPhpVersion;
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    public function getPackageDescription()
    {
        if ($this->packageDescription === null) {
            $this->packageDescription = $this->io->ask('Package description []: ');
        }
        
        return $this->packageDescription;
    }

    /**
     * @return string[]
     * @throws \RuntimeException
     */
    public function getPackageKeywords()
    {
        if ($this->packageKeywords === null) {
            $keywords = $this->io->ask('Package keywords (comma-separated): ', array());

            // Normalize those keywords!
            $this->packageKeywords = array_values(array_filter(array_map('trim', explode(',', $keywords))));
        }
        
        return $this->packageKeywords;
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    public function getPackageLicense()
    {
        if ($this->packageLicense === null) {
            $this->packageLicense = $this->askUntilTruthy(
                sprintf('Package license [%s]: ', self::DEFAULT_LICENSE),
                self::DEFAULT_LICENSE
            );
        }

        return $this->packageLicense;
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    public function getPackageMinimumStability()
    {
        if ($this->packageMinimumStability === null) {
            $this->packageMinimumStability = $this->askUntilTruthy(
                sprintf('Minimum stability of dependencies [%s]: ', self::DEFAULT_MINIMUM_STABILITY),
                self::DEFAULT_MINIMUM_STABILITY
            );
        }
        
        return $this->packageMinimumStability;
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    public function getPackageName()
    {
        if ($this->packageName === null) {
            $this->packageName = $this->askUntilTruthy('Package name (<vendor>/<name>): '); // TODO Validate.
        }
        
        return $this->packageName;
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    public function getPackageType()
    {
        if ($this->packageType === null) {
            $this->packageType = $this->io->ask(
                sprintf('Package type [%s]: ', self::DEFAULT_PACKAGE_TYPE),
                self::DEFAULT_PACKAGE_TYPE
            );
        }

        return $this->packageType;
    }
}
