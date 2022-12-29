<?php

if (php_sapi_name() == 'cli-server') {
    chdir(__DIR__);
    $request_uri = parse_url($_SERVER["REQUEST_URI"]);
    $path = $request_uri['path'];

    $pages = [];
    foreach (glob("./pages/*.php") as $filename) {
        $name = basename($filename, ".php");
        $pages[$name] = $filename;
    }

    // echo $path;
    // css map
    if (substr($path, 1, 3) === "css") {
        header('Content-Type: text/css');
        readfile(".". $path);
        exit();
    }
    // img map
    if (substr($path, 1, 3) === "img") {
        header('Cache-Control: max-age='. 60*60);
        header('Content-Type: image/jpeg');
        readfile(".". $path);
        exit();
    }
    //TODO: redirect naar pagina zonder .php extensie
    if (substr($path, -4, 4) === ".php") {
        if (in_array(basename($path, ".php"), array_keys($pages))) {
            // header("Location: " . basename($path, ".php"));
            include $pages[basename($path, ".php")];    
            exit();
        }
        //de pagina bestaat niet
        return false;
    }
    if ($path === "/") {
        include "./pages/index.php";
        exit();
    }

    // //als er geen . in het path zit en de pagina bestaat
    if (!strpos($path, ".") && in_array(basename($path), array_keys($pages))) {
        include $pages[basename($path)];
        exit();
    }
    // echo basename($path);
    return false;
}
?>