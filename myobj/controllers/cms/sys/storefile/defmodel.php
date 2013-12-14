<?php

//плагин может управлять моделью к примеру relation, можно и не создавать плагин а просто передать имя
//при создании плагина есть возможность сконфигурировать его
$objPlugin = new $modelAD->namePluginLoader();
$modelAD->objfile = yii::app()->storeFile->obj($objPlugin,$this);

