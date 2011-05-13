<?php


require 'bootstrap.php';

Doctrine_Core::loadModels(APPLICATION_PATH . DS . 'models');

$q = new Doctrine_RawSql();
