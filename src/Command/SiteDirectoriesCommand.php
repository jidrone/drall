<?php

namespace Drall\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A command to get a list of site directories in the Drupal installation.
 */
class SiteDirectoriesCommand extends BaseCommand {

  protected function configure() {
    parent::configure();

    $this->setName('site:directories');
    $this->setAliases(['sd']);
    $this->setDescription('Get a list of site directories.');
    $this->addUsage('site:directories');
    $this->addUsage('--drall-group=GROUP site:directories');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $this->preExecute($input, $output);

    $dirNames = $this->siteDetector()
      ->getSiteDirNames(
        $this->getDrallGroup($input),
        $this->getDrallFilter($input),
      );

    if (count($dirNames) === 0) {
      $this->logger->warning('No Drupal sites found.');
      return 0;
    }

    foreach ($dirNames as $dirName) {
      $output->writeln($dirName);
    }

    return 0;
  }

}
