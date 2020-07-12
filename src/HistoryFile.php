<?php

namespace Glhd\ComposerHistory;

use JsonException;

class HistoryFile
{
	use InteractsWithGit;
	
	protected const HISTORY_FILE = '.composer-history';
	
	public function getHistory($branch): array
	{
		$config = $this->loadConfig();
		
		return $config[$branch] ?? [];
	}
	
	public function saveHistory($branch, $command): bool
	{
		$config = $this->loadConfig();
		
		if (!isset($config[$branch])) {
			$config[$branch] = [];
		}
		
		$config[$branch][] = (object) [
			'timestamp' => time(),
			'command' => $command,
		];
		
		$config = $this->pruneConfig($config);
		
		return $this->saveConfig($config);
	}
	
	protected function pruneConfig(array $config): array
	{
		$current_branches = $this->getAllGitBranches();
		
		foreach ($config as $branch => $history) {
			if (!in_array($branch, $current_branches)) {
				unset($config[$branch]);
			}
		}
		
		return $config;
	}
	
	protected function saveConfig(array $config): bool
	{
		try {
			$data = json_encode($config, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
		} catch (JsonException $e) {
			return false;
		}
		
		return false !== file_put_contents(static::HISTORY_FILE, $data);
	}
	
	protected function loadConfig(): array
	{
		if (!file_exists(static::HISTORY_FILE)) {
			return [];
		}
		
		try {
			return json_decode(file_get_contents(static::HISTORY_FILE), true, 12, JSON_THROW_ON_ERROR);
		} catch (JsonException $e) {
			return [];
		}
	}
}
