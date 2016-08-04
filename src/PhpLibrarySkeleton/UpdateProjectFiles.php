<?php

namespace PhpLibrarySkeleton;

use Composer\Script\Event;
use PhpLibrarySkeleton\FindAndReplace\FindAndReplace;
use PhpLibrarySkeleton\UpdateDirectoryStructure\UpdateDirectoryStructure;
use PhpLibrarySkeleton\UpdateTravisConfig\UpdateTravisConfig;

class UpdateProjectFiles
{
    /** @var callable[] */
    private $callables = array();

    /**
     * UpdateProjectFiles constructor.
     * @param callable[] $callables
     */
    public function __construct(array $callables)
    {
        array_walk($callables, array($this, 'addCallable'));
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
        $command();
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \IOException
     * @throws \NullPointerException
     * @throws \RuntimeException
     * @throws \BuildException
     */
    public function __invoke()
    {
        foreach ($this->callables as $callable) {
            $callable();
        }
    }

    /**
     * @param callable $callable
     * @throws \InvalidArgumentException
     */
    public function addCallable($callable)
    {
        if (!is_callable($callable)) {
            throw new \InvalidArgumentException(sprintf(
                '[expectedType=callable] [actualType=%s]',
                is_object($callable) ? get_class($callable) : gettype($callable)
            ));
        }
        
        $this->callables[] = $callable;
    }
}
