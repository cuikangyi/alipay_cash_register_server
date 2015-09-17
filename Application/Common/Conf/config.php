<?php
/**
 * 系统配文件
 * 所有系统级别的配置
 */
return array(
    /* 模块相关配置 */
    'DEFAULT_MODULE'     => 'Home',
    'MODULE_DENY_LIST'   => array('Common'),
    'MODULE_ALLOW_LIST'  => array('Home','Admin','Agent','YunfuApi','YunfuPos'),

    /* 用户相关设置 */
    'USER_MAX_CACHE'     => 1000, //最大缓存用户数
    'USER_ADMINISTRATOR' => 1, //管理员用户ID

    /* URL配置 */
    'URL_CASE_INSENSITIVE' => true, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            => 2, //URL模式
    'VAR_URL_PARAMS'       => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/', //PATHINFO URL分割符

    /* 全局过滤配置 */
    'DEFAULT_FILTER' => 'htmlspecialchars,trim,strip_tags', //全局过滤函数

    /* 数据库配置 */
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'yunfu', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '123456',  // 密码
    'DB_PORT'   => '3306', // 端口
    'DB_PREFIX' => 'yunfu_', // 数据库表前缀

    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__IMG__'    => __ROOT__ . '/Public/static/images',
        '__CSS__'    => __ROOT__ . '/Public/static/css',
        '__JS__'     => __ROOT__ . '/Public/static/js',
    ),

    'SITEURL' => 'http://yunfu',
);
