<?php

namespace Glhd\ComposerHistory;

trait InteractsWithGit
{
	protected function getGitBranchName(): string
	{
		$branch = trim(shell_exec('git symbolic-ref HEAD'));
		return preg_replace('~^refs/(heads/)?~m', '', $branch);
	}
}
