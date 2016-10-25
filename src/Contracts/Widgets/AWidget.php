<?php

namespace Interpro\AdminPanelGenerator\Contracts\Widgets;

interface AWidget extends Widget
{
    /**
     * @param array $labels
     *
     * @return string
     */
    public function draw(array $labels = []);
}
