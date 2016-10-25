<?php

namespace Interpro\AdminPanelGenerator\Test;

use Illuminate\Foundation\Testing\TestCase;
use Interpro\AdminPanelGenerator\Factory\JSONGeneratorFactory;
use Interpro\AdminPanelGenerator\Page\JSONPage;

class GeneratorJSONTest extends TestCase
{
    private $taxonomyFactory;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../../../bootstrap/app.php';

        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function setUp()
    {
        $this->createApplication();

        $this->taxonomyFactory = new \Interpro\Core\Taxonomy\Factory\TaxonomyFactory();
    }
    
    public function testGenerator()
    {
        $family = 'qsaggr';
        $name = 'block1';
        $owns = ['own1'=>'string', 'own2'=>'int'];
        $refs = ['ref1'=>'group1', 'ref2'=>'group2'];
        $manA1 = new \Interpro\Core\Taxonomy\Manifests\ATypeManifest($family, $name, \Interpro\Core\Taxonomy\Enum\TypeRank::BLOCK, $owns, $refs);

        $family = 'qsaggr';
        $name = 'group1';
        $owns = ['own1'=>'string', 'own2'=>'int'];
        $refs = ['block_name'=>'block1'];
        $manA2 = new \Interpro\Core\Taxonomy\Manifests\ATypeManifest($family, $name, \Interpro\Core\Taxonomy\Enum\TypeRank::GROUP, $owns, $refs);

        $family = 'qsaggr';
        $name = 'group2';
        $owns = ['own1'=>'string', 'own2'=>'int', 'picture'=>'image'];
        $refs = ['superior'=>'group1', 'block_name'=>'block1'];
        $manA3 = new \Interpro\Core\Taxonomy\Manifests\ATypeManifest($family, $name, \Interpro\Core\Taxonomy\Enum\TypeRank::GROUP, $owns, $refs);


        $family = 'imageaggr';
        $name = 'image';
        $owns = ['name'=>'string', 'link'=>'string'];
        $manB1 = new \Interpro\Core\Taxonomy\Manifests\BTypeManifest($family, $name, $owns);


        $family = 'scalar';
        $name = 'string';
        $manC1 = new \Interpro\Core\Taxonomy\Manifests\CTypeManifest($family, $name, [], []);

        $family = 'scalar';
        $name = 'int';
        $manC2 = new \Interpro\Core\Taxonomy\Manifests\CTypeManifest($family, $name, [], []);

        $family = 'scalar';
        $name = 'bool';
        $manC3 = new \Interpro\Core\Taxonomy\Manifests\CTypeManifest($family, $name, [], []);

        $family = 'scalar';
        $name = 'float';
        $manC4 = new \Interpro\Core\Taxonomy\Manifests\CTypeManifest($family, $name, [], []);

        $family = 'scalar';
        $name = 'text';
        $manC5 = new \Interpro\Core\Taxonomy\Manifests\CTypeManifest($family, $name, [], []);


        $family = 'seo';
        $name = 'seo';
        $manC6 = new \Interpro\Core\Taxonomy\Manifests\CTypeManifest($family, $name, [], []);



        $manifestsCollection = new \Interpro\Core\Taxonomy\Collections\ManifestsCollection();
        $manifestsCollection->addManifest($manA1);
        $manifestsCollection->addManifest($manA2);
        $manifestsCollection->addManifest($manA3);
        $manifestsCollection->addManifest($manB1);
        $manifestsCollection->addManifest($manC1);
        $manifestsCollection->addManifest($manC2);
        $manifestsCollection->addManifest($manC3);
        $manifestsCollection->addManifest($manC4);
        $manifestsCollection->addManifest($manC5);
        $manifestsCollection->addManifest($manC6);

        $taxonomy = $this->taxonomyFactory->createTaxonomy($manifestsCollection);

        $generatorFactory = $this->generatorFactory = new JSONGeneratorFactory($taxonomy);

        $generator = $generatorFactory->createGenerator();

        $pageObject = new JSONPage('examplepage');

        //--------------------------------------------
        $generator->generatePage($pageObject);
        //--------------------------------------------

        $must_be = '{"layout": "layoutname",
                        "widgets": {
                            "qsaggr.block_page.block1": {
                                "own1": {
                                    "label": "",
                                    "field": "(field-own, owner=block1, type=string, name=own1)"
                                },
                                "own2": {
                                    "label": "",
                                    "field": "(field-own, owner=block1, type=int, name=own2)"
                                    },
                                "ref1": {
                                    "label": "",
                                    "field": "(field-ref, owner=block1, type=group1, name=ref1)"
                                    },
                                "ref2": {
                                    "label": "",
                                    "field": "(field-ref, owner=block1, type=group2, name=ref2)"
                                    }
                            },
                            "qsaggr.group_list.group1": {
                                "own1": {
                                    "label": "",
                                    "field": "(field-own, owner=group1, type=string, name=own1)"
                                    },
                                "own2": {
                                    "label": "",
                                    "field": "(field-own, owner=group1, type=int, name=own2)"
                                    }
                            }
                        }
                    }';

        $path = resource_path(config('interpro.generator.files.pagesdir')).'/examplepage.json';

        $this->assertJsonStringEqualsJsonFile(
            $path, $must_be
        );
    }
}



























