<?php

namespace Interpro\AdminPanelGenerator\Contracts\Collections;

use Interpro\Core\Contracts\Taxonomy\Collections\NamedCollection;

interface WidgetsFamiliesCollection extends NamedCollection
{
    /**
     * @param string $name
     *
     * @return \Interpro\AdminPanelGenerator\Contracts\Collections\WidgetsCollection
     */
    public function getWidgets($name);

    /**
     * @return \Interpro\AdminPanelGenerator\Contracts\Collections\WidgetsCollection
     *
     * @return void
     */
    public function addWidgets(WidgetsCollection $collection);
}
