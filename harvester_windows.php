<?PHP
function uplink($os,$datetime,$hostname,$total_plots,$proofs,$x1,$x2,$x3,$x4,$active_ploting,$disk_temp_free,$disk_final_free){
    $db = mysqli_connect('watchdog-cluster-1.cluster-cmhaak521ogd.us-east-1.rds.amazonaws.com','service_user','service_pass','core') or die(mysqli_error($db));
    $url = 'https://www.bmorecoin.com/harvester_uplink.php';
    $ch = curl_init($url);
    $datetime = $db->real_escape_string($datetime);
    $jsonData = array(
        'os' => "Windows",
        'datetime' => "$datetime",
        'hostname' => "$hostname",
        'total_plots' => "$total_plots",
        'proofs' => "$proofs",
        'x1' => "$x1",
        'x2' => "$x2",
        'x3' => "$x3",
        'x4' => "$x4",
        'active_ploting' => "$active_ploting",
        'disk_temp_free' => "$disk_temp_free",
        'disk_final_free' => "$disk_final_free"
    );
    $jsonDataEncoded = json_encode($jsonData);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
    $result = curl_exec($ch);   
}
function log_search($search,$stars){ 
    ob_start();
    $file = 'C:\Users\Patrick\.chia\mainnet\log\debug.log';
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
        $buffer = ob_get_clean();
    echo $buffer;
    return $buffer;
}
function disk_stats($search){ 
    ob_start();
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
        $buffer = ob_get_clean();
    echo $buffer;
    return $buffer;
}
function final_disk_stats($search){ 
    ob_start();
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
        $buffer = ob_get_clean();
    echo $buffer;
    return $buffer;
}
function ps_count($search){ 
    ob_start();
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
    echo "$i";
        $buffer = ob_get_clean();
    echo $buffer;
    return $buffer;
}
function log_count($search,$stars){ 
    ob_start();
    $file = 'C:\Users\Patrick\.chia\mainnet\log\debug.log';
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
    echo "$i";
    $buffer = ob_get_clean();
    echo $buffer;
    return $buffer;
}
function log_last($search,$title){ 
    ob_start();
    $file = 'C:\Users\Patrick\.chia\mainnet\log\debug.log';
    $handle = fopen($file, "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $pos = strpos($line, $search);
            //$pos2 = strpos($line, date('Y-m-d'));
            if ($pos !== false) {
                     $parts = explode($search,$line);
                     $count = $parts[1];
                     //$last = "$title: $count";
                     $last = $count;
            } 
        }
        fclose($handle);
    } else {
        // error opening the file.
    } 
    echo str_replace('plots','',trim($last));
    //echo "$last \r\n \r\n \r\n";
    $buffer = ob_get_clean();
    echo $buffer;
    return $buffer;
}

while(true)
{
    $datetime = date('r');
    $hostname=gethostname();
    echo "\r\n \r\n \r\n";
    echo "Harvester Stats ".$datetime." ".$hostname." \r\n";
   // $x1 = log_count('1 plots were eligible','*');
  //  $x2 = log_count('2 plots were eligible','**');
  //  $x3 = log_count('3 plots were eligible','***');
  //  $x4 = log_count('4 plots were eligible','****');
   // $proofs = log_search('Found 1 proofs.','!!!!!!!!');
  //  $active_ploting = ps_count('chia plots create');
 //   $disk_temp_free = disk_stats('nvme');
  //  $disk_final_free = final_disk_stats('nvme');
    $total_plots = log_last('Total','Last Plot Count');
    uplink('Windows',$datetime,$hostname,$total_plots,$proofs,$x1,$x2,$x3,$x4,$active_ploting,$disk_temp_free,$disk_final_free);
    sleep(120); // sleep for 240 sec
}
