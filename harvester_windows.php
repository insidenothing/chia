<?PHP
function uplink($netspace,$os,$datetime,$hostname,$total_plots,$proofs,$x1,$x2,$x3,$x4,$active_ploting,$disk_temp_free,$disk_final_free){
    $db = mysqli_connect('watchdog-cluster-1.cluster-cmhaak521ogd.us-east-1.rds.amazonaws.com','service_user','service_pass','core') or die(mysqli_error($db));
    $url = 'https://www.bmorecoin.com/harvester_uplink.php';
    $ch = curl_init($url);
    $datetime = $db->real_escape_string($datetime);
    $jsonData = array(
        'os' => "Windows",
        'netspace' => "$netspace",
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
function log_search($search,$stars,$file_name){ 
    ob_start();
    $i=0;
    $file = 'C:\Users\Patrick\.chia\mainnet\log\\'.$file_name;
    $handle = fopen($file, "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $pos = strpos($line, $search);
            $pos2 = strpos($line, date('Y-m-d'));
            if ($pos !== false && $pos2 !== false) {
                    // echo "$stars $line ";
                $i++;
            } 
        }
        fclose($handle);
    } else {
        // error opening the file.
    } 
    echo $i;
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
$last_line = system('wmic /node:"%COMPUTERNAME%" LogicalDisk Where DriveType="3" Get DeviceID,FreeSpace|find /I "c:"', $retval);

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
              $pos2 = strpos($v, 'C');
            if ($pos2 !== false) {
                echo "$v  \r\n";
                $i++;
            } 
    }
    
    echo "Temp Drives: $i \r\n";
        $buffer = ob_get_clean();
    echo $buffer;
    return $buffer;
}
function final_disk_stats($search){ 
    ob_start();
    $i=0;
    ob_start();
    $last_line = system('wmic /node:"%COMPUTERNAME%" LogicalDisk Where DriveType="3" Get DeviceID,FreeSpace|find /I "d:"', $retval); 
    $buffer = ob_get_clean();
$break='
';
    $a = explode($break,$buffer);
    foreach($a as $k => $v){
            $pos2 = strpos($v, 'D');
            if ($pos2 !== false) {
                $t = "$v  \r\n";
                echo $t;
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
$last_line = system('wmic process list', $retval);

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
               // echo "$k $v  \r\n";
                $i++;
            } 
    }
    echo "$i";
        $buffer = ob_get_clean();
    echo $buffer;
    return $buffer;
}
function log_count($search,$stars,$file_name){ 
    ob_start();
    $file = 'C:\Users\Patrick\.chia\mainnet\log\\'.$file_name;
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
function log_last($search,$title,$file_name){ 
    ob_start();
    $file = 'C:\Users\Patrick\.chia\mainnet\log\\'.$file_name;
    $handle = fopen($file, "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $pos = strpos($line, $search);
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

function netspace(){ 
    ob_start();
    $i=0;
    ob_start();
    $last_line = system('C:\Users\Patrick\AppData\Local\chia-blockchain\app-1.1.6\resources\app.asar.unpacked\daemon\chia.exe show -s', $retval);
    $buffer = ob_get_clean();
$break='
';
    $a = explode($break,$buffer);
    foreach($a as $k => $v){
              $pos2 = strpos($v, 'EiB');
          if ($pos2 !== false) {
              $parts = explode(':',$v);  
              $size = trim($parts[1]);
              $justEiB = str_replace('EiB','',$size);
              $netspace = trim($justEiB);
              $tb = $netspace * 1.153e+6;
              echo "$tb \r\n";
            } 
    }
    

    $buffer = ob_get_clean();
    echo $buffer;
    return $buffer;
}


while(true)
{
    $datetime =  date('Y-m-d');
    $hostname=gethostname();
    echo "\r\n \r\n \r\n";
    echo "Harvester Stats ".$datetime." ".$hostname." \r\n";
    $x1 = log_count('1 plots were eligible','*','debug.log');
    $x2 = log_count('2 plots were eligible','**','debug.log');
    $x3 = log_count('3 plots were eligible','***','debug.log');
    $x4 = log_count('4 plots were eligible','****','debug.log');
    $proofs = log_search('Found 1 proofs.','!!!!!!!!','debug.log');
    foreach (range(1,7) as $number){
        $x1 = $x1 + log_count('1 plots were eligible','*','debug.log.'.$number);
        $x2 = $x2 + log_count('2 plots were eligible','**','debug.log.'.$number);
        $x3 = $x3 + log_count('3 plots were eligible','***','debug.log.'.$number);
        $x4 = $x4 + log_count('4 plots were eligible','****','debug.log.'.$number);
        $proofs = $proofs + log_search('Found 1 proofs.','!!!!!!!!','debug.log.'.$number);
    }
    $active_ploting = ps_count('chia.exe  plots create');
    $disk_temp_free = disk_stats('nvme');
    $disk_final_free = final_disk_stats('nvme');
    $total_plots = log_last('Total','Last Plot Count','debug.log');
    $netspace = netspace();
    uplink($netspace,'Windows',$datetime,$hostname,$total_plots,$proofs,$x1,$x2,$x3,$x4,$active_ploting,$disk_temp_free,$disk_final_free);
    sleep(120); // sleep for 240 sec
}
