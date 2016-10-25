<?php

namespace Interpro\AdminPanelGenerator\Factory;

use Interpro\AdminPanelGenerator\Collections\WidgetsCollection;
use Interpro\AdminPanelGenerator\Collections\WidgetsFamiliesCollection;
use Interpro\AdminPanelGenerator\Contracts\Factory\GeneratorFactory as GeneratorFactoryInterface;
use Interpro\AdminPanelGenerator\Generator;
use Interpro\AdminPanelGenerator\WidgetProvider;
use Interpro\AdminPanelGenerator\Widgets\JSON\ImageAggr\ImageFieldWidget;
use Interpro\AdminPanelGenerator\Widgets\JSON\QSAggr\BlockPageWidget;
use Interpro\AdminPanelGenerator\Widgets\JSON\QSAggr\GroupItemWidget;
use Interpro\AdminPanelGenerator\Widgets\JSON\QSAggr\GroupPageWidget;
use Interpro\AdminPanelGenerator\Widgets\JSON\QSAggr\GroupRefWidget;
use Interpro\AdminPanelGenerator\Widgets\JSON\Scalar\BoolFieldWidget;
use Interpro\AdminPanelGenerator\Widgets\JSON\Scalar\FloatFieldWidget;
use Interpro\AdminPanelGenerator\Widgets\JSON\Scalar\IntFieldWidget;
use Interpro\AdminPanelGenerator\Widgets\JSON\Scalar\StringFieldWidget;
use Interpro\AdminPanelGenerator\Widgets\JSON\Scalar\TextFieldWidget;
use Interpro\AdminPanelGenerator\Widgets\JSON\SEO\SEOFieldWidget;
use Interpro\Core\Contracts\Taxonomy\Taxonomy;
use Interpro\Origin\Concept\Enum\TypeRank;

class JSONGeneratorFactory implements GeneratorFactoryInterface
{
    private $taxonomy;

    /**
     * @param \Interpro\AdminPanelGenerator\Contracts\WidgetProvider $widgetProvider
     *
     * @return void
     */
    public function __construct(Taxonomy $taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    /**
     * @return \Interpro\AdminPanelGenerator\Contracts\Generator
     */
    public function createGenerator()
    {
        $familyCollection = new WidgetsFamiliesCollection();
        $widgetProvider = new WidgetProvider($familyCollection);

        $qsagr = $this->taxonomy->getFamily('qsaggr');
        $family = new WidgetsCollection('qsaggr');
        $familyCollection->addWidgets($family);

        foreach($qsagr as $type)
        {
            if($type->getRank() === TypeRank::BLOCK)
            {
                $widget_name = 'qsaggr.block_page.'.$type->getName();

                $widget = new BlockPageWidget($widget_name, $type, $widgetProvider);
                $family->addWidget($widget);
            }
            elseif($type->getRank() === TypeRank::GROUP)
            {
                $widget_name = 'qsaggr.group_page.'.$type->getName();
                $widget = new GroupPageWidget($widget_name, $type, $widgetProvider);
                $family->addWidget($widget);

                $widget_name = 'qsaggr.group_list.'.$type->getName();
                $widget = new GroupPageWidget($widget_name, $type, $widgetProvider);
                $family->addWidget($widget);

                $widget_name = 'qsaggr.group_item.'.$type->getName();
                $widget = new GroupItemWidget($widget_name, $type, $widgetProvider);
                $family->addWidget($widget);

                $widget_name = 'qsaggr.group_ref.'.$type->getName();
                $widget = new GroupRefWidget($widget_name, $type);
                $family->addWidget($widget);
            }
        }

        //------------------------------------------------
        $imageagr = $this->taxonomy->getType('image');
        $family = new WidgetsCollection('imageaggr');
        $familyCollection->addWidgets($family);

        $widget_name = 'imageaggr.own_field.image';
        $widget = new ImageFieldWidget($widget_name, $imageagr);
        $family->addWidget($widget);

        //------------------------------------------------
        $family = new WidgetsCollection('scalar');
        $familyCollection->addWidgets($family);

        $widget_name = 'scalar.own_field.float';
        $widget = new FloatFieldWidget($widget_name, $this->taxonomy->getType('float'));
        $family->addWidget($widget);

        $widget_name = 'scalar.own_field.int';
        $widget = new IntFieldWidget($widget_name, $this->taxonomy->getType('int'));
        $family->addWidget($widget);

        $widget_name = 'scalar.own_field.string';
        $widget = new StringFieldWidget($widget_name, $this->taxonomy->getType('string'));
        $family->addWidget($widget);

        $widget_name = 'scalar.own_field.text';
        $widget = new TextFieldWidget($widget_name, $this->taxonomy->getType('text'));
        $family->addWidget($widget);

        $widget_name = 'scalar.own_field.bool';
        $widget = new BoolFieldWidget($widget_name, $this->taxonomy->getType('bool'));
        $family->addWidget($widget);

        //------------------------------------------------
        $family = new WidgetsCollection('seo');
        $familyCollection->addWidgets($family);

        $widget_name = 'scalar.own_field.seo';
        $widget = new SEOFieldWidget($widget_name, $this->taxonomy->getType('seo'));
        $family->addWidget($widget);

        $generator = new Generator($widgetProvider);

        return $generator;
    }
}
