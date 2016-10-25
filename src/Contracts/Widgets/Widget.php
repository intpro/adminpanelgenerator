<?php

namespace Interpro\AdminPanelGenerator\Contracts\Widgets;

use Interpro\Core\Contracts\Named;

interface Widget extends Named
{
    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Types\Type $type
     */
    public function getType();

    /**
     * @return string
     */
    public function getName();
}
