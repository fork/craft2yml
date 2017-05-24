<?php
namespace Craft;

class Craft2ymlPlugin extends BasePlugin
{
	public function init()
	{
		// require composer dependencies
		require_once 'vendor/autoload.php';
	}

	function getName()
	{
		return 'Craft2yml';
	}

	function getVersion()
	{
		return '1.0.1';
	}

	public function getSchemaVersion()
	{
		return '1.0.0';
	}

	function getDeveloper()
	{
		return 'Fork Unstable Media GmbH';
	}

	function getDeveloperUrl()
	{
		return 'http://fork.de';
	}

	public function getReleaseFeedUrl()
	{
		return 'https://raw.githubusercontent.com/fork/craft2yml/master/releases.json';
	}
}