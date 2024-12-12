<?php
    // echo $_SERVER['REQUEST_URI'];
    $txt_registry_file = 'urls.txt';
    $domain = localhost/php_url_shortener/;
    if ($_SERVER['REQUEST_URI'] == '/php_url_shortener/'){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $url = $_POST["url"];
            if (!filter_var($url, FILTER_VALIDATE_URL)){
                die ('Url inválida');
            }
            else{
                $hash = substr(hash('md5', $url),0,8);
                file_put_contents($txt_registry_file, "$hash,$url\n", FILE_APPEND);
                echo "<a href='$url'>"$domain.$hash."</a>";
            }
        }
        else{
            echo'
                <!DOCTYPE html>f
                <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Document</title>
                    </head>
                    <body>
                        <form method="post">
                            <label for="url">Url</label>
                            <input type="text" name="url" id="url">
                            <button type="submit">Shorten</button>
                        </form>
                    </body>
                </html>
            ';
        }
    }
    else{
        $basePath = '/php_url_shortener/';
        $requestUri = $_SERVER['REQUEST_URI'];
        $short_url = substr($requestUri, strlen($basePath));
        echo $short_url;
            // Leer el archivo para encontrar la URL larga
        $lines = file($txt_registry_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            list($code, $url) = explode(',', $line, 2);
                echo $code.' -'.$short_url;
                if ($code == $short_url) {
                    // Redirigir a la URL larga si el código corto coincide
                        header("Location: $url");
                        exit;
                    }
                }
    }
  
?>

