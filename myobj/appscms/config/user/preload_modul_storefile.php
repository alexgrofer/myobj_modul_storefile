<?php
$components_preload_user = array(
	'storeFile',
);

Yii::app()->params['api_conf_components_preload'] =  array_merge(Yii::app()->params['api_conf_components_preload'],$components_preload_user);
