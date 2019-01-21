<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
            <main>
                <article class="content">
                    <h1><?php $this->title() ?></h1>
                    <div class="meta">
                     <span class="item"><i class="iconfont icon-calendar"></i><time datetime="<?php $this->date(); ?>"><?php $this->date('Y.m.d'); ?></time></span>
					<span class="item"><i class="iconfont icon-tag"></i><?php $this->category(' '); ?></span>
					<span class="item"><i class="iconfont icon-message"></i><a href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('0 评', '1 评', '%d 评'); ?></a></span>
					<?php if ($this->options->eyeshow == 'able'): ?><span class="item"><i class="iconfont icon-eye"></i> <?php get_post_view($this) ?> 度</span><?php endif; ?>
					 <?php if($this->user->hasLogin()):?><span><a href="<?php $this->options->siteUrl(); ?>admin/write-post.php?cid=<?php $this->cid(); ?>">[编辑]</a></span><?php endif;?>
                    </div>
                    <div class="post">
                            <?php $this->content(); ?> 
                    </div>
                </article>
                <section class="pager">
				<?php $this->thePrev('%s', '', array('title' => '', 'tagClass' => 'next')); ?>
				<?php $this->theNext('%s', '', array('title' => '', 'tagClass' => 'pre')); ?>

                </section>
                <?php $this->need('comments.php'); ?>
            </main>
        </div>
<?php $this->need('footer.php'); ?>