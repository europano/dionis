<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class FileExtension extends AbstractExtension
{
    /**
     * @var
     */
    private $uploadDir;

    public function __construct($uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('file_exists', [$this, 'file_exists']),
        ];
    }

    public function file_exists($file)
    {
        $filepath = $this->uploadDir . $file;
        return file_exists($filepath);
    }
}
