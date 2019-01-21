<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<aside>
<div class="aside-left sidebar">
	<h3>随机文章</h3>
	<?php theme_random_posts();?>
	<div class="clear">
	</div>

</div>

<div class="aside-right sidebar">
	<h3>分门别类</h3>
	<ul>
		<?php $this->widget('Widget_Metas_Category_List')->parse('<li><a href="{permalink}" class="">{name}<span> {count}篇</span></a></li>'); ?>
	</ul>
</div>
</aside><footer><span>© 2018 <?php $this->options->title(); ?> - <a href="<?php $this->options->feedUrl();?>"><?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?><?php $stat->publishedPostsNum() ?> Posts crafted</a></span><span> ♥ <a href="https://blog.shuiba.co/bitcron-theme-hello">Hello</a> & <a href="https://github.com/PCDotFan/Aragaki">Aragaki</a> By <a href="https://www.xde.io/typecho/fantasy.html">Xingr</a></span>
<div class="powered_by">
	<span>Proudly published with</span>
	<a href="http://typecho.org/" target="_blank">Typecho</a>
</div>
<div class="footer_slogan">

</div>
</footer>
<link rel="stylesheet" href="<?php $this->options->themeUrl('css/fonts.css'); ?>">
<?php if ($this->options->useHighline == 'able'): ?>
<script src="https://cdn.staticfile.org/highlight.js/9.13.1/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
<?php endif; ?>
<style type="text/css">
a.back_to_top{text-decoration:none;position:fixed;bottom:40px;right:30px;background:#f0f0f0;height:40px;width:40px;border-radius:50%;line-height:36px;font-size:18px;text-align:center;transition-duration:.5s;transition-propety:background-color;display:none}a.back_to_top span{color:#888}a.back_to_top:hover{cursor:pointer;background:#dfdfdf}a.back_to_top:hover span{color:#555}@media print,screen and (max-width:580px){.back_to_top{display:none!important}}
</style>
<a id="back_to_top" href="#" class="back_to_top"><span>△</span></a>
<script>
$(document).ready((function(_this){return function(){var bt;bt=$('#back_to_top');if($(document).width()>480){$(window).scroll(function(){var st;st=$(window).scrollTop();if(st>30){return bt.css('display','block')}else{return bt.css('display','none')}});return bt.click(function(){$('body,html').animate({scrollTop:0},800);return false})}}})(this));
$(function(){$('a[href*=#]:not([href=#])').click(function(){if(location.pathname.replace(/^\//,'')==this.pathname.replace(/^\//,'')&&location.hostname==this.hostname){var target=$(this.hash);target=target.length?target:$('[name='+this.hash.slice(1)+']');if(target.length){$('html,body').animate({scrollTop:target.offset().top},500);return false}}})});
</script>
<?php $this->footer(); ?>
</body>
</html>