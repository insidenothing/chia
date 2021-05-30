<?PHP
$file = '/home/dad/.chia/mainnet/log/debug.log';
$handle = fopen($file, "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $pos = strpos($line, 'Total');
        if ($pos !== false) {
                 echo "$line ";
        } 
    }
    fclose($handle);
} else {
    // error opening the file.
} 
?>
