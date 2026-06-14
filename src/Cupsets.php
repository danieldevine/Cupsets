<?php

namespace Coderjerk\Cupsets;

class Cupsets
{
    public Competition $competition;

    public function __construct(string $id)
    {
        $this->competition = new Competition($id);
    }
}
