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
	$sticky = new Typecho_Widget_Helper_Form_Element_Text('sticky', NULL,NULL, _t('文章置顶'), _t('置顶的文章cid，按照排序输入, 请以半角逗号或空格分隔'));
    $form->addInput($sticky);
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
	$Emoji = new Typecho_Widget_Helper_Form_Element_Radio('Emoji',
        array('able' => _t('启用'),
            'disable' => _t('禁止'),
        ),
        'disable', _t('Emoji表情设置'), _t('默认显示Emoji表情，如果你的数据库charset配置不是utf8mb4请禁用'));
    $form->addInput($Emoji);

}

function parseContent($obj){
    $options = Typecho_Widget::widget('Widget_Options');
    if(!empty($options->src_add) && !empty($options->cdn_add)){
        $obj->content = str_ireplace($options->src_add,$options->cdn_add,$obj->content);
    }
	$obj->content = preg_replace("/<a href=\"([^\"]*)\">/i", "<a href=\"\\1\" target=\"_blank\" rel=\"nofollow\">", $obj->content); //新标签页打开连接
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

/**
 * 输出评论回复内容，配合 commentAtContent($coid)一起使用
 * <?php showCommentContent($comments->coid); ?>
 */
function showCommentContent($coid)
{
    $db = Typecho_Db::get();
    $result = $db->fetchRow($db->select('text')->from('table.comments')->where('coid = ? AND (status = ? OR status = ?)', $coid, 'approved','waiting'));
    $text = $result['text'];
    $atStr = commentAtContent($coid);
    $_content = Markdown::convert($text);
    //<p>
    if ($atStr !== '') {
        $content = substr_replace($_content, $atStr, 0, 3);
    } else {
        $content = $_content;
    }

    echo $content;
}

/**
 * 评论回复加@ 
 */
function commentAtContent($coid)
{
    $db = Typecho_Db::get();
    $prow = $db->fetchRow($db->select('parent')->from('table.comments')->where('coid = ? AND (status = ? OR status = ?)', $coid, 'approved','waiting'));
    $parent = $prow['parent'];
    if ($parent != "0") {
        $arow = $db->fetchRow($db->select('author')->from('table.comments')
            ->where('coid = ? AND (status = ? OR status = ?)', $parent, 'approved','waiting'));
        $author = $arow['author'];
        $href = '<p><a  href="#comment-' . $parent . '">@' . $author . '</a> ';
        return $href;
    } else {
        return '';
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


/** 获取浏览器信息 <?php echo getBrowser($comments->agent); ?> */
function getBrowser($agent)
{ $outputer = false;
    if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {
        $outputer = 'IE Browser';
    } else if (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {
      $str1 = explode('Firefox/', $regs[0]);
$FireFox_vern = explode('.', $str1[1]);
        $outputer = 'Firefox Browser '. $FireFox_vern[0];
    } else if (preg_match('/Maxthon([\d]*)\/([^\s]+)/i', $agent, $regs)) {
      $str1 = explode('Maxthon/', $agent);
$Maxthon_vern = explode('.', $str1[1]);
        $outputer = 'Maxthon Browser '.$Maxthon_vern[0];
    } else if (preg_match('#SE 2([a-zA-Z0-9.]+)#i', $agent, $regs)) {
        $outputer = 'Sogo Browser';
    } else if (preg_match('#360([a-zA-Z0-9.]+)#i', $agent, $regs)) {
$outputer = '360 Browser';
    } else if (preg_match('/Edge([\d]*)\/([^\s]+)/i', $agent, $regs)) {
        $str1 = explode('Edge/', $regs[0]);
$Edge_vern = explode('.', $str1[1]);
        $outputer = 'Edge '.$Edge_vern[0];
    } else if (preg_match('/EdgiOS([\d]*)\/([^\s]+)/i', $agent, $regs)) {
        $str1 = explode('EdgiOS/', $regs[0]);
        $outputer = 'Edge';
    } else if (preg_match('/UC/i', $agent)) {
              $str1 = explode('rowser/',  $agent);
$UCBrowser_vern = explode('.', $str1[1]);
        $outputer = 'UC Browser '.$UCBrowser_vern[0];
    }else if (preg_match('/OPR/i', $agent)) {
              $str1 = explode('OPR/',  $agent);
$opr_vern = explode('.', $str1[1]);
        $outputer = 'Open Browser '.$opr_vern[0];
    } else if (preg_match('/MicroMesseng/i', $agent, $regs)) {
        $outputer = 'Weixin Browser';
    }  else if (preg_match('/WeiBo/i', $agent, $regs)) {
        $outputer = 'WeiBo Browser';
    }  else if (preg_match('/QQ/i', $agent, $regs)||preg_match('/QQ Browser\/([^\s]+)/i', $agent, $regs)) {
                  $str1 = explode('rowser/',  $agent);
$QQ_vern = explode('.', $str1[1]);
        $outputer = 'QQ Browser '.$QQ_vern[0];
    } else if (preg_match('/MQBHD/i', $agent, $regs)) {
                  $str1 = explode('MQBHD/',  $agent);
$QQ_vern = explode('.', $str1[1]);
        $outputer = 'QQ Browser '.$QQ_vern[0];
    } else if (preg_match('/BIDU/i', $agent, $regs)) {
        $outputer = 'Baidu Browser';
    } else if (preg_match('/LBBROWSER/i', $agent, $regs)) {
        $outputer = 'KS Browser';
    } else if (preg_match('/TheWorld/i', $agent, $regs)) {
        $outputer = 'TheWorld Browser';
    } else if (preg_match('/XiaoMi/i', $agent, $regs)) {
        $outputer = 'XiaoMi Browser';
    } else if (preg_match('/UBrowser/i', $agent, $regs)) {
              $str1 = explode('rowser/',  $agent);
$UCBrowser_vern = explode('.', $str1[1]);
        $outputer = 'UCBrowser '.$UCBrowser_vern[0];
    } else if (preg_match('/mailapp/i', $agent, $regs)) {
        $outputer = 'Email Browser';
    } else if (preg_match('/2345Explorer/i', $agent, $regs)) {
        $outputer = '2345 Browser';
    } else if (preg_match('/Sleipnir/i', $agent, $regs)) {
        $outputer = 'Sleipnir Browser';
    } else if (preg_match('/YaBrowser/i', $agent, $regs)) {
        $outputer = 'Yandex Browser';
    }  else if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {
        $outputer = 'Opera Browser';
    } else if (preg_match('/MZBrowser/i', $agent, $regs)) {
        $outputer = 'MZ Browser';
    } else if (preg_match('/VivoBrowser/i', $agent, $regs)) {
        $outputer = 'Vivo Browser';
    } else if (preg_match('/Quark/i', $agent, $regs)) {
        $outputer = 'Quark Browser';
    } else if (preg_match('/mixia/i', $agent, $regs)) {
        $outputer = 'Mixia Browser';
    }else if (preg_match('/fusion/i', $agent, $regs)) {
        $outputer = 'Fusion';
    } else if (preg_match('/CoolMarket/i', $agent, $regs)) {
        $outputer = 'CoolMarket Browser';
    } else if (preg_match('/Thunder/i', $agent, $regs)) {
        $outputer = 'Thunder Browser';
    } else if (preg_match('/Chrome([\d]*)\/([^\s]+)/i', $agent, $regs)) {
$str1 = explode('Chrome/', $agent);
$chrome_vern = explode('.', $str1[1]);
        $outputer = 'Chrome '.$chrome_vern[0];
    } else if (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {
         $str1 = explode('Version/',  $agent);
$safari_vern = explode('.', $str1[1]);
        $outputer = 'Safari '.$safari_vern[0];
    } else{
        return false;
    }
   return $outputer;
}

/** 获取操作系统信息 <?php echo getOs($comments->agent); ?>*/
function getOs($agent)
{
    $os = false;
 
    if (preg_match('/win/i', $agent)) {
        if (preg_match('/nt 10.0/i', $agent)) {
            $os = 'Windows 10';
        } else if (preg_match('/nt 6.1/i', $agent)) {
            $os = 'Windows 7';
        } else if (preg_match('/nt 6.2/i', $agent)) {
            $os = 'Windows 8';
        } else if(preg_match('/nt 6.3/i', $agent)) {
            $os = 'Windows 8.1';
        } else if(preg_match('/nt 5.1/i', $agent)) {
            $os = 'Windows XP';
        } else if (preg_match('/nt 6.0/i', $agent)) {
            $os = 'Windows Vista';
        } else{
            $os = 'Windows 11';
        }
    } else if (preg_match('/android/i', $agent)) {
    if (preg_match('/android 11/i', $agent)) {
            $os = 'Android R';
        }
    else if (preg_match('/android 12/i', $agent)) {
            $os = 'Android 12';
        }
    else if (preg_match('/android 10/i', $agent)) {
            $os = 'Android Q';
        }
    else if (preg_match('/android 9/i', $agent)) {
            $os = 'Android P';
        }
    else if (preg_match('/android 8/i', $agent)) {
            $os = 'Android O';
        }
    else{
            $os = 'Android';
    }
    }
 else if (preg_match('/ubuntu/i', $agent)) {
        $os = 'ubuntu';
    } else if (preg_match('/linux/i', $agent)) {
        $os = 'Linux';
    } else if (preg_match('/iPhone/i', $agent)) {
        $os = 'iPhone';
    } else if (preg_match('/iPad/i', $agent)) {
        $os = 'iPad';
    } else if (preg_match('/mac/i', $agent)) {
        $os = 'OSX';
    }else if (preg_match('/cros/i', $agent)) {
        $os = 'Chrome os';
    }else {
 return false;
    }
   return $os;
}