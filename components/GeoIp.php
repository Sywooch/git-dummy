<?php

    namespace app\components;

    use Yii;

class GeoIp
{


    // IP-адрес, который нужно проверить
/*$ip = "94.31.134.61";

// Преобразуем IP в число
    $int = sprintf("%u", ip2long($ip));

// Ищем страну
    $country_name = "";
    $country_id = 0;
// Европа?
    $sql = "select * from (select * from net_euro where begin_ip<=$int order by begin_ip desc limit 1) as t where end_ip>=$int";
    $result = mysql_query($sql);
    if (mysql_num_rows($result) == 0) {
    $sql = "select * from (select * from net_country_ip where begin_ip<=$int order by begin_ip desc limit 1) as t where end_ip>=$int";
    $result = mysql_query($sql);
    }
    if ($row = mysql_fetch_array($result)) {
        $country_id = $row['country_id'];
        $sql = "select * from net_country where id='$country_id'";
        $result = mysql_query($sql);
        if ($row = mysql_fetch_array($result)) {
            $country_name = $row['name_ru'];
        }
    }
    if ($country_id == 0) {
        echo "Страна не определена";
    } else {
        echo $country_id." ".$country_name;
    }*/

    public static function getIntIp($ip)
    {
        return  sprintf("%u", ip2long($ip));
    }
    public static function getCountryID($ip=''){
        if(!$ip)
                $ip=$_SERVER['REMOTE_ADDR'];

        $int = GeoIp::getIntIp($ip);

        $sql = "select * from (select * from net_euro where begin_ip<=$int order by begin_ip desc limit 1) as t where end_ip>=$int";
        $L=yii::$app->db->createCommand($sql)->queryOne();

        if (count($L) == 0) {
            $sql = "select * from (select * from net_country_ip where begin_ip<=$int order by begin_ip desc limit 1) as t where end_ip>=$int";
            $L=yii::$app->db->createCommand($sql)->queryOne();

        }

        if (count($L)) {
            $country_id = $L['country_id'];
            if($country_id){
                $sql=" SELECT `code` FROM `net_country` WHERE `id` = $country_id ";
                $L=yii::$app->db->createCommand($sql)->queryOne();

                if(count($L)){
                    return strtolower($L['code']);
                }
            }
                return false;
         }

        if ($country_id == 0) {
            return false;
        } else {
           return $country_id;
        }

    }

    public static function getCountry($ip=''){

        if(!$ip)
            $ip=$_SERVER['REMOTE_ADDR'];

        $int = GeoIp::getIntIp($ip);

        $sql = "select * from (select * from net_euro where begin_ip<=$int order by begin_ip desc limit 1) as t where end_ip>=$int";
        $L=yii::$app->db->createCommand($sql)->queryOne();

        if (count($L) == 0) {
            $sql = "select * from (select * from net_country_ip where begin_ip<=$int order by begin_ip desc limit 1) as t where end_ip>=$int";
            $L=yii::$app->db->createCommand($sql)->queryOne();

        }

        if (count($L)) {
            $country_id = $L['country_id'];
            if($country_id){
                $sql=" SELECT * FROM `net_country` WHERE `id` = $country_id ";
                $L=yii::$app->db->createCommand($sql)->queryOne();

                if(count($L)){
                    if(\Yii::$app->session->get('language')=='ru')
                        return $L['name_ru'];
                    return $L['name_en'];
                }
            }
            return '';
        }

    }
}