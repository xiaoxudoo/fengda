<?php
    date_default_timezone_set('PRC');
    function nt_write_log($sg_code_file_name, $sg_line, $sg_content, $sg_level)
    {
        if($sg_code_file_name == NULL || $sg_line == NULL 
            || $sg_content == NULL || $sg_level == NULL)
        {
            return -1;
        }
        
        $sg_fp = fopen("debug.log", "a");
        if($sg_fp === FALSE)
        {
            return -2;
        }

        $sg_date = date("Y-m-d H:i:s", time());
     
        $sg_ret = flock($sg_fp, LOCK_EX);
        if($sg_ret === TRUE)
        {
            fwrite($sg_fp, "[".$sg_date."][".$sg_code_file_name
                .":".$sg_line."][".$sg_level."]".$sg_content."\n");
            flock($sg_fp, LOCK_UN);
        }
        else
        {
            fclose($sg_fp);
            return -3;
        }
        
        fclose($sg_fp);
        return 0;
    }
    function nt_set_authen_info_to_file($sg_fp, $sg_array){
        if($sg_fp == FALSE || $sg_array == NULL)
        {
            nt_write_log(__FILE__, __LINE__, "Illegal variants, sg_fp["
                .$sg_fp."], sg_array[".$sg_array
                ."]", "ERROR");
            return -1;
        }
        
        $sg_ret = flock($sg_fp, LOCK_EX);
        if($sg_ret === FALSE)
        {
            nt_write_log(__FILE__, __LINE__, "flock failed", "ERROR");
            return -2;
        }        
        
        //读到最后的\n也无所谓!!!!

        fwrite($sg_fp, $sg_array["openid"]."\t"
            .$sg_array["nickname"]."\t".$sg_array["sex"]
            ."\t".$sg_array["province"]."\t".$sg_array["city"]
            ."\t".$sg_array["country"]."\t\n");       
        flock($sg_fp, LOCK_UN);
        
        return 0;    
    }
    function nt_get_user_info($user_info_array){
        $sg_file = dirname(__FILE__)."/userinfo.log";
        //判断文件是否存在
        if(file_exists($sg_file) === FALSE)
        {
            nt_write_log(__FILE__, __LINE__, "sg_file["
                .$sg_file."] does not exist", "ERROR");
            return NULL;
        }
        
            
        //写入记录到文件
        //打开文件
        $sg_fp = fopen($sg_file, "a+");
        if($sg_fp === FALSE)
        {
            nt_write_log(__FILE__, __LINE__, "sg_file["
                .$sg_file."] cannot be opened", "ERROR");
            return NULL;
        }

        $sg_ret = nt_set_authen_info_to_file($sg_fp, $user_info_array);

        if($sg_ret < 0)
        {
            nt_write_log(__FILE__, __LINE__, "nt_set_authen_info_to_file return["
                .$sg_ret."]", "ERROR");
            fclose($sg_fp);    
            return NULL;
        }
        
        fclose($sg_fp);
        return TRUE;
    }
?>
