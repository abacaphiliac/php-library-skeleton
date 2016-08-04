<?php

namespace PhpLibrarySkeleton\File;

interface FileHelperInterface
{
    /**
     * @param string[] $includes
     * @param string[] $excludes
     * @return \SplFileInfo[]
     */
    public function getFiles(array $includes = array(), array $excludes = array());

    /**
     * @param callable $callable
     * @return void
     */
    public function walkFiles($callable);

    /**
     * @param mixed $search
     * @param mixed $replace
     * @return void
     */
    public function findAndReplaceInFiles($search, $replace);

    /**
     * @param string $filename
     * @param mixed $search
     * @param mixed $replace
     * @return int
     */
    public static function findAndReplaceInFile($filename, $search, $replace);
}