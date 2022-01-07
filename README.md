![](https://box.kancloud.cn/5a0aaa69a5ff42657b5c4715f3d49221) 

ThinkPHP Generator 代码生成器
===============


依赖 ThinkPHP5.1 模板渲染引擎自动生成代码：

 + Controller 生成
 + Model 生成
 + Vue 列表页生成


#### 待完成
+ validate 验证器生成
+ Vue 详情页生成
+ Vue 编辑页生成


> ThinkPHP5的运行环境要求PHP5.6以上，兼容PHP8.0。

## 安装

下载本项目 拷贝 application/generator模块目录到你的项目中

编写生成信息
~~~
tp-generator\application\index\controller\Index.php
~~~

访问调用运行生成
~~~
http://localhost:8080/generator/index/index
~~~

## 目录结构

初始的目录结构如下：

~~~
www  WEB部署目录（或者子目录）
├─application           应用目录
│  ├─generator          代码生成木块
│  │  ├─controller      生成调用入口
│  │  ├─core            生成器类库
│  │  │ └─Generator     生成器类
│  │  └─template        生成的代码模板
│  │    ├─default       默认模板主题
│  │    │  ├─Controller 控制器模板
│  │    │  ├─Model      模型模板
│  │    │  ├─VueDetail  vue详情模板
│  │    │  ├─VueList    vue 列表页模板
│  │    │  ├─VueEdit    vue 编辑页模板
│  │    │  └─ ...       更多模板
│  │    └─ ...          其他自定义模板主题

~~~
## 用法
创建构造器
```php
$g = new Generator();
//定义数据表
$table_name ='pay_order';
// 查询数据接口信息
$info =  $g->getTableInfo($table_name,'common');

// 生成model
$g->buildModel($info);
// 生成controller
$g->buildController($info);
// 生成 vue list
$g->buildVueList($info);
// 生成 vue detail
$g->buildVueDetail($info);
//...
```