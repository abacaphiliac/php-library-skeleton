<?php

namespace PhpLibrarySkeleton\UpdateComposerConfig;

use PhpLibrarySkeleton\Composer\IO\AbstractFileIO;

class ClassNamespace extends AbstractFileIO
{
    /**
     * @return void
     * @throws \RuntimeException
     */
    public function updateContents()
    {
        $namespace = $this->getIoHelper()->getClassNamespace();
        
        $contents = $this->getFile()->getContents();

        $contents['autoload'] = array(
            'psr-4' => array(
                str_replace('\\', '\\\\', $namespace) . '\\\\' =>
                    'src/' . str_replace(array('\\', '//'), array('/', '/'), $namespace),
            ),
        );

        $this->getFile()->setContents($contents);
    }
}
