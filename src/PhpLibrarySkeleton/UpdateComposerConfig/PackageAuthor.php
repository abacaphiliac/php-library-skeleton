<?php

namespace PhpLibrarySkeleton\UpdateComposerConfig;

use PhpLibrarySkeleton\Composer\IO\AbstractFileIO;

class PackageAuthor extends AbstractFileIO
{
    /**
     * @return void
     * @throws \RuntimeException
     */
    public function updateContents()
    {
        $newName = $this->getIoHelper()->getAuthorName();
        $newEmail = $this->getIoHelper()->getAuthorEmail();
        
        $contents = $this->getFile()->getContents();
        
        $contents['authors'] = array(
            array(
                'name' => $newName,
                'email' => $newEmail,
            )
        );
        
        $this->getFile()->setContents($contents);
    }
}
