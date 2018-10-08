<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists('filterOnly')) {
    function filterOnly($key, $data)
    {

        $filtered = array_filter(
            $data,
            function ($key_) use ($key) {
                return in_array($key_, $key);
            },
            ARRAY_FILTER_USE_KEY
        );
        return $filtered;
    }
    function echoTextIfIsset($data=null,$tag=null){
        if($tag!=null) {
                echo '<'.$tag.'>' .$data .'</'.$tag.'>';
        }
        else{
            if(isset($data))
            {
                echo $data;
            }
        }
    }
    function fullDateTimeNow(){
        return date("Y-m-d H:i:s");
    }
    function createThumbs($photo){

        $CI =& get_instance();
        $CI->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploads/photo_passport/' . $photo;
        $config['new_image'] = 'uploads/thumbs/' . $photo;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 110;
        $config['height'] = 110;

        $CI->image_lib->clear();
        $CI->image_lib->initialize($config);
        if (!$CI->image_lib->resize()) {
            return(array(false, $CI->image_lib->display_errors()));
        }
        else
        {
            return array(true,lang('create_image_successly'));
        }
    }
}
