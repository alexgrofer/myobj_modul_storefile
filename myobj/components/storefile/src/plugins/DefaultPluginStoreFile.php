<?php
final class DefaultPluginStoreFile extends AbsPluginStoreFile implements IPluginStoreFileARModel
{
	const PATH_LOAD = 'media/upload/storefile'; //главная дирректория плагина, не можем изменять
	const MODEL_AR = 'ModelARStoreFile'; //модель в которой хранятся хранится файлы
	const COL_NAME_FILE_AR = 'content_file_array';
	const COUNT_SING_RAND_NAME = 15;

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
	public function save($objFile) {
		//сам объект $objFile->objPlugin->arObj - возможно нужно поменять значения earray перед сохранением
		//управляющий плагин (сконфигурированный) $objFile->objPlugin

		//1)Если добавил пачкой
		/* @var CStoreFile $objFile */
		if($objFile->FilesMany) {
			//начинаем сохранять файлы по одному
			foreach($objFile->FilesMany as $fileUploader) {
				/* @var CUploadedFile $fileUploader */
				/* @var CFile $loadFile */
				$loadFile = Yii::app()->CFile->set($fileUploader->tempName, true);
				$newNameFile = ($objFile->isRand)?
					self::randName(self::COUNT_SING_RAND_NAME).CFileHelper::getExtension($fileUploader->name)
						:
					$fileUploader->name;
				$loadFile->move(self::PATH_LOAD.DIRECTORY_SEPARATOR.$newNameFile);
			}
		}

		//если установил всем рандомное название всем рандомное название

		//если не ставил рандомное сохраняем с теми же названиями

		//ФАЙЛЫ с индексами пройти по _realArrayConfObj
		//причем когда редактирует в ручную возможно в этом массиве будет не только один элемент

		//создание миниатюр и т.д - вызвать спец метод именно плагина realty

		//сохранение изменений в earray

		exit;
	}

	//описывает что делать с объектом при удалении
	public function del($objFile,$key=null) {

	}

	//кастомно определяет правила валидации для текушей модели файла
	public function validateModel() {
		//можно установить максимумы размеров например
	}

	//методы помошники рандомы, кропы для картинок, архивация

	//индекс следующего нового элемента
	public function getNextIndex() {
		return count($this->arObj->get_EArray(self::COL_NAME_FILE_AR));
	}

	public static function randName($countSings) {
		$varStr = 'qwertyuiopasdfghjklzxcvbnm1234567890';
		return substr(str_shuffle($varStr.$varStr),0,$countSings);
	}
}