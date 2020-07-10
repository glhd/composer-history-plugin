<?php

namespace Glhd\ComposerHistory;

class HistoryFile
{
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
		
		return $this->saveConfig($config);
	}
	
	protected function saveConfig(array $config): bool
	{
		$data = json_encode($config, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
		
		return false !== file_put_contents(static::HISTORY_FILE, $data);
	}
	
	protected function loadConfig(): array
	{
		if (!file_exists(static::HISTORY_FILE)) {
			return [];
		}
		
		return json_decode(file_get_contents(static::HISTORY_FILE), true, 12, JSON_THROW_ON_ERROR);
	}
}
