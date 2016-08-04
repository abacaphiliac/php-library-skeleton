<?php

namespace PhpLibrarySkeleton\File;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YmlFile extends AbstractFile
{
    /**
     * @param mixed $data
     * @return mixed[]
     * @throws ParseException
     */
    public function decode($data)
    {
        return Yaml::parse($data);
    }

    /**
     * @param mixed[] $data
     * @return string
     */
    public function encode(array $data)
    {
        return Yaml::dump($data);
    }
}
