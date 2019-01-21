<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
function themeConfig($form) {
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('博客头像地址'), _t('博客头像,留空则使用默认'));
    $form->addInput($logoUrl->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));
    $footerLogoUrl = new Typecho_Widget_Helper_Form_Element_Text('footerLogoUrl', NULL, NULL, _t('底部图片地址'), _t('一般为http://www.yourblog.com/image.png,支持 https:// 或 //,留空则使用站点名称'));
    $form->addInput($footerLogoUrl->addRule('xssCheck', _t('请不要在图片链接中使用特殊字符')));

    $useHighline = new Typecho_Widget_Helper_Form_Element_Radio('useHighline',
        array('able' => _t('启用'),
            'disable' => _t('禁止'),
        ),
        'disable', _t('代码高亮设置'), _t('默认禁止，启用则会对 ``` 进行代码高亮'));
    $form->addInput($useHighline);
	
    $fontshow = new Typecho_Widget_Helper_Form_Element_Radio('fontshow',
        array('able' => _t('启用'),
            'disable' => _t('禁止'),
        ),
        'disable', _t('阅读视觉优化'), _t('默认禁止，启用则使用视觉阅读优化'));
    $form->addInput($fontshow);
	$eyeshow = new Typecho_Widget_Helper_Form_Element_Radio('eyeshow',
        array('able' => _t('启用'),
            'disable' => _t('禁止'),
        ),
        'disable', _t('是否显示文章热度'), _t('默认禁止，启用则显示文章热度浏览数'));
    $form->addInput($eyeshow);

}

function parseContent($obj){
    $options = Typecho_Widget::widget('Widget_Options');
    if(!empty($options->src_add) && !empty($options->cdn_add)){
        $obj->content = str_ireplace($options->src_add,$options->cdn_add,$obj->content);
    }
    echo trim($obj->content);
}

function theme_random_posts(){
$defaults = array(
'number' => 12,
'before' => '<ul>',
'after' => '</ul>',
'xformat' => '<li style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" title="{title}"><a href="{permalink}">{title}</a>
 </li>'
);
$db = Typecho_Db::get();
$adapterName = $db->getAdapterName();//兼容非MySQL数据库
if($adapterName == 'pgsql' || $adapterName == 'Pdo_Pgsql' || $adapterName == 'Pdo_SQLite' || $adapterName == 'SQLite'){
   $order_by = 'RANDOM()';
   }else{
   $order_by = 'RAND()';
 }
$sql = $db->select()->from('table.contents')
->where('status = ?','publish')
->where('type = ?', 'post')
->limit($defaults['number'])
->order($order_by);
$result = $db->fetchAll($sql);
echo $defaults['before'];

foreach($result as $val){
$val = Typecho_Widget::widget('Widget_Abstract_Contents')->filter($val);
echo str_replace(array('{permalink}', '{title}'),array($val['permalink'], $val['title']), $defaults['xformat']);
}
echo $defaults['after'];
}

function getCommentAt($coid){
    $db   = Typecho_Db::get();
    $prow = $db->fetchRow($db->select('parent')
        ->from('table.comments')
        ->where('coid = ? AND status = ?', $coid, 'approved'));
    $parent = $prow['parent'];
    if ($parent != "0") {
        $arow = $db->fetchRow($db->select('author')
            ->from('table.comments')
            ->where('coid = ? AND status = ?', $parent, 'approved'));
        $author = $arow['author'];
        $href   = '<a href="#comment-'.$parent.'">@'.$author.'</a>';
        echo $href;
    } else {
        echo '';
    }
}

//文章阅读次数含cookie
function get_post_view($archive)
{
    $cid    = $archive->cid;
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
 $views = Typecho_Cookie::get('extend_contents_views');
        if(empty($views)){
            $views = array();
        }else{
            $views = explode(',', $views);
        }
if(!in_array($cid,$views)){
       $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
array_push($views, $cid);
            $views = implode(',', $views);
            Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
        }
    }
    echo $row['views'];
}

//统计当前分类和子分类文章总数
function fenleinum($id){
$db = Typecho_Db::get();
$po=$db->select('table.metas.count')->from ('table.metas')->where ('parent = ?', $id)->orWhere('mid = ? ', $id);
$pom = $db->fetchAll($po);
$num = count($pom);
$shu = 0;
for ($x=0; $x<$num; $x++) {
$shu=$pom[$x]['count']+$shu;
}
echo $shu;
}

function timer_start() {
global $timestart;
$mtime = explode( ' ', microtime() );
$timestart = $mtime[1] + $mtime[0];
return true;
}
timer_start();
function timer_stop( $display = 0, $precision = 3 ) {
global $timestart, $timeend;
$mtime = explode( ' ', microtime() );
$timeend = $mtime[1] + $mtime[0];
$timetotal = $timeend - $timestart;
$r = number_format( $timetotal, $precision );
if ( $display )
echo $r;
return $r;
}
