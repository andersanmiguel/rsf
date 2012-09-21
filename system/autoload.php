<?php 

function load_system($class_name) {
    if(file_exists(SYSTEM.strtolower($class_name).'.php')) {
        include SYSTEM.strtolower($class_name).'.php';
    }
}
function load_controllers($class_name) {
    if (file_exists(BASE.'controller/'.strtolower(str_replace('_', '/', $class_name)).'.php')) {
        include BASE.'controller/'.strtolower(str_replace('_', '/', $class_name)).'.php';
    }
}
function load_models($class_name) {
    if (file_exists(BASE.'model/'.strtolower($class_name).'.php')) {
        include BASE.'model/'.strtolower($class_name).'.php';
    }
}

spl_autoload_register('load_system');
spl_autoload_register('load_controllers');
spl_autoload_register('load_models');
