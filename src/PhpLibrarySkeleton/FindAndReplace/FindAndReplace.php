<?php

namespace PhpLibrarySkeleton\FindAndReplace;

use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\File\FileHelper;
use PhpLibrarySkeleton\File\ReadOnlyFileInterface;

class FindAndReplace
{
    /** @var FileHelper */
    private $fileHelper;

    /** @var IOHelper */
    private $ioHelper;

    /** @var ReadOnlyFileInterface */
    private $originalComposerConfig;

    /**
     * FindAndReplace constructor.
     * @param FileHelper $fileHelper
     * @param IOHelper $ioHelper
     * @param ReadOnlyFileInterface $originalComposerConfig
     */
    public function __construct(
        FileHelper $fileHelper,
        IOHelper $ioHelper,
        ReadOnlyFileInterface $originalComposerConfig
    ) {
        $this->fileHelper = $fileHelper;
        $this->ioHelper = $ioHelper;
        $this->originalComposerConfig = $originalComposerConfig;
    }

    /**
     * @return void
     */
    public function __invoke()
    {
        $composer = $this->originalComposerConfig->getContents();
        
        // Find-and-replace package-name.
        $packageName = $this->ioHelper->getPackageName();
        $this->fileHelper->findAndReplaceInFiles($composer['name'], $packageName);

        // Find-and-replace author-name.
        $authorName = $this->ioHelper->getAuthorName();
        $this->fileHelper->findAndReplaceInFiles($composer['authors'][0]['name'], $authorName);

        // Find-and-replace author-email.
        $authorEmail = $this->ioHelper->getAuthorEmail();
        $this->fileHelper->findAndReplaceInFiles($composer['authors'][0]['email'], $authorEmail);
    }
}
