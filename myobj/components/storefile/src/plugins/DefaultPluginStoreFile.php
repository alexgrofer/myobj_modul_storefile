<?php
final class DefaultPluginStoreFile extends AbsPluginStoreFile implements IPluginStoreFileARModel
{
	const PATH_LOAD = 'media/upload/storefile'; //главная дирректория плагина, не можем изменять
	const MODEL_AR = 'ModelARStoreFile'; //модель в которой хранятся хранится файлы

	//обязательный метод определит название класса файла возвращаемый плагином
	public function getClassFileName() {
		return 'CStoreFile';
	}

	public function buildStoreFile($ARObj) {
		//создать объект файла
		$nameClassStoreFile = $this->getClassFileName();
		$objStoreFile = new $nameClassStoreFile($this,$ARObj);
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
}