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
		$clonePlugin = clone $this;
		$objStoreFile = new $nameClassStoreFile($clonePlugin);
		$clonePlugin->arObj = $ARObj;
		$clonePlugin->arObj->thiObjFile = $objStoreFile;
		return $clonePlugin->arObj->thiObjFile;
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

		foreach($objFile->realArrayConfObj as $keyFile => $newSetting) {
			//DATA EDIT

			$userPathFile = '';
			if(isset($newSetting['path'])) {
				//изменить earray
				$this->arObj->edit_EArray($newSetting['path'],self::COL_NAME_FILE_AR,'path',$keyFile);
				$userPathFile = $newSetting['path'].DIRECTORY_SEPARATOR;
			}

			if(isset($newSetting['title'])) {
				$this->arObj->edit_EArray($newSetting['title'],self::COL_NAME_FILE_AR,'title',$keyFile);
			}

			if(isset($newSetting['sort'])) {
				$this->arObj->edit_EArray($newSetting['sort'],self::COL_NAME_FILE_AR,'sort',$keyFile);
			}
			//FILE EDIT
			if(isset($newSetting['file'])) {

				$newFileUploader = $newSetting['file'];
				$loadFile = Yii::app()->CFile->set($newFileUploader->tempName, true);
				$newNameFile = (isset($newSetting['rand']))?
					self::randName(self::COUNT_SING_RAND_NAME).'.'.CFileHelper::getExtension($newFileUploader->name)
					:
					$newFileUploader->name;
				if($userPathFile) {
					$loadFile->createDir(0754, self::PATH_LOAD.DIRECTORY_SEPARATOR.$userPathFile);
				}
				$loadFile->move(self::PATH_LOAD.DIRECTORY_SEPARATOR.$userPathFile.$newNameFile);

			}
			//просто хочет переименовать существующий файл , изменить путь
			elseif(isset($newSetting['rand']) || isset($newSetting['name'])) {
				$newNameFile = (isset($newSetting['rand']))?self::randName(self::COUNT_SING_RAND_NAME):$newSetting['name'];

				$oldNameFile = $this->arObj->get_EArray(self::COL_NAME_FILE_AR, 'name', $keyFile, true);
				$oldPathFile = $this->arObj->get_EArray(self::COL_NAME_FILE_AR, 'path', $keyFile, true);

				$loadFile = Yii::app()->CFile->set(self::PATH_LOAD.DIRECTORY_SEPARATOR.$oldPathFile.$objFile->get_Name($oldNameFile), true);
				$loadFile->rename(self::PATH_LOAD.DIRECTORY_SEPARATOR.$userPathFile.$newNameFile);

			}
			//OBJ EDIT
			if(isset($newNameFile)) {
				$this->arObj->edit_EArray($newNameFile,self::COL_NAME_FILE_AR,'name',$keyFile);
			}
		}

		//создание миниатюр и т.д - вызвать спец метод именно плагина realty
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