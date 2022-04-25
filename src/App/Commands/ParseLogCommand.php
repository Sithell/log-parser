<?php

namespace Console\App\Commands;

use Console\App\Helpers\FileHelper;
use Console\App\Models\Metrics;
use Console\App\Services\MetricsService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class ParseLogCommand extends Command
{
    protected function configure()
    {
        $this->setName('parse')
            ->setDescription('Parses given access_log file.')
            ->setHelp('Prints number of views, number of unique urls, traffic volume, number of lines, number of requests from search engines, response codes.')
            ->addArgument('path', InputArgument::REQUIRED, 'Pass the path to log file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = $input->getArgument('path');
        if (!FileHelper::exists($path)) {
            $output->writeln('File does not exist');
            return Command::FAILURE;
        }

        $result = new Metrics();
        FileHelper::readInChunks($path, function (array $chunk) use ($result) {
            $chunkMetrics = MetricsService::instance()->collectMetrics($chunk);
            $result->add($chunkMetrics);
        });

        $badLines = $result->badLines();
        if ($badLines > 0) {
            $output->writeln("Found invalid lines: $badLines");
        }

        $output->writeln(json_encode($result->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return Command::SUCCESS;
    }
}
