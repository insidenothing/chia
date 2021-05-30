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
function log_count($search,$stars){ 
    $file = '/home/dad/.chia/mainnet/log/debug.log';
    $handle = fopen($file, "r");
    $i=0;
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $pos = strpos($line, $search);
            $pos2 = strpos($line, date('Y-m-d'));
            if ($pos !== false && $pos2 !== false) {
                     //echo "$stars $line ";
                $i++;
            } 
        }
        fclose($handle);
    } else {
        // error opening the file.
    } 
    echo "$stars $search $i times today ".'\n';
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
                     $count = trim($parts[1]);
                     $last = "$title: $count";
            } 
        }
        fclose($handle);
    } else {
        // error opening the file.
    } 
    echo "$last ".'\n';
}
log_count('1 plots were eligible','*');
log_count('2 plots were eligible','**');
log_count('3 plots were eligible','***');
log_count('4 plots were eligible','****');
log_search('Found 1 proofs.','!!!!!!!!');
log_last('Total','Last Plot Count');
