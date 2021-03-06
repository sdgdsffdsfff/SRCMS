<?php

/**
 * @author Zhou Yuyang <1009465756@qq.com> 2015-07-27
 * @copyright ©2105-2018 SRCMS
 * @homepage http://www.src.pw
 * @version 1.0
 */

namespace Home\Controller;

use Think\Controller;

class BlogController extends Controller{

    public function index($key="")
    {
        if($key == ""){
            $model = M('blog');  
        }else{
            $where['title'] = array('like',"%$key%");
            $where['name'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = M('blog')->where($where); 
        } 
        
        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Extend\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        $pages = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id DESC')->select();
        $this->assign('model', $pages);
        $this->assign('page',$show);
        $this->display();     
    }


    public function view(){
		$id = I('get.id',0,'intval');    //对传入数字参数做整数校验，规避SQLinjection漏洞
        $model = M('blog')->where('id='.$id)->find();
        $this->assign('model',$model);
        $this->display();
    }
}
