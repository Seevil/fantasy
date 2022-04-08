<?php
/**
 * Fantasy 是一个极简自适应博客主题
 * 经作者同意由BITCRON博客Aragaki主题移植而来。
 * 又改名为Fantasy取义“清梦”源自“ 醉后不知天在水，满船清梦压星河。” 意图用来描绘现状。
 * @package Fantasy Theme
 * @author Xingr
 * @version 1.4.2
 * @link https://www.krsay.com/
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
$sticky = $this->options->sticky; 
if($sticky && $this->is('index') || $this->is('front')){
    $sticky_cids = explode(',', strtr($sticky, ' ', ','));
    $sticky_html = "<span>[置顶] </span>";
    $db = Typecho_Db::get();
    $pageSize = $this->options->pageSize;
    $select1 = $this->select()->where('type = ?', 'post');
    $select2 = $this->select()->where('type = ? && status = ? && created < ?', 'post','publish',time());
    //清空原有文章的列队
    $this->row = [];
    $this->stack = [];
    $this->length = 0;
    $order = '';
    foreach($sticky_cids as $i => $cid) {
        if($i == 0) $select1->where('cid = ?', $cid);
        else $select1->orWhere('cid = ?', $cid);
        $order .= " when $cid then $i";
        $select2->where('table.contents.cid != ?', $cid); //避免重复
    }
    if ($order) $select1->order('', "(case cid$order end)"); //置顶文章的顺序 按 $sticky 中 文章ID顺序
    if (($this->_currentPage || $this->currentPage) == 1) foreach($db->fetchAll($select1) as $sticky_post){ //首页第一页才显示
        $sticky_post['sticky'] = $sticky_html;
        $this->push($sticky_post); //压入列队
    }
    if($this->user->hasLogin()){
    $uid = $this->user->uid; //登录时，显示用户各自的私密文章
    if($uid) $select2->orWhere('authorId = ? && status = ?', $uid, 'private');
    }
    $sticky_posts = $db->fetchAll($select2->order('table.contents.created', Typecho_Db::SORT_DESC)->page($this->_currentPage, $this->parameter->pageSize));
    foreach($sticky_posts as $sticky_post) $this->push($sticky_post); //压入列队
    $this->setTotal($this->getTotal()-count($sticky_cids)); //置顶文章不计算在所有文章内
}
?>
	<main>
	<section class="article-list">
	<?php while($this->next()): ?>
	<article>
	<h2><a href="<?php $this->permalink() ?>" class=""><?php $this->title();$this->sticky(38,'...') ?></a><?php if ($this->options->eyeshow == 'able'): ?> <span><?php get_post_view($this) ?>度</span><?php endif; ?></h2>
	<div class="excerpt">
		<p><?php $this->excerpt();?></p>
	</div>
	<div class="meta">
		<span class="item"><i class="iconfont icon-calendar"></i><time datetime="<?php $this->date(); ?>"> <?php $this->date('Y.m.d '); ?></time></span>
		<span class="item"><i class="iconfont icon-tag"></i><?php $this->category(''); ?></span>
		<span class="item"><i class="iconfont icon-message"></i><a href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('0 评', '1 评', '%d 评'); ?></a></span>
	</div>
	</article>
	<?php endwhile; ?>
	</section>
	<section class="list-pager">
	<?php $this->pageLink('<i class="iconfont icon-left"></i> 上一页'); ?>
	<?php $this->pageLink('下一页<i class="iconfont icon-right"></i>','next'); ?>
	<div class="clear">
	</div>
	</section>
	</main>
</div>
<?php $this->need('footer.php'); ?>
