<?php

namespace Luis\MagentoTest\Console\Command;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Luis\MagentoTest\Helper\ConfigHelper;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Cache\Frontend\Pool;

class ColorChange extends Command
{
    /** @var ConfigHelper */
    protected $configHelper;
    protected $cacheTypeList;
    protected $cacheFrontendPool;

    /**
     * @param ConfigHelper $configHelper
     * @param string|null $name
     */
    public function __construct(
        ConfigHelper $configHelper,
        TypeListInterface $cacheTypeList,
        Pool $cacheFrontendPool,
        string $name = null
    ) {
        $this->configHelper = $configHelper;
        $this->cacheTypeList = $cacheTypeList;
        $this->cacheFrontendPool = $cacheFrontendPool;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('scandiweb:color-change');
        $this->setDescription('Change the primary colors of the front-end');
        $this->addOption(
            'text-color',
            null,
            InputOption::VALUE_REQUIRED,
            'Primary Text Color'
        )->addOption(
        'bg-color',
        null,
        InputOption::VALUE_REQUIRED,
        'Primary Background Color'
        )->addOption(
            'store-id',
            null,
            InputOption::VALUE_REQUIRED,
            'Store ID'
        );

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$textColor = $input->getOption('text-color')) {
            $output->writeln('<error>Please provide a text-color</error>');
            return Cli::RETURN_FAILURE;
        }

        if (!ctype_xdigit($textColor) || strlen($textColor) != 6) {
            $output->writeln('<error>Please provide a valid text-color, it must be 6 chars long</error>');
        }

        if (!$bgColor = $input->getOption('bg-color')) {
            $output->writeln('<error>Please provide a bg-color, it must be 6 chars long</error>');
            return Cli::RETURN_FAILURE;
        }

        if (!ctype_xdigit($bgColor) || strlen($bgColor) != 6) {
            $output->writeln('<error>Please provide a valid bg-color</error>');
        }

        if (!$storeId = (int)$input->getOption('store-id')) {
            $output->writeln('<error>Please provide a store ID</error>');
            return Cli::RETURN_FAILURE;
        }

        $this->configHelper->setPrimaryBgColor($bgColor, $storeId);
        $this->configHelper->setPrimaryTextColor($textColor, $storeId);

        /**
         * Cleaning the required caches
         */
        $_types = [
            'config',
            'full_page',
        ];

        foreach ($_types as $type) {
            $this->cacheTypeList->cleanType($type);
        }

        foreach ($this->cacheFrontendPool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }

        $output->writeln('<info>text-color and bg-color set successfully!</info>');
    }
}
