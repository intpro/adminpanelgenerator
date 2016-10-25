<?php

namespace Interpro\AdminPanelGenerator\Contracts\Widgets;

interface GroupRefWidget extends Widget
{
    /**
     * @param \Interpro\Core\Taxonomy\Fields\RefField $ref
     * @param array $labels
     *
     * @return string
     */
    public function draw($ref, array $labels = []);
}
