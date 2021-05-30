<?PHP
function log_search($search,$stars){ 
    $file = '/home/dad/.chia/mainnet/log/debug.log';
    $handle = fopen($file, "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $pos = strpos($line, $search);
            $pos2 = strpos($line, date('Y-m-d'));
            if ($pos !== false && $pos2 !== false) {
                     echo "$stars $line ";
            } 
        }
        fclose($handle);
    } else {
        // error opening the file.
    } 
}
function log_last($search,$title){ 
    $file = '/home/dad/.chia/mainnet/log/debug.log';
    $handle = fopen($file, "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $pos = strpos($line, $search);
            $pos2 = strpos($line, date('Y-m-d'));
            if ($pos !== false && $pos2 !== false) {
                     $parts = explode($search,$line);
                     $last = "$title: $parts[1] ";
            } 
        }
        fclose($handle);
    } else {
        // error opening the file.
    } 
    echo $last;
}
log_search('1 plots were eligible','*');
log_search('2 plots were eligible','**');
log_search('3 plots were eligible','***');
log_search('4 plots were eligible','***');
log_search('Found 1 proofs.','!!!!');
log_last('Total','CURRENT STATUS');
