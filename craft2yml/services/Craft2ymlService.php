<?php
namespace Craft;

use Symfony\Component\Yaml\Yaml;

class Craft2ymlService extends BaseApplicationComponent {

	/**
	 * @param string $entryId the id of the entry to generate yml from
	 * @return string
	 */
	public function getYmlByEntryId($entryId)
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

		// build yaml
		$inlineLimit = craft()->config->get('inlineLimit', 'craft2yml');
		return Yaml::dump($ymlContent, $inlineLimit, 2);
	}

	// TODO: handle more field types (date, table...)
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
			} elseif ($field->type == 'Matrix' || $field->type == 'Neo') {
				/** @var MatrixBlockModel $matrixBlock */
				$matrixBlock = $element->getFieldValue($field->handle);
				/** @var MatrixBlockModel $item */
				foreach ($matrixBlock->getChildren() as $item) {
					$content[$field->handle][] = array_merge(array('type' => $item->getType()->handle), $this->getFieldData($item));
				}
			} else if ($field->type == 'Entries' || $field->type == 'Categories' || $field->type == 'Tags') {
				$entries = $element->getFieldValue($field->handle);
				foreach ($entries->find() as $entry) {
					$content[$field->handle][] = array(
						'title' => $entry->title,
						'uri' => $entry->uri
					);
				}
			} else {
				$content[$field->handle] = $element->getContent()->getAttribute($field->handle);
			}
		}

		return $content;
	}
}
