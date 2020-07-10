<?php

namespace Glhd\ComposerHistory;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\CommandEvent;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\PluginInterface;

class Plugin implements PluginInterface, EventSubscriberInterface, Capable
{
	protected $composer;
	
	protected $io;
	
	public static function getSubscribedEvents(): array
	{
		return [
			PluginEvents::COMMAND => [
				['logEvent', 0],
			],
		];
	}
	
	public function activate(Composer $composer, IOInterface $io)
	{
		$this->composer = $composer;
		$this->io = $io;
	}
	
	public function getCapabilities(): array
	{
		return [
			CommandProvider::class => Commands::class,
		];
	}
	
	public function logEvent(CommandEvent $event)
	{
		$logger = new LogEvent($event);
		
		$logger();
	}
}
