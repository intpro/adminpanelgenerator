<?php

namespace Interpro\AdminPanelGenerator\Contracts\Factory;

interface GeneratorFactory
{
    /**
     * @return \Interpro\AdminPanelGenerator\Contracts\Generator
     */
    public function createGenerator();
}
