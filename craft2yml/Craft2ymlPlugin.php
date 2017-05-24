<?php
namespace Craft;

class Craft2ymlPlugin extends BasePlugin
{
	function getName()
	{
		return 'Craft2yml';
	}

	function getVersion()
	{
		return '1.0';
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