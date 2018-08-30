<?php
use think\Db;
//根据用户主键id，查询用户名称
if (!function_exists('getUserName')){
    function getUserName($id){
        return Db::table('gblc_user')->where('id',$id)->value('name');
    }
}
//过滤一下摘要
function getArtContent($content){
        return mb_substr(strip_tags($content),0,20).'...';
}

if (!function_exists('getCateName')){
    function getCateName($id){
        return Db::table('gblc_article_cg')->where('id',$id)->value('name');
    }
}