<?php

namespace Interpro\AdminPanelGenerator\Contracts;

use Interpro\AdminPanelGenerator\Contracts\Page\Page;

interface Generator
{
    /**
     * @param \Interpro\AdminPanelGenerator\Contracts\Page\Page $page
     *
     * @return void
     */
    public function generatePage(Page $page);
}
