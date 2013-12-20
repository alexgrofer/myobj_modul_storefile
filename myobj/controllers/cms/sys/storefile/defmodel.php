<?php
$objPlugin = new $modelAD->namePluginLoader();
$modelAD::$thiObjFile = yii::app()->storeFile->obj($objPlugin,$this);

$paramsQueryPostModel = yii::app()->getRequest()->getPost(get_class($modelAD));
if($paramsQueryPostModel) {
	$modelAD->attributes = $paramsQueryPostModel;
	//важный фактор только после этой конструкции форма $form начинает обрабатывать ошибки
	$isValidate = $modelAD->validate();
}

//если добавил файл или файлы,все остальные действия перекладываем на плагин и модель
if($isValidate && $this->dicturls['action']!='edit') {
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
				$indexEdit = count($modelAD->get_EArray('content_file_array'))-1;
			}
			/* НОВЫЙ ФАЙЛ */
			if(count($files)==1) {
				$modelAD::$thiObjFile->setFile($files[0],$indexEdit);
			}
			/* ИМЯ ФАЙЛА */
			if($this->nameFile!='' || $this->is_randName) {
				static::$thiObjFile->setName('sdfsf', $indexEdit);
			}
		}
	}
}


