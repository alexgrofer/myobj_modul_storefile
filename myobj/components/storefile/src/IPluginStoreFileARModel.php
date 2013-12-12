<?php
/**
 * Интерфейс плагина свойственный файлам которые хранятся в AR модели yii
 */
interface IPluginStoreFileARModel {
	//собирает файл из объекта AR
	public function buildStoreFile($ARObj);
}