<?php

namespace Interpro\AdminPanelGenerator\Contracts\Page;

use Interpro\AdminPanelGenerator\Contracts\Widgets\Widget;

interface Page
{
    /**
     * @param string $layout_name
     *
     * @return void
     */
    public function setLayout($layout_name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function draw();

    /**
     * @return void
     */
    public function addWidget(Widget $widget);
}
