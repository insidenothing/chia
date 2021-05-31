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
              echo "$netspace \r\n";
            } 
    }
    

    $buffer = ob_get_clean();
    echo $buffer;
    return $buffer;
}

netspace();
