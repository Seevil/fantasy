<?php 
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
<main>
                <section class="content">
                    <h1><?php $this->category(',', false); ?></h1>
                    <div class="meta"><?php echo $this->getDescription(); ?></div>
                    <div class="info"></div>
                    <ul class="archived-posts">
					<?php while($this->next()): ?>
                        <li>
                            <time datetime="<?php $this->date('Y.m.j'); ?>"><?php $this->date('Y.m.j'); ?></time>
                            <a href="<?php $this->permalink() ?>"><?php $this->title() ?></a><?php if ($this->options->eyeshow == 'able'): ?> <span><?php get_post_view($this) ?>度</span><?php endif; ?>
                        </li>
					<?php endwhile; ?>
                    </ul>
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