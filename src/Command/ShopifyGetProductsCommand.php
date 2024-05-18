<?php

namespace App\Command;

use App\ThirdParty\Shopify\Api\Product\ProductRequestServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'shopify:get:products',
    description: 'Add a short description for your command',
)]
class ShopifyGetProductsCommand extends Command
{
    public function __construct(
        private readonly ProductRequestServiceInterface $productRequestService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::OPTIONAL, 'Product Identifier')
            #->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $id = $input->getArgument('id');

        $response = $id
            ? $this->productRequestService->getProductById($id)
            : $this->productRequestService->getProducts();

        /*if ($input->getOption('option1')) {
            // ...
        }*/

        var_export($response->getData());

        $io->success('Successfully imported products');

        return Command::SUCCESS;
    }
}
