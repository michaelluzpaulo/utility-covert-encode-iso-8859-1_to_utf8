<?php

$directorios = ['../bazonni'];
$extensiones = ['.php', '.js', '.css', '.html', '.htm', '.txt'];

function cambiar_codificacion_directorio($dir, $extensiones)
{
    if (is_dir($dir)) {
        $folder = opendir($dir);
        while ($file = readdir($folder)) {
            if ($file == '.' | $file == '..') {
                continue;
            }
            $ruta = $dir . "/" . $file;
            if (is_dir($ruta)) {
                cambiar_codificacion_directorio($ruta, $extensiones);
            } else {
                if (in_array(strrchr($file, '.'), $extensiones)) {
                    $archivo_utf8 = $ruta . '.utf8';
                    echo "\n" . $archivo_utf8;
                    exec("iconv -f ISO-8859-1 -t UTF-8 $ruta > $archivo_utf8");
                    unlink($ruta);
                    rename($archivo_utf8, $ruta);

                }
            }
        }
    }
}

foreach ($directorios as $directorio) {
    cambiar_codificacion_directorio($directorio, $extensiones);
}