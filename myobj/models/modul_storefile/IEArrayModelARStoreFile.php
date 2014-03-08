<?php
/**
 * Интерфейс для модели которая использует для храненя данных массив EArray
 */
interface IEArrayModelARStoreFile {
	/**
	 * Нозвание колонки в которой хранится EArray
	 * @return string
	 */
	public function getNameColEArray();
	/**
	 * Настройки для EArray
	 * @return string
	 */
	public function typesEArray();
}