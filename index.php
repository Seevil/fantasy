<?php
/**
 * Fantasy 是一个极简自适应博客主题
 * 经作者同意由BITCRON博客Aragaki主题移植而来。
 * 又改名为Fantasy取义“清梦”源自“ 醉后不知天在水，满船清梦压星河。” 意图用来描绘现状。
 * @package Fantasy Theme
 * @author Intern
 * @version 1.2.0
 * @link https://wwww.xde.io/
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
	<main>
	<section class="article-list">
	<?php while($this->next()): ?>
	<article>
	<h2><a href="<?php $this->permalink() ?>" class=""><?php $this->title() ?></a><?php if ($this->options->eyeshow == 'able'): ?> <span><?php get_post_view($this) ?>度</span><?php endif; ?></h2>
	<div class="excerpt">
		<p><?php $this->excerpt();?></p>
	</div>
	<div class="meta">
		<span class="item"><i class="iconfont icon-calendar"></i><time datetime="<?php $this->date(); ?>"><?php $this->date('Y.m.d '); ?></time></span>
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