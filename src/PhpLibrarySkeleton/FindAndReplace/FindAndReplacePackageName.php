<?php

namespace PhpLibrarySkeleton\FindAndReplace;

use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\File\FileHelperInterface;
use PhpLibrarySkeleton\File\ReadOnlyFileInterface;

class FindAndReplacePackageName
{
    /** @var FileHelperInterface */
    private $fileHelper;

    /** @var IOHelper */
    private $ioHelper;

    /** @var ReadOnlyFileInterface */
    private $originalComposerConfig;

    /**
     * FindAndReplace constructor.
     * @param FileHelperInterface $fileHelper
     * @param IOHelper $ioHelper
     * @param ReadOnlyFileInterface $originalComposerConfig
     */
    public function __construct(
        FileHelperInterface $fileHelper,
        IOHelper $ioHelper,
        ReadOnlyFileInterface $originalComposerConfig
    ) {
        $this->fileHelper = $fileHelper;
        $this->ioHelper = $ioHelper;
        $this->originalComposerConfig = $originalComposerConfig;
    }

    /**
     * @return void
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function __invoke()
    {
        $composer = $this->originalComposerConfig->getContents();
        
        $search = $composer['name'];
        $replace = $this->ioHelper->getPackageName();
        
        $this->fileHelper->findAndReplaceInFiles($search, $replace);
    }
}
