<?php


namespace app\generator\core;


use JoinPhpCommon\utils\Text;
use think\Db;
use think\Exception;
use think\facade\Env;
use think\Response;
use think\response\View;

/**
 * 代码生成工具
 * Class Generator
 * @package app\generator\controller
 */
class VueGenerator extends Generator
{
    /**
     * vue 列表文件
     * @param $data
     * @param string $template_name
     */
    public function buildVueList($data, string $template_name ='default'){
        // 模板
        $template_path = '../template/'.$template_name.'/VueList';
        $view = new View($template_path);
        $view->assign('data',$data);
        $content = $view->getContent();
        // 写文件
        $file_path = $this->buildFilePath($data,
            'vue/'.$data['table_name'],
            'list',
            ".vue");
        $content = $this->toPhpFile($content);
        file_put_contents($file_path,$content);
        return true;
    }

    /**
     * vue 详情文件
     * @param $data
     * @param string $template_name
     */
    public function buildVueDetail($data, string $template_name ='default'){
        // 模板
        $template_path = '../template/'.$template_name.'/VueDetail';
        $view = new View($template_path);
        $view->assign('data',$data);
        $content = $view->getContent();
        // 写文件
        $file_path = $this->buildFilePath($data,
            'vue/'.$data['table_name'],
            'detail',
            ".vue");
        $content = $this->toPhpFile($content);
        file_put_contents($file_path,$content);
        return true;
    }

    /**
     * vue 编辑页文件
     * @param $data
     * @param string $template_name
     */
    public function buildVueEdit($data, string $template_name ='default'){
        // 模板
        $template_path = '../template/'.$template_name.'/VueEdit';
        $view = new View($template_path);
        $view->assign('data',$data);
        $content = $view->getContent();
        // 写文件
        $file_path = $this->buildFilePath($data,
            'vue/'.$data['table_name'],
            'edit',
            ".vue");
        $content = $this->toPhpFile($content);
        file_put_contents($file_path,$content);
        return true;
    }
    /**
     * vue api js 文件
     * @param $data
     * @param string $template_name
     */
    public function buildVueApiJs($data, string $template_name ='default'){
        // 模板
        $template_path = '../template/'.$template_name.'/VueApiJs';
        $view = new View($template_path);
        $view->assign('data',$data);
        $content = $view->getContent();
        // 写文件
        $file_path = $this->buildFilePath($data,
            'vue/'.$data['table_name'],
            $data['table_name'],
            ".js");
        $content = $this->toPhpFile($content);
        file_put_contents($file_path,$content);
        return true;
    }
}