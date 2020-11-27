<?php 
/**
* 友情链接
*
* @package custom
*/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
            <main>
                <article class="content">
                    <h1><?php $this->title() ?></h1>
                    <div class="meta">
                     <span class="item"><i class="iconfont icon-calendar"></i><time datetime="<?php $this->date(); ?>"><?php $this->date('Y.m.d'); ?></time></span>
					<?php if ($this->options->eyeshow == 'able'): ?><span class="item"><i class="iconfont icon-eye"></i> <?php get_post_view($this) ?> 度</span><?php endif; ?>
					 <?php if($this->user->hasLogin()):?><span><a href="<?php $this->options->siteUrl(); ?>admin/write-post.php?cid=<?php $this->cid(); ?>">[编辑]</a></span><?php endif;?>
                    </div>
                    <div class="meta">
                            <?php $this->content(); ?> 
                    </div>
                </article>
                <section class="pager">
                </section>
                
            </main>
        </div>
<script>document.querySelectorAll('ul.flinks').forEach(function(e){let a=e;if(a){let ns=a.querySelectorAll("li");let str='<div style="display:inline-block;">';for(let i=0;i<ns.length;i+=4){str+=(`<div class="flink-item link-bg"><div class="flink-title"><a href="${ns[i+1].innerText}"target="_blank"rel="external nofollow ugc">${ns[i].innerText}</a></div><div class="flink-link"><div class="flink-link-ico"style="background: url(${ns[i+2].innerText});background-size: 42px auto;"></div><div class="flink-link-text">${ns[i+3].innerText}</div></div></div>`)}str+=`</div>`;let n1=document.createElement("div");n1.innerHTML=str;a.parentNode.insertBefore(n1,a);a.style="display: none;"}});</script>
<style>.flink-item{width:300px;height:100px;position:relative;margin:10px;background-color: #f7f7f7;border-radius:3px;float:left;}.flink-title{left:25px;top:25px;position:absolute}.flink-title a{font-size:17px;color:#6b6b6b;line-height:17px;word-break:break-all;text-decoration:none;outline:0}.flink-link{right:0;bottom:0;padding:0 15px 0px;position:absolute;text-align:right}.flink-link-text{font-size:12px;color:#999}.flink-link-ico{display:inline-block;width:42px;height:42px;border-radius:50%}</style>
<?php $this->need('footer.php'); ?>