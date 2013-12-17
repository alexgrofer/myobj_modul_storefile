<?php
$objPlugin = new $modelAD->namePluginLoader();
$modelAD::$thiObjFile = yii::app()->storeFile->obj($objPlugin,$this);

//если добавил файл или файлы

$files = CUploadedFile::getInstancesByName(get_class($modelAD).'[fileAdd]');
if($files) {
	$modelAD::$thiObjFile->filesMany = $files;

}


