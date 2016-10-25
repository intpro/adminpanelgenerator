<?php

namespace Interpro\AdminPanelGenerator\Contracts;

interface WidgetProvider
{
    /**
     * @param string $widget_path
     *
     * @return \Interpro\AdminPanelGenerator\Contracts\Widgets\Widget
     */
    public function getWidget($widget_path);

    /**
     * @param string $family
     *
     * @return \Interpro\AdminPanelGenerator\Contracts\Collections\WidgetsCollection
     */
    public function getFamily($family);
}
