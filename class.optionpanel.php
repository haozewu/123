<?php
class OptionPanel{
    function save_ciabeta_options(){
        if( $_POST['submit'] ){
            /**
             * 所有配置菜单项合集
             * 代码高亮功能是否实现
             * 自动编目录是否实现
             * 返回顶部是否实现
             * 版权管理是否实现
             * 原创声明
             * 非原创声明
             * 分享到空间功能是否实现
             */
            $save_data=array(
                'prism_on' => $_POST['prism_on'],
                'num_on' => $_POST['num_on'],
                'backtop_on' => $_POST['backtop_on'],
                'copyright_on' => $_POST['copyright_on'],
                'orign' => $_POST['orign'],
                'not_orign' => $_POST['not_orign'],
                'sharequzone_on' => $_POST['sharequzone_on'],
                'protectlogin_on' => $_POST['protectlogin_on'],
                'loginprotect_name' => $_POST['loginprotect_name'],
                'loginprotect_value' => $_POST['loginprotect_value'],
            );
            /**
             * 调试查看是否得到参数
             */
            //  include('class.debug.php');
            //  $mydebug = new MyDebug;
            //  $mydebug->console_log($save_data);
            update_option( 'ciabeta-options', $save_data );
        }
        return get_option( 'ciabeta-options' );
    }
}



?>