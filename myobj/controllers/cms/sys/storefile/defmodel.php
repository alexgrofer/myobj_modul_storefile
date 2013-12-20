<?php
$objPlugin = new $modelAD->namePluginLoader();
$modelAD::$thiObjFile = yii::app()->storeFile->obj($objPlugin,$this);

//если добавил файл или файлы,все остальные действия перекладываем на плагин и модель
if($this->dicturls['action']!='edit') {
	$files = CUploadedFile::getInstancesByName(get_class($modelAD).'[fileAdd]');
	if($files) {
		/* ФАЙЛ */
		//если хочет добавить еще один файл или файлы
		if($modelAD->indexEdit=='' && count($files)>1) {
			$modelAD::$thiObjFile->filesMany = $files;
		}
		//в случае с отдельным файлом или редактировании отдельного элемента
		elseif(count($files)==1 || $modelAD->indexEdit!='') {
			if($modelAD->indexEdit!='') {
				$indexEdit = $modelAD->indexEdit;
			}
			else {
				$indexEdit = '';//взять последний
			}
			/* НОВЫЙ ФАЙЛ */
			if(count($files)==1) {
				$modelAD::$thiObjFile->file = $files[0];
			}
			/* ИМЯ ФАЙЛА */
			if($this->nameFile!='' || $this->is_randName) {
				static::$thiObjFile->setName('sdfsf', $indexEdit);
			}


		}
	}
}

$modelAD->indexEdit = 34543;

