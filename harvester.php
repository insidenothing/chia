<?PHP
$file = '/home/dad/.chia/mainnet/log/debug.log';
$handle = fopen($file, "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $pos = strpos($line, '3 plots were eligible');
        if ($pos !== false) {
                 echo "*** $line ";
        } 
        $pos = strpos($line, '2 plots were eligible');
        if ($pos !== false) {
                 echo "** $line ";
        } 
        $pos = strpos($line, '1 plots were eligible');
        if ($pos !== false) {
                 echo "* $line ";
        } 
    }
    fclose($handle);
} else {
    // error opening the file.
} 
?>
