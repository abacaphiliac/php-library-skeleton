<?php

namespace PhpLibrarySkeleton\UpdateComposerConfig;

use PhpLibrarySkeleton\Composer\IO\AbstractFileIO;

class PackageKeywords extends AbstractFileIO
{
    /**
     * @return void
     * @throws \RuntimeException
     */
    public function updateContents()
    {
        $contents = $this->getFile()->getContents();

        $contents['keywords'] = $this->getIoHelper()->getPackageKeywords();

        $this->getFile()->setContents($contents);
    }
}
