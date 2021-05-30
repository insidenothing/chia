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
function disk_stats($search){ 
    $i=0;
  ob_start();
    //echo '<pre>';

// Outputs all the result of shellcommand "ls", and returns
// the last output line into $last_line. Stores the return value
// of the shell command in $retval.
$last_line = system('df -h', $retval);

// Printing additional info
//echo '
//</pre>
//<hr />Last line of the output: ' . $last_line . '
//<hr />Return value: ' . $retval; 
    $buffer = ob_get_clean();
$break='
';
    $a = explode($break,$buffer);
    foreach($a as $k => $v){
            $pos2 = strpos($v, 'Avail');
            if ($pos2 !== false) {
                $t = "$v  \r\n";

            } 
    }
    foreach($a as $k => $v){
            $pos = strpos($v, $search);
            $pos2 = strpos($v, 'T');
            if ($pos !== false && $pos2 !== false) {
                echo "$t $v  \r\n";
                $i++;
            } 
    }
    
    if ($i==0){ // no TB NVME found, look for MB
        foreach($a as $k => $v){
                $pos = strpos($v, $search);
                $pos2 = strpos($v, 'G');
                if ($pos !== false && $pos2 !== false) {
                    echo "$t $v  \r\n";
                    $i++;
                } 
        }
        echo "NVME TEMP MB: $i \r\n";
    }else{
     echo "NVME TEMP TB: $i \r\n";   
    }
    $i=0;
    foreach($a as $k => $v){
        $pos = strpos($v, 'Seagate');
        $pos2 = strpos($v, 'Expansion');
        if ($pos !== false) {
            echo "$t $v  \r\n";
            $i++;
        } 
        if ($pos2 !== false) {
            echo "$t $v  \r\n";
            $i++;
        } 
    }
    echo "Final Drives: $i \r\n";
}
function ps_count($search){ 
    $i=0;
  ob_start();
    //echo '<pre>';

// Outputs all the result of shellcommand "ls", and returns
// the last output line into $last_line. Stores the return value
// of the shell command in $retval.
$last_line = system('ps -h', $retval);

// Printing additional info
//echo '
//</pre>
//<hr />Last line of the output: ' . $last_line . '
//<hr />Return value: ' . $retval; 
    $buffer = ob_get_clean();
$break='
';
    $a = explode($break,$buffer);
    foreach($a as $k => $v){
            $pos = strpos($v, $search);
            if ($pos !== false) {
             //   echo "$k $v  \r\n";
                $i++;
            } 
    }
    echo "Active Plotting: $i \r\n";
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
    echo "$stars $search $i times today \r\n";
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
    echo "$last \r\n \r\n \r\n";
}

while(true)
{
    echo "\r\n \r\n \r\n";
    echo "Harvester Stats ".date('r')." ".gethostname()." \r\n";
    log_count('1 plots were eligible','*');
    log_count('2 plots were eligible','**');
    log_count('3 plots were eligible','***');
    log_count('4 plots were eligible','****');
    log_search('Found 1 proofs.','!!!!!!!!');
    ps_count('chia plots create');
    disk_stats('nvme');
    log_last('Total','Last Plot Count');
    sleep(60); // sleep for 240 sec
}
