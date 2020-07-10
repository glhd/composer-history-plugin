<?php

namespace Glhd\ComposerHistory;

use Composer\Plugin\Capability\CommandProvider;

class Commands implements CommandProvider
{
	public function getCommands()
	{
		return [
			new ShowHistoryCommand(),
		];
	}
}
