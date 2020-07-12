<?php

namespace Glhd\ComposerHistory;

trait InteractsWithGit
{
	protected function getGitBranchName(): string
	{
		$branch = trim(shell_exec('git symbolic-ref HEAD'));
		return preg_replace('~^refs/(heads/)?~m', '', $branch);
	}
	
	protected function getAllGitBranches(): array
	{
		$branches = explode("\n", trim(shell_exec('git --no-pager branch -a')));
		
		return array_map(function($branch) {
			// $active = 0 === strpos($branch, '*');
			return preg_replace('/^\* */', '', $branch);
		}, $branches);
	}
}
