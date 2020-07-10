<?php

namespace Glhd\ComposerHistory;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowHistoryCommand extends BaseCommand
{
	use InteractsWithGit;
	
	protected function configure()
	{
		$this->setName('show-history');
		$this->addOption('executable');
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$branch = $this->getGitBranchName();
		$history = (new HistoryFile())->getHistory($branch);
		
		$output->writeln('');
		
		$output->writeln("Command history for <comment>{$branch}</comment>");
		
		$output->writeln('');
		
		if ($input->getOption('executable')) {
			$this->printForShell($history, $output);
		} else {
			$this->prettyPrint($history, $output);
		}
		
		$output->writeln('');
	}
	
	protected function prettyPrint(array $history, OutputInterface $output)
	{
		foreach ($history as $item) {
			$item = (object) $item;
			$date = date('Y-m-d H:i:s', $item->timestamp);
			$output->writeln("[{$date}] <info>composer {$item->command}</info>");
		}
	}
	
	protected function printForShell(array $history, OutputInterface $output)
	{
		$count = count($history);
		$lines = array_values($history);
		
		foreach ($lines as $line => $item) {
			$item = (object) $item;
			$command = "composer {$item->command}";
			
			if (0 !== $line) {
				$command = "  && {$command}";
			}
			
			if ($line !== ($count - 1)) {
				$command .= " \ ";
			}
			
			$output->writeln("<info>{$command}</info>");
		}
	}
}
