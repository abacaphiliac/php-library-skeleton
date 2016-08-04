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
        './.idea/*',
        './.git/*',
        './vendor/*',
        './composer.lock',
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
        if (!$excludes) {
            $excludes = self::$defaultExcludes;
        }
        
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
            throw new \InvalidArgumentException();
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
     * @param string $relativePath
     * @return \SplFileInfo
     * @throws \UnexpectedValueException
     */
    public function getFilename($relativePath)
    {
        $files = FileHelper::getFiles(array($relativePath));
        if (!$files) {
            throw new \UnexpectedValueException();
        }

        $file = reset($files);
        if ($file instanceof \SplFileInfo) {
            return $file;
        }

        throw new \UnexpectedValueException();
    }
}
