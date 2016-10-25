<?php

namespace Interpro\AdminPanelGenerator;

use Interpro\AdminPanelGenerator\Contracts\Generator as GeneratorInterface;
use Interpro\AdminPanelGenerator\Contracts\Page\Page;
use Interpro\AdminPanelGenerator\Contracts\WidgetProvider as WidgetProviderInterface;

class Generator implements GeneratorInterface
{
    private $widgetProvider;

    /**
     * @param \Interpro\AdminPanelGenerator\Contracts\WidgetProvider $widgetProvider
     *
     * @return void
     */
    public function __construct(WidgetProviderInterface $widgetProvider)
    {
        $this->widgetProvider = $widgetProvider;
    }

    /**
     * @param \Interpro\AdminPanelGenerator\Contracts\Page\Page $page
     *
     * @return void
     */
    public function generatePage(Page $page)
    {
        $name = $page->getName();

        $pageconfig = config('interpro.generator.pages.'.$name);

        if(!$pageconfig)
        {
            throw new GeneratorException('Настройка '.'generator.pages.'.$name.' не найдена!');
        }

        if(!is_array($pageconfig))
        {
            throw new GeneratorException('Настройка '.'generator.pages.'.$name.' должна быть задана массивом!');
        }

        if(!array_key_exists('layout', $pageconfig))
        {
            throw new GeneratorException('В настройке '.'generator.pages.'.$name.' не задан layout!');
        }

        if(!array_key_exists('widgets', $pageconfig))
        {
            throw new GeneratorException('В настройке '.'generator.pages.'.$name.' не заданы widgets!');
        }

        if(!is_string($pageconfig['layout']))
        {
            throw new GeneratorException('В настройке '.'generator.pages.'.$name.' layout должен быть задан строкой!');
        }

        $page->setLayout($pageconfig['layout']);

        if(!is_array($pageconfig['widgets']))
        {
            throw new GeneratorException('В настройке '.'generator.pages.'.$name.' widgets должны быть заданы массивом!');
        }


        foreach($pageconfig['widgets'] as $widget_path => $widget_options)
        {
            if(!is_string($widget_path))
            {
                throw new GeneratorException('В настройке '.'generator.pages.'.$name.' widgets ключ виджета должен быть задан строкой!');
            }

            if(!is_array($widget_options))
            {
                throw new GeneratorException('В настройке '.'generator.pages.'.$name.' widgets опции виджета должны быть заданы массивом!');
            }

            if(!array_key_exists('labels', $widget_options))
            {
                throw new GeneratorException('В настройке '.'generator.pages.'.$name.' widgets в опциях виджета должны быть заданы labels!');
            }

            if(!is_array($widget_options['labels']))
            {
                throw new GeneratorException('В настройке '.'generator.pages.'.$name.' widgets в опциях виджета labels должны быть заданы массивом!');
            }

            $widget = $this->widgetProvider->getWidget($widget_path);

            $page->addWidget($widget, $widget_options['labels']);
        }

        $page_string = $page->draw();

        try
        {
            $path = resource_path(config('interpro.generator.files.pagesdir')).'/';
            file_put_contents($path.$name.'.json', $page_string);
        }
        catch(\Exception $exc)
        {
            throw new GeneratorException($exc->getMessage());
        }
    }
}
