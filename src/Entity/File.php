<?php
/**
 * Created by PhpStorm.
 * User: универ
 * Date: 14.05.2019
 * Time: 17:42
 */

namespace App\Entity;


class File
{
    private $file;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }
}