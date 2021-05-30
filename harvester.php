<?PHP
$file = '~/.chia/mainnet/log/debug.log';
$handle = fopen($file, "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        // process the line read.
      echo "$line /n ";
    }

    fclose($handle);
} else {
    // error opening the file.
} 
?>
