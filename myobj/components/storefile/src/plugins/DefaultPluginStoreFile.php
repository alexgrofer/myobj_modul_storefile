<?php
final class DefaultPluginStoreFile extends AbsPluginStoreFile implements IPluginStoreFileARModel
{
	const PATH_LOAD = 'media/upload/storefile'; //главная дирректория плагина, не можем изменять
	const MODEL_AR = 'ModelARStoreFile'; //модель в которой хранятся хранится файлы
	const COL_NAME_FILE_AR = 'content_file_array';

	//обязательный метод определит название класса файла возвращаемый плагином
	public function getClassFileName() {
		return 'CStoreFile';
	}

	public $arObj; //объект yii AR которым будет управлять плагин
	public function buildStoreFile($ARObj) {
		//создать объект файла
		$nameClassStoreFile = $this->getClassFileName();
		$cloneFilter = clone $this;
		$cloneFilter->arObj = $ARObj;
		$objStoreFile = new $nameClassStoreFile($cloneFilter);
		return $objStoreFile;
	}

	/**
	 * Инициализация объектов файлов свойственной для этого планина, каждый плагин может по своему искать, инициализировать файлы
	 * @param null $arrIdObj массив id файлов или объект AR
	 * @return mixed может быть массив или один объект типа getClassFileName
	 */
	public function factoryInit($arrIdObj=null) {
		if(is_object($arrIdObj)) {
			$objModelStoreFile = $arrIdObj;
		}
		else {
			$nameClassARModel = $this::MODEL_AR;
			$objModelStoreFile = new $nameClassARModel();
		}

		if(!$arrIdObj || is_object($arrIdObj)) {
			return $this->buildStoreFile($objModelStoreFile);
		}
		elseif(is_array($arrIdObj) && count($arrIdObj)) {
			$objModelStoreFile->dbCriteria->addInCondition('id', $arrIdObj);
			$arrayObjARStoreFile = $objModelStoreFile->findAll();
			$arrayObjStoreFile = array();
			foreach($arrayObjARStoreFile as $ARObj) {
				$arrayObjStoreFile[] = $this->buildStoreFile($ARObj);
			}
			return $arrayObjStoreFile;
		}
	}

	//описывает что делать с объектом при сохранении
	public function save() {

	}

	//описывает что делать с объектом при удалении
	public function del() {

	}

	//кастомно определяет правила валидации для текушей модели файла
	public function validateModel() {

	}
	//индекс следующего нового элемента
	public function getNextIndex() {
		return count($this->arObj->get_EArray(self::COL_NAME_FILE_AR));
	}
}