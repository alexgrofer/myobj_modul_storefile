<?php
$objPlugin = new $modelAD->namePluginLoader();
$modelAD->thiObjFile = yii::app()->storeFile->obj($objPlugin,$modelAD);

$paramsQueryPostModel = yii::app()->getRequest()->getPost(get_class($modelAD));
if($paramsQueryPostModel) {
	$modelAD->attributes = $paramsQueryPostModel;
	//важный фактор только после этой конструкции форма $form начинает обрабатывать ошибки
	$isValidate = $modelAD->validate();
}

//можно удалять отдельные элементы
if($modelAD->is_del && $modelAD->indexEdit!='') {
	$modelAD->thiObjFile->del($modelAD->indexEdit);
}
//если добавил файл или файлы,все остальные действия перекладываем на плагин и модель
if((isset($isValidate) && $isValidate) && $this->dicturls['action']=='edit') {
	$files = CUploadedFile::getInstancesByName(get_class($modelAD).'[fileAdd]');

	if($modelAD->indexEdit!='') {
		$indexEdit = $modelAD->indexEdit;
	}
	else {
		$indexEdit = $modelAD->thiObjFile->objPlugin->getNextIndex();
	}

	foreach($files as $file) {
		/* ФАЙЛ */
		$modelAD->thiObjFile->set_File($file,$indexEdit);
		/* ИМЯ ФАЙЛА */
		if($modelAD->is_randName) {
			$modelAD->thiObjFile->set_IsRand(true,$indexEdit);
		}
		elseif($modelAD->nameFile!='') {
			$modelAD->thiObjFile->set_Name($modelAD->nameFile,$indexEdit);
		}

		$indexEdit++;
	}

}
/*
 * продолжиться дальнейшее исполнение obj.php контроллера который вызовет метод save
 */


