<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');?>
	<main>
	<section class="article-list">
    <?php if ($this->have()): ?>
	<?php while($this->next()): ?>
	<article>
	<h2><a href="<?php $this->permalink() ?>" class=""><?php $this->title();$this->sticky(38,'...') ?></a><?php if ($this->options->eyeshow == 'able'): ?> <span><?php get_post_view($this) ?>度</span><?php endif; ?></h2>
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
    <?php else: ?>
        <article>
            <h2>没有找到 <?php $this->archiveTitle(array('search'  =>  _t('包含关键字“ %s ”的文章'),), '', ''); ?></h2>
            </article>
        <?php endif; ?>
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
