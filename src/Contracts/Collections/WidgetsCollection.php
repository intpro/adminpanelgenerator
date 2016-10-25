<?php

namespace Interpro\AdminPanelGenerator\Contracts\Collections;

use Interpro\AdminPanelGenerator\Contracts\Widgets\Widget;
use Interpro\Core\Contracts\Taxonomy\Collections\NamedCollection;

interface WidgetsCollection extends NamedCollection
{
    /**
     * @return string $name
     */
    public function getName();

    /**
     * @param string $name
     *
     * @return \Interpro\AdminPanelGenerator\Contracts\Widgets\Widget
     */
    public function getWidget($name);

    /**
     * @param \Interpro\AdminPanelGenerator\Contracts\Widgets\Widget
     */
    public function addWidget(Widget $type);
}
