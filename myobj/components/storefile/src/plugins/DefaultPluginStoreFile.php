<?php
final class DefaultPluginStoreFile extends AbsPluginStoreFile implements IPluginStoreFileARModel
{
	const PATH_LOAD = 'media/upload/storefile'; //главная дирректория плагина, не можем изменять

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
	 * @param null $arrIdObj список файлов
	 * @return mixed может быть массив или один объект типа getClassFileName
	 */
	public function factoryInit($arrIdObj=null) {
		$nameClassARModel = $this->_params['ar_model_store_file'];
		$objModelStoreFile = $nameClassARModel::model();
		if(!$arrIdObj) {
			return $this->buildStoreFile($objModelStoreFile);
		}
		elseif(count($arrIdObj)) {
			$objModelStoreFile->dbCriteria->addInCondition('id', $arrIdObj);
			$arrayObjARStoreFile = $objModelStoreFile->findAll();
			$arrayObjStoreFile = array();
			foreach($arrayObjARStoreFile as $ARObj) {
				$arrayObjStoreFile[] = $this->buildStoreFile($ARObj);
			}
			return $arrayObjStoreFile;
		}
	}
	//можно организовать некоторые вспомогательные методы?
}