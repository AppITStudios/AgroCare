<?php
	session_start();
	
	@require_once 'db_con.php';

	function add_new_user($email, $name, $lastname, $password, $signup_fb, $image_path, $country, $city){
		global $db_con;
        
        $success = false;
		
		$active = '1';
		$enabled = '1';
		$stmt = $db_con->prepare("INSERT INTO usuarios(email, name, lastname, active, enabled, signup_fb, userpic_path, country, city) 
									VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('sssssssss', $email, $name, $lastname, $active, $enabled, $signup_fb, $image_path, $country, $city);

		if($stmt->execute()){
			$stmt = $db_con->prepare("INSERT INTO credenciales(email, password) VALUES(?,?)");
			$stmt->bind_param('ss', $email, md5($password));

			if($stmt->execute()){
				$success = true;
			}
		}
        
        return $success;
	}

	function check_user_exists($email){
		global $db_con;
		$stmt = $db_con->prepare('SELECT email FROM credenciales WHERE email=?');
		$stmt->bind_param('s', $email);
		$stmt->execute();
		
		$stmt->bind_result($col1);
		if ($stmt->fetch()){
			return true;
		}
		return false;
	}
    
    function get_user_names($email){
        global $db_con;
        $name = '';
        
		$stmt = $db_con->prepare('SELECT name, lastname FROM usuarios WHERE email=?');
		$stmt->bind_param('s', $email);
		$stmt->execute();
		
		$stmt->bind_result($col1, $col2);
		if ($stmt->fetch()){
			$name = $col1 . ' ' . $col2;
		}
		return $name;
    }
    
    function get_profile_pic_file($email){
        global $db_con;
        $pic = '';
        
		$stmt = $db_con->prepare('SELECT userpic_path FROM usuarios WHERE email=?');
		$stmt->bind_param('s', $email);
		$stmt->execute();
		
		$stmt->bind_result($col1);
		if ($stmt->fetch()){
			$pic = $col1;
		}
		return $pic;
    }
    
    //Guardar nueva crop//
    function add_new_crop($name,$size,$user){
        global $db_con;
        $success = false;
          
        $stmt = $db_con->prepare("INSERT INTO crop(name,size,season,user) VALUES(?, ?, ?, ?)");
        $stmt->bind_param('ssss', $name, $size, date('Y-m-d'), $user);

        if($stmt->execute()){
            $success = true;
        }
              
        return $success;
    }

    function add_new_alert($id,$lat,$lon,$type,$desc,$file){
        global $db_con;
        $success = false;
        
        $status="1";
        $stmt = $db_con->prepare("INSERT INTO crop_alert(id_crop,lat,lon,type,status,description,img) VALUES(?, ?, ?, ?,?,?,?)");
        $stmt->bind_param('sssssss', $id,$lat,$lon,$type,$status,$desc,$file);

        if($stmt->execute()){
            $success = true;
        }
              
        return $success;
    }
    
    function get_farmer_crops($user){
        global $db_con;
        $success = false;
        $data = array();
          
        $stmt = $db_con->prepare("SELECT name, size FROM crop WHERE user = ?");
        $stmt->bind_param('s', $user);
        
        $stmt->execute();
		$stmt->bind_result($name, $size);

        while ($stmt->fetch()){
            $one_data = array();
            $one_data['crop'] = $name;
            $one_data['size'] = $size;
            
            array_push($data, $one_data);
		}
		return $data;
    }
    
    function get_farmer_crops2($user){
        global $db_con;
        $success = false;
        $data = array();
          
        $stmt = $db_con->prepare("SELECT id, name, size FROM crop WHERE user = ?");
        $stmt->bind_param('s', $user);
        
        $stmt->execute();
		$stmt->bind_result($id, $name, $size);

        while ($stmt->fetch()){
            $one_data = array();
            $one_data['id'] = $id;
            $one_data['crop'] = $name;
            $one_data['size'] = $size;
            
            array_push($data, $one_data);
		}
		return $data;
    }
    
    function get_diseases($status, $min_x, $max_x, $min_y, $max_y, $exclude){
        global $db_con;
        $data = array();
        
        
        $lats = implode(",", $exclude['lat']);
        $lngs = implode(",", $exclude['lng']);
        
        $sql = "SELECT crop_alert.id , crop.name, crop_alert.lat , crop_alert.lon, crop_alert.description , crop_alert.img, crop_alert.type FROM crop_alert INNER JOIN crop  WHERE crop_alert.status=? AND crop_alert.lat >= ? AND crop_alert.lat <= ? AND crop_alert.lon >= ? AND crop_alert.lon <= ?";
        if (count($exclude['lat']) != 0){
            $sql .= " AND crop_alert.lat NOT IN($lats) AND crop_alert.lon NOT IN($lngs) ";
        }
        $sql .=" AND crop.id = crop_alert.id_crop";
        
        //id de alert, nombre del cultivo, lat, lon, desc, img
        $stmt = $db_con->prepare($sql);
        $stmt->bind_param('sdddd', $status, $min_y, $max_y, $min_x, $max_x);
        
        $stmt->execute();
        $stmt->bind_result($id, $name, $lat,$lon,$desc,$img,$type);

        while ($stmt->fetch()){
            $one_data = array();
            $tipo="";
            if($type=="0"){ $tipo="Insects" ;}
            if($type=="1"){$tipo = "Virus";}else{$tipo="Plants";}
            $one_data['lat'] = $lat;
            $one_data['lng'] = $lon;
            $one_data['desc'] = "<div class='text-center'><strong>Crop: ".$name." </br>".$desc . "</strong></br> <img src='/alert_pics/" . $img . "' width=75px' height=75px' /></br><strong>Pest type: </strong>' " . $tipo."</div>";
            
            array_push($data, $one_data);
        }
        return $data;

    }
    
    function get_world_diseases($status){
        global $db_con;

        $data = "";
          
        $stmt = $db_con->prepare("SELECT COUNT(*) as total FROM crop_alert WHERE status=?");
        $stmt->bind_param('s', $status);
        
        $stmt->execute();
        $stmt->bind_result($total);

        $data = $stmt->fetch();

        return $data;
    }

    // ESTA ERA PRUEBA MIA......
    function get_new_markers($min_x, $max_x, $min_y, $max_y, $exclude){
        global $db_con;
        
        $data = array();
        $i = 0;
        
        $lats = implode(",", $exclude['lat']);
        $lngs = implode(",", $exclude['lng']);
        
        $sql = "SELECT * FROM test_markers WHERE (lat >= ? AND lat <= ?) AND (lng >= ? AND lng <= ?)";
        
        // Lo puse asi porque el NOT IN () no puede estar vacio, sino da error sql
        if (count($exclude['lat']) != 0){
            $sql .= " AND lat NOT IN($lats) AND lng NOT IN($lngs)";
        }
        
        $stmt = $db_con->prepare($sql);
        
		$stmt->bind_param('dddd', $min_y, $max_y, $min_x, $max_x);
        
		$stmt->execute();
		$stmt->bind_result($lat, $lng, $desc);
        
        while ($stmt->fetch()){
			$data[$i] = array();
            $data[$i]['lat'] = $lat;
            $data[$i]['lng'] = $lng;
            $data[$i]['desc'] = $desc;
			$i++;
		}
		return $data;
    }
    
    function get_new_markers2($min_x, $max_x, $min_y, $_max_y, $exclude){
        global $db_con;
        
        $stmt = $db_con->prepare("SELECT * FROM test_markers WHERE lat=?");
        echo "valor de stmt: " . $stmt;
    }

    function get_farmer_diseases($user){
        global $db_con;
        $success = false;
        $data = array();
          
        $stmt = $db_con->prepare("SELECT type, Count(*) AS quantity FROM (SELECT type FROM crop_alert INNER JOIN crop ON crop_alert.id_crop=crop.id WHERE crop.user=? AND crop_alert.status='1') AS numbers Group By type");
        $stmt->bind_param('s', $user);
        
        $stmt->execute();
        $stmt->bind_result($type, $quantity);

        while ($stmt->fetch()){
            $one_data = array();
            switch ($type) {
                case '0':
                    $one_data['diseases'] = "Insects";
                    break;
                case '1':
                    $one_data['diseases'] = "Virus";
                    break;
                case '2':
                   $one_data['diseases'] = "Other Plants";
                    break;
            }
            $one_data['size'] = $quantity;
            
            array_push($data, $one_data);
        }
        return $data;
    }

    function get_farmer_diseases_count($user, $status){
        global $db_con;
        $success = false;
        $data = "";
          
        $stmt = $db_con->prepare("SELECT COUNT(*) AS quantity from crop_alert INNER JOIN crop ON crop_alert.id_crop=crop.id WHERE crop.user=? AND crop_alert.status=?");
        $stmt->bind_param('ss', $user, $status);
        
        $stmt->execute();
        $stmt->bind_result($quantity);

        $number=$stmt->fetch();

        $quantity=str_pad($quantity, 9, "0" ,STR_PAD_LEFT);
        for ($i = 0; $i < strlen($quantity); $i++) {
            $data.="<span>".$quantity[$i]."</span> ";
        };

        return $data;
    }



?>