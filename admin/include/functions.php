<?php
/*
 * Load Only one View file with Parameters
 */
function loadView($file, $params = array()) {
    
    if(!empty($params)) {
        extract($params);
    }   
    
    include realpath(dirname(__FILE__)).'/../view/'.$file.'.php';
}

/*
 * Load File Wraped in template files
 * Header, Navigation and Footer
 */
function loadTemplate($mainFile, $params = array()) {
    
    loadView("template/header", $params);
    loadView('template/navigation', $params);
    
    loadView($mainFile, $params);
    
    loadView("template/footer", $params);
}

function active($string, $inclass = false) {
    $request = $_SERVER['REQUEST_URI'];
    if(strpos($request, $string) != false) {
        if($inclass) {
            return ' active';
        } else {
            return ' class="active"';
        }
    } else {
        return '';
    }
}
?>