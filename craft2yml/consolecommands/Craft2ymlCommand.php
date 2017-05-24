<?php
namespace Craft;

class Craft2ymlCommand extends BaseCommand
{
	/**
	 * @param string $entryId the id of the entry to generate yml from
	 * @param string $targetFile name of the target yml file
	 */
	public function actionSaveYml($entryId, $targetFile)
	{
		$yml = craft()->craft2yml->getYmlByEntryId($entryId);
		file_put_contents($targetFile, $yml);
	}

}