<?PHP
function log_search($search,$stars){ 
    $file = '/home/dad/.chia/mainnet/log/debug.log';
    $handle = fopen($file, "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $pos = strpos($line, $search);
            if ($pos !== false) {
                     echo "$stars $line ";
            } 
        }
        fclose($handle);
    } else {
        // error opening the file.
    } 

}
log_search('1 plots were eligible','*');
log_search('2 plots were eligible','**');
log_search('3 plots were eligible','***');
log_search('4 plots were eligible','***');
log_search('Found 1 proofs.','!!!!');
