<?php


namespace app\generator\core;


use JoinPhpCommon\utils\Text;
use think\Db;
use think\Exception;
use think\facade\Env;
use think\response\View;

/**
 * 代码生成工具
 * Class Generator
 * @package app\generator\controller
 */
class Generator
{
    const MODE_EXIST_EXCEPTION = 0;// 存在则报错
    const MODE_EXIST_COPY = 1;// 存在则创建副本
    const MODE_FORCE_COVER = 2;// 存在则强制覆盖 ！！！！除非你非常自信，否则别用这个

    private $config= [
        'mode'=>self::MODE_EXIST_COPY,
        'model_prefix'=>'Model_',
        'model_suffix'=>'',
        'controller_prefix'=>'',
        'controller_suffix'=>'',
    ];

    /**
     * Generator constructor.
     * @param array $config
     */
    public function __construct(array $config = []){
        $this->config = array_merge($this->config,$config);
    }

    /**
     * 生成模型文件
     * @param $data
     * @param string $template_name
     * @return bool
     * @throws Exception
     */
    public function buildModel($data, string $template_name ='default'): bool
    {
        // 模板
        $template_path = '../template/'.$template_name.'/Model';
        $view = new View($template_path);
        $view->assign('data',$data);
        $content = $view->getContent();

        // 写文件
        $file_path = $this->buildFilePath($data,'model',$data['model_name'],".php");
        $content = $this->toPhpFile($content);
        file_put_contents($file_path,$content);
        return true;
    }

    /**
     * 生成控制器
     * @param $data
     * @param string $template_name
     * @return bool
     * @throws Exception
     */
    public function buildController($data, string $template_name ='default'): bool
    {
        // 模板
        $template_path = '../template/'.$template_name.'/Controller';
        $view = new View($template_path);
        $view->assign('data',$data);
        $content = $view->getContent();
        // 写文件
        $file_path = $this->buildFilePath($data,'controller',$data['controller_name'],".php");
        $content = $this->toPhpFile($content);
        file_put_contents($file_path,$content);
        return true;
    }

    /**
     * 生成验证器文件
     * @param $data
     * @param string $template_name
     */
    public function buildValidate($data, string $template_name ='default'){

    }

    /**
     * @throws Exception
     */
    protected function buildFilePath($data, $folder_name,$file_name, $extended_name): string
    {
        $app_path = Env::get('app_path');
        $folder_path =  $app_path.$data['module_name']."\\".$folder_name;
        // 文件夹是否存在
        if (!file_exists($folder_path)){ mkdir($folder_path,0777,true); }

        $file_path = $folder_path."\\".$file_name.$extended_name;
        //目标文件是否存在
        if(file_exists($file_path)){
            if($this->config['mode'] == self::MODE_EXIST_EXCEPTION){
                throw new Exception('文件已存在:'.$file_path);
            }
            else if ($this->config['mode'] == self::MODE_EXIST_COPY){
                $file_path.=' copy';
            }
        }
        return $file_path;
    }

    /**
     * 文件转php文件，去除特殊转义
     */
    protected function toPhpFile($str){
        $str = str_replace("<-?php","<?php",$str);
        return $str;
    }
    /**
     * 获取表信息
     * @param string $table_name
     * @param string $module_name
     * @return array
     */
    public function getTableInfo(string $table_name, string $module_name ='index'): array
    {
        $data['module_name'] = $module_name;
        $data['table_name'] = $table_name;
        $data['class_name'] = Text::toCamel($table_name,'_',false);
        $data['pk'] = $this->getPrimaryKey($table_name);

        $data['model_name'] = $this->config['model_prefix'].$data['class_name'].$this->config['model_suffix'];
        $data['controller_name'] = $this->config['controller_prefix'].$data['class_name'].$this->config['controller_suffix'];

        $data['columns'] = $this->getTableColumns($table_name);
        return $data;
    }
    //查询查询数据表
    public function getTableNameList($db_name): array
    {
        return Db::name('information_schema.tables')
            ->where(['table_schema'=>$db_name,'table_type'=>'base table'])
            ->column('table_name');
    }
    // 表主键
    public function getPrimaryKey($table_name){
        $data = Db::query("SHOW COLUMNS FROM `{$table_name}` where `Key`='PRI'");
        if(count($data)>0){
            return $data[0]['Field'];
        }
        return '';
    }
    // 表结构
    public function getTableColumns($table_name){
        $sql = "SELECT COLUMN_NAME field,DATA_TYPE data_type,COLUMN_KEY col_key,COLUMN_COMMENT comment from information_schema.COLUMNS where TABLE_NAME='{$table_name}' order by ORDINAL_POSITION";
        $data = Db::query($sql);
        foreach ($data as $k=>$v){
            $data[$k]['field_desc'] = $v['field'];
            if ($v['comment']){
                // 截取中文名称
                $pattern = "/^[\x80-\xff_a-zA-Z0-9]+/";
                preg_match($pattern, $v['comment'], $res);
                if(count($res)>0){
                    $data[$k]['field_desc'] = $res[0];
                }
            }
        }
        return $data;
    }
}