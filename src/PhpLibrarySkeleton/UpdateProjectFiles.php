<?php

namespace PhpLibrarySkeleton;

use Composer\Script\Event;
use PhpLibrarySkeleton\Composer\IO\AbstractFileIO;
use PhpLibrarySkeleton\Composer\IO\IOHelper;
use PhpLibrarySkeleton\File\FileHelper;
use PhpLibrarySkeleton\File\FileInterface;

class UpdateProjectFiles
{
    /** @var FileHelper */
    private $fileHelper;

    /** @var IOHelper */
    private $ioHelper;
    
    /** @var \SplFileInfo */
    private $root;
    
    /** @var FileInterface */
    private $travisConfig;
    
    /** @var FileInterface */
    private $composerConfig;
    
    /** @var AbstractFileIO[] */
    private $travisUpdates = array();
    
    /** @var AbstractFileIO[] */
    private $composerUpdates = array();

    /**
     * UpdateProjectFiles constructor.
     * @param FileHelper $fileHelper
     * @param IOHelper $ioHelper
     * @param \SplFileInfo $root
     * @param FileInterface $composerConfig
     * @param Composer\IO\AbstractFileIO[] $composerUpdates
     * @param FileInterface $travisConfig
     * @param Composer\IO\AbstractFileIO[] $travisUpdates
     */
    public function __construct(
        FileHelper $fileHelper,
        IOHelper $ioHelper,
        \SplFileInfo $root,
        FileInterface $composerConfig,
        array $composerUpdates,
        FileInterface $travisConfig,
        array $travisUpdates
    ) {
        $this->fileHelper = $fileHelper;
        $this->ioHelper = $ioHelper;
        $this->root = $root;
        $this->composerConfig = $composerConfig;
        $this->composerUpdates = $composerUpdates;
        $this->travisConfig = $travisConfig;
        $this->travisUpdates = $travisUpdates;
    }

    /**
     * @param Event $event
     * @throws \InvalidArgumentException
     */
    public static function postCreateProjectCmd(Event $event)
    {
        // TODO Is this safe? Would be better to grab from Composer, if it's available.
        $root = new \SplFileInfo(getcwd());
        
        $command = UpdateProjectFilesFactory::createCommand($root, $event->getIO());
        
        $command($event);
    }

    /**
     * @param Event $event
     * @throws \InvalidArgumentException
     * @throws \IOException
     * @throws \NullPointerException
     * @throws \RuntimeException
     * @throws \BuildException
     */
    public function __invoke(Event $event)
    {
        $composerConfigContents = $this->composerConfig->getContents();
        $originalPackageName = $composerConfigContents['name'];
        $originalAuthorName = $composerConfigContents['authors'][0]['name'];
        $originalAuthorEmail = $composerConfigContents['authors'][0]['email'];
        
        // Update Travis config in-memory.
        foreach ($this->travisUpdates as $travisUpdate) {
            $travisUpdate->updateContents();
        }
        
        // Update Composer config in-memory.
        foreach ($this->composerUpdates as $composerUpdate) {
            $composerUpdate->updateContents();
        }

        // Write updates to disk.
        $this->travisConfig->writeFile();
        $this->composerConfig->writeFile();
        
        // Find-and-replace package-name.
        $packageName = $this->ioHelper->getPackageName();
        $this->fileHelper->findAndReplaceInFiles($originalPackageName, $packageName);
        
        // Find-and-replace author-name.
        $authorName = $this->ioHelper->getAuthorName();
        $this->fileHelper->findAndReplaceInFiles($originalAuthorName, $authorName);
        
        // Find-and-replace author-email.
        $authorEmail = $this->ioHelper->getAuthorEmail();
        $this->fileHelper->findAndReplaceInFiles($originalAuthorEmail, $authorEmail);
        
        // Update README description.
        // Remove README Usage.
        // Remove README TODO.
        
        $root = $this->root->getPathname();
        $namespace = $this->ioHelper->getClassNamespace();
        
        // Create new directories.
        $source = $root . '/src/' . $namespace;
        if (!@mkdir($source) && !is_dir($source)) {
            throw new \RuntimeException();
        }

        $tests = $root . '/tests/' . $namespace;
        if (!@mkdir($tests) && !is_dir($tests)) {
            throw new \RuntimeException();
        }
        
        // Remove old directories.
        $deleteTask = new \DeleteTask();
        $deleteTask->setDir(new \PhingFile($root . '/src/PhpLibrarySkeleton'));
        $deleteTask->main();

        $deleteTask->setDir(new \PhingFile($root . '/tests/PhpLibrarySkeleton'));
        $deleteTask->main();
    }
}
