<?php
namespace Craft;

use Symfony\Component\Yaml\Yaml;

class Craft2ymlCommand extends BaseCommand
{
	/**
	 * @param string $entryId the id of the entry to generate yml from
	 * @param string $targetFile name of the target yml file
	 */
	public function actionSaveYml($entryId, $targetFile)
	{
		$ymlContent = array();

		// globals data
		$globalsContent = array();
		$globalSets = craft()->globals->getAllSets();
		/** @var GlobalSetModel $globalSet */
		foreach ($globalSets as $globalSet) {
			$globalsContent[$globalSet->handle] = $this->getFieldData($globalSet);
		}
		$ymlContent = array_merge($ymlContent, $globalsContent);

		// entry data
		$entry = craft()->entries->getEntryById($entryId);
		$content = array('entry' => $this->getFieldData($entry));

		$ymlContent = array_merge($ymlContent, $content);

		// save yaml file
		// TODO: make inline limit a setting maybe
		$yml = Yaml::dump($ymlContent, 4, 2);
		file_put_contents($targetFile, $yml);
	}


	/**
	 * @param mixed $element
	 * @return array
	 */
	private function getFieldData($element) {
		$layout = $element->getFieldLayout();
		$fields = $layout->getFields();

		$content = array();
		/** @var FieldLayoutFieldModel $fieldLayout */
		foreach ($fields as $fieldLayout) {
			/** @var FieldModel $field */
			$field = $fieldLayout->getField();
			if ($field->type == 'Assets') {
				$asset = $element->getFieldValue($field->handle)->first();
				$content[$field->handle] = $asset->getUrl();
			} elseif ($field->type == 'Matrix') {
				/** @var MatrixBlockModel $matrixBlock */
				$matrixBlock = $element->getFieldValue($field->handle);
				/** @var MatrixBlockModel $item */
				foreach ($matrixBlock->getChildren() as $item) {
					$content[$field->handle][] = $this->getFieldData($item);
				}
			} else {
				$content[$field->handle] = $element->getContent()->getAttribute($field->handle);
			}
		}

		return $content;
	}

}