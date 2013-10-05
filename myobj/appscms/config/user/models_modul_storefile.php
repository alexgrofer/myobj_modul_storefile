<?php
$models = array(
	//STORE
	'storefile' => array(
		'namemodel' => 'ModelARStoreFile',
		'order_by' => array('id DESC'),
	),
);
Yii::app()->params['api_conf_models'] =  array_merge(Yii::app()->params['api_conf_models'],$models);
