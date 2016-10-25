<?php

namespace Interpro\AdminPanelGenerator\Commands;

use Illuminate\Console\Command;
use Interpro\AdminPanelGenerator\Contracts\Generator;
use Interpro\AdminPanelGenerator\GeneratorException;
use Interpro\AdminPanelGenerator\Page\JSONPage;

class GeneratePage extends Command
{
    /**
     * @var string
     */
    protected $signature = 'generate:page {--page=all}';

    /**
     * @var string
     */
    protected $description = 'Генерация страниц для админ. панели';

    private $generator;

    /**
     * @return void
     */
    public function __construct(Generator $generator)
    {
        parent::__construct();

        $this->generator = $generator;
    }

    /**
     * @return void
     */
    public function handle()
    {
        try
        {
            $page = $this->option('page');

            if($page === 'all')
            {
                $page_config = config('interpro.generator.pages');

                if($page_config)
                {
                    foreach($page_config as $page_name=>$page_array)
                    {
                        $pageObject = new JSONPage($page_name);
                        $this->generator->generatePage($pageObject);
                    }
                }
                else
                {
                    $this->warn('Генерация страниц закончена');
                }
            }
            else
            {
                $pageObject = new JSONPage($page);
                $this->generator->generatePage($pageObject);
            }

            $this->info('Генерация страниц закончена');
        }
        catch(GeneratorException $gExc)
        {
            $this->warn($gExc->getMessage());
        }

    }

}
