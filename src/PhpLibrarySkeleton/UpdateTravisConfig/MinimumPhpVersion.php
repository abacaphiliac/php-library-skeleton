<?php

namespace PhpLibrarySkeleton\UpdateTravisConfig;

use PhpLibrarySkeleton\Composer\IO\AbstractFileIO;

class MinimumPhpVersion extends AbstractFileIO
{
    /**
     * @return void
     * @throws \RuntimeException
     */
    public function updateContents()
    {
        $contents = $this->getFile()->getContents();

        $value = $this->getIoHelper()->getMinimumPhpVersion();
        
        $contents['php'] = array_filter($contents['php'], function ($version) use ($value) {
            return $version >= $value;
        });

        $this->getFile()->setContents($contents);
    }
}
