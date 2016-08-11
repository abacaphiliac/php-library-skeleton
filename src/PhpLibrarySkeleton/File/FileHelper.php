<?php

namespace PhpLibrarySkeleton\File;

use TheSeer\DirectoryScanner\DirectoryScanner;

class FileHelper implements FileHelperInterface
{
    /**
     * @var \SplFileInfo
     */
    private $root;

    /**
     * @var mixed[]
     */
    private static $defaultExcludes = array(
        '*/.idea/*',
        '*/.git/*',
        '*/vendor/*',
        '*/composer.lock',
    );

    /**
     * FileHelper constructor.
     * @param \SplFileInfo $root
     */
    public function __construct(\SplFileInfo $root)
    {
        $this->root = $root;
    }

    /**
     * @param string[] $includes
     * @param string[] $excludes
     * @return \SplFileInfo[]
     */
    public function getFiles(array $includes = array(), array $excludes = array())
    {
        $excludes = array_merge(self::$defaultExcludes, $excludes);
        
        $scanner = new DirectoryScanner();
        $scanner->setIncludes($includes);
        $scanner->setExcludes($excludes);

        $iterator = $scanner($this->root->getPathname());
        
        return iterator_to_array($iterator);
    }

    /**
     * @param callable $callable
     * @return void
     * @throws \InvalidArgumentException
     */
    public function walkFiles($callable)
    {
        if (!is_callable($callable)) {
            throw new \InvalidArgumentException('First argument must be callable.');
        }
        
        $files = $this->getFiles();
        
        array_walk($files, $callable);
    }

    /**
     * @param mixed $search
     * @param mixed $replace
     * @return void
     * @throws \InvalidArgumentException
     */
    public function findAndReplaceInFiles($search, $replace)
    {
        $this->walkFiles(function (\SplFileInfo $file) use ($search, $replace) {
            FileHelper::findAndReplaceInFile($file->getPathname(), $search, $replace);
        });
    }

    /**
     * @param string $filename
     * @param mixed $search
     * @param mixed $replace
     * @return int
     */
    public static function findAndReplaceInFile($filename, $search, $replace)
    {
        $subject = file_get_contents($filename);
        $replaced = str_replace($search, $replace, $subject);
        return file_put_contents($filename, $replaced);
    }

    /**
     * @param string $directory
     * @throws \InvalidArgumentException
     */
    public static function removeDirectory($directory)
    {
        if (stripos($directory, '/src') === false && stripos($directory, '/tests') === false) {
            throw new \InvalidArgumentException(sprintf('Directory [%s] is not white-listed for removal.', $directory));
        }
        
        /** @var \SplFileInfo[] $files */
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        
        foreach ($files as $file) {
            if ($file->isDir()) {
                @rmdir($file->getPathname());
            } else {
                @unlink($file->getPathname());
            }
        }
        
        @rmdir($directory);
    }

    /**
     * @param string $oldDirectory
     * @param string $newDirectory
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function replaceDirectory($oldDirectory, $newDirectory)
    {
        // Create new directory.
        if (!@mkdir($newDirectory, fileperms($oldDirectory), true) && !is_dir($newDirectory)) {
            throw new \RuntimeException(sprintf('Directory [%s] was not created.', $newDirectory));
        }

        // Remove old directory.
        self::removeDirectory($oldDirectory);
    }
}
