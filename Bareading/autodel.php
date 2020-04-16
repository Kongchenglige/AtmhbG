<?php
$files_r = scandir('files');
unset($files_r[0],$files_r[1],$files_r[2]);
$files = array_merge($files_r);
unset($files_r);
foreach ($files as $file) {
    if(time() - filemtime($file) > 604800){
        unlink($file);
    }
}