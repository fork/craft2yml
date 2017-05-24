<?php
namespace Craft;

class Craft2ymlController extends BaseController {

	protected $allowAnonymous = array('actionShowYml');

	public function actionShowYml(array $variables = array()) {

		$criteria = craft()->elements->getCriteria(ElementType::Entry);
		$criteria->uri = $variables['entryUri'];
		$criteria->limit = 1;
		$entry = $criteria->first();

		if (empty($entry)) {
			return 'entry not found';
		}

		$yml = craft()->craft2yml->getYmlByEntryId($entry->id);

		header('Content-Type: text/yaml; charset=utf-8');

		echo $yml;
		craft()->end();
	}

}