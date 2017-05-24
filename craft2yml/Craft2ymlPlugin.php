<?php
namespace Craft;

class Craft2ymlPlugin extends BasePlugin
{
	public function init()
	{
		// require composer dependencies
		require_once 'vendor/autoload.php';
	}

	public function getName()
	{
		return 'Craft2yml';
	}

	public function getVersion()
	{
		return '1.0.3';
	}

	public function getSchemaVersion()
	{
		return '1.0.0';
	}

	public function getDeveloper()
	{
		return 'Fork Unstable Media GmbH';
	}

	public function getDeveloperUrl()
	{
		return 'http://fork.de';
	}

	public function getReleaseFeedUrl()
	{
		return 'https://raw.githubusercontent.com/fork/craft2yml/master/releases.json';
	}

	public function registerSiteRoutes()
	{
		if (craft()->config->get('useYmlUrlRoute', 'craft2yml')) {
			return array(
				'(?P<entryUri>.*)\.yml$' => array('action' => 'craft2yml/showYml'),
			);
		}
	}
}