<?php

namespace PhpLibrarySkeleton\UpdateComposerConfig;

use PhpLibrarySkeleton\Composer\IO\AbstractFileIO;

class PackageName extends AbstractFileIO
{
    /**
     * @return void
     * @throws \RuntimeException
     */
    public function updateContents()
    {
        $contents = $this->getFile()->getContents();
        
        $contents['name'] = $this->getIoHelper()->getPackageName();
        
        $this->getFile()->setContents($contents);
    }
}
