<?php

namespace Glhd\ComposerHistory;

use Composer\Plugin\CommandEvent;

class LogEvent
{
	use InteractsWithGit;
	
	protected const OBSERVED_COMMANDS = [
		'require', 
		'install', 
		'update', 
		'remove'
	];
	
	protected $event;
	
	protected $history;
	
	public function __construct(CommandEvent $event)
	{
		$this->event = $event;
		$this->history = new HistoryFile();
	}
	
	public function __invoke()
	{
		if (!$this->isObservedCommand()) {
			return;
		}
		
		$branch = $this->getGitBranchName();
		$command = (string) $this->event->getInput();
		
		$this->history->saveHistory($branch, $command);
	}
	
	protected function isObservedCommand(): bool
	{
		$input = $this->event->getInput();
		$arguments = $input->getArguments();
		
		$command_name = $arguments['command'] ?? null;
		$command = (string) $input;
		
		return in_array($command_name, static::OBSERVED_COMMANDS)
			&& false === stripos($command, '--dry-run');
	}
}
