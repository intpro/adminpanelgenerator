<?php

namespace Interpro\AdminPanelGenerator\Contracts\Widgets;

interface OwnFieldWidget extends Widget
{
    /**
     * @param \Interpro\Core\Taxonomy\Fields\OwnField $own
     * @param array $labels
     *
     * @return string
     */
    public function draw($own, array $labels = []);
}
