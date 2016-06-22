<?php
    include_once "wechat_conf.php";
    define('_SAVE_PATH','./static/upload/');
    include_once "common.php";
    include_once "sql_conf.php";

    $ret = array('data' => '','msg' => '','status' => '-1');

    // var_dump($ret); 
    if(isset($_GET["serverId"])){
        $mediaId = $_GET["serverId"];
        // 获取素材
        $temporary = $app->material_temporary;
        $media = $temporary->getStream($mediaId);

        // var_dump($media);exit();
        $dateDir = date("Ymd");
        $fname = md5(time());
        $selfile = _SAVE_PATH.$dateDir."/{$fname}";//设置保存图片的位置和文件名
        $tmpdir = _SAVE_PATH.$dateDir;

        if(!file_exists($tmpdir)) { mkdir($tmpdir,0777); }
        
        if(!file_exists($selfile)){
            if(file_put_contents($selfile, $media)){
                nt_write_log(__FILE__, __LINE__, 'print variants [ok]', "DEBUG");
                $ret['status'] = 0;
                $ret['msg'] = "upload success!";
                // 音频转码
                // $command = "./ffmpeg/ffmpeg -i {$fname} {$fname}".".mp3";
                // exec($command,$output);
                // unlink($fname);
            }else{
                nt_write_log(__FILE__, __LINE__, 'media get error', "ERROR");
                $ret['msg'] = "media get error!";
            }
        }      
        
    }else{
        nt_write_log(__FILE__, __LINE__, 'lost variants $_GET[serverId]', "ERROR");
        $ret['msg'] = "upload fail!";
    }

    echo json_encode($ret);


    // try {
    //     $pdo = new PDO('mysql:host=rm-2ze14s8b8603j1hx6.mysql.rds.aliyuncs.com;dbname=yyxh', USER, PASSWORD);
    //     $pdo->query("set names utf8");
    //     $q = 'insert into activity(a_name,a_organization_name,a_person_in_charge,p_id,c_id,a_time,a_activity_describe,a_remarks,a_openid) values(?,?,?,?,?,?,?,?,?)';
    //     $stmt = $pdo->prepare($q);
    //     if($stmt->execute(array($a_name,$a_organization_name,$a_person_in_charge,$p_id,$c_id,$a_time,$a_activity_describe,$a_remarks,$a_openid))){
    //         $id =  $pdo->lastInsertId();
    //         nt_write_log(__FILE__, __LINE__, "log variants [".$id."]", "DEBUG");
    //         $ret["status"] = 0;
    //         $ret["msg"] = "活动提交成功";
	   //      $ret = json_encode($ret);
    //         echo $ret;
    //     }else{
    //         nt_write_log(__FILE__, __LINE__, "sql wrong", "ERROR");
    //         die();
    //     }
    //     unset($pdo);
                 
    // } catch (PDOException $e) {
    //     nt_write_log(__FILE__, __LINE__, "log variants [".$e->getMessage()."]", "ERROR");
    //     die();
    // }    

?>
