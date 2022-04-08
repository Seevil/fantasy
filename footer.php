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
</aside><footer><span>© <?php echo date('Y'); ?> <?php $this->options->title(); ?> - <a href="<?php $this->options->feedUrl();?>"><?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?><?php $stat->publishedPostsNum() ?> Posts crafted</a></span><span> ♥  <a href="https://github.com/PCDotFan/Aragaki">Aragaki</a> By <a href="https://www.krsay.com/typecho/fantasy.html">Fantasy</a></span>
<div class="powered_by">
	<span>Proudly published with</span>
	<a href="http://typecho.org/" target="_blank">Typecho</a>
</div>
<div class="footer_slogan">
</div>
</footer>
<link rel="stylesheet" href="<?php $this->options->themeUrl('css/fonts.css'); ?>">
<?php if ($this->is('post') || $this->is('page') && $this->options->useHighline == 'able'): ?>
<script src="<?php $this->options->themeUrl('lib/highlight.min.js'); ?>"></script>
<script>hljs.highlightAll();</script>
<?php endif; ?>
	   <div class="searchbox">
    <div class="searchbox-container">
        <div class="searchbox-input-wrapper">
            <form class="search-form" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
                <input name="s" type="search" class="searchbox-input" placeholder="输入关键字回车搜索" />
                <span class="searchbox-close searchbox-selectable"><svg t="1649406485387" class="icon" viewBox="0 0 1025 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3502" width="20" height="20"><path d="M716.241478 658.468298c14.825761 14.314528 14.825761 38.342486 0 52.657014l-1.022467 1.022466c-14.825761 14.825761-38.853719 14.825761-53.67948 0l-150.302546-147.235147L360.934438 712.147778c-14.825761 14.314528-38.853719 14.314528-53.67948 0l-1.022467-1.022466c-14.825761-14.825761-14.825761-38.342486 0-52.657014l150.302546-147.235148-150.813779-147.235147c-14.825761-14.314528-14.825761-38.342486 0-52.657014l1.022466-1.022467c14.825761-14.825761 38.853719-14.825761 53.679481 0l150.302546 147.235147 150.302547-147.235147c14.825761-14.314528 38.853719-14.314528 53.67948 0l1.022467 1.022467c14.825761 14.825761 14.825761 38.342486 0 52.657014l-150.302547 147.235147 150.81378 147.235148z" p-id="3503" fill="#515151"></path><path d="M511.236985 0C229.036286 0 0.003834 229.032451 0.003834 511.23315s229.032451 511.23315 511.233151 511.233151 511.23315-229.032451 511.23315-511.233151-229.032451-511.23315-511.23315-511.23315z m0 940.668997c-237.212182 0-429.435846-192.223665-429.435847-429.435847s192.223665-429.435846 429.435847-429.435846 429.435846 192.223665 429.435846 429.435846-192.734898 429.435846-429.435846 429.435847z" p-id="3504" fill="#515151"></path></svg></span>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded',function(){(function($){$('#search').click(function(){$('.searchbox').toggleClass('show')});$('.searchbox .searchbox-mask').click(function(){$('.searchbox').removeClass('show')});$('.searchbox-close').click(function(){$('.searchbox').removeClass('show')})})(jQuery)});
</script>
<style type="text/css">
a.back_to_top{text-decoration:none;position:fixed;bottom:40px;right:30px;background:#f0f0f0;height:40px;width:40px;border-radius:50%;line-height:36px;font-size:18px;text-align:center;transition-duration:.5s;transition-propety:background-color;display:none}a.back_to_top span{color:#888}a.back_to_top:hover{cursor:pointer;background:#dfdfdf}a.back_to_top:hover span{color:#555}@media print,screen and (max-width:580px){.back_to_top{display:none!important}}
</style>
<a id="search" class="search icon" href="javascript:;"><svg t="1649405627786" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2703" width="16" height="16"><path d="M1012.224 953.856l-180.224-180.224c68.608-81.92 110.08-187.392 110.08-302.592 0-260.096-210.944-471.04-471.04-471.04S0 210.944 0 471.04s210.944 471.04 471.04 471.04c115.2 0 221.184-41.472 303.104-110.08l180.224 180.224c8.192 8.192 18.432 11.776 29.184 11.776s20.992-4.096 29.184-11.776c15.36-16.384 15.36-41.984-0.512-58.368zM75.264 471.04c0-218.624 177.152-395.776 395.776-395.776s395.776 177.152 395.776 395.776-177.152 395.776-395.776 395.776S75.264 689.664 75.264 471.04z" p-id="2704" fill="#707070"></path></svg></a>
<a id="back_to_top" href="#top" class="back_to_top"><span>△</span></a>
<script>
$(document).ready((function(_this){return function(){var bt;bt=$('#back_to_top');if($(document).width()>480){$(window).scroll(function(){var st;st=$(window).scrollTop();if(st>30){return bt.css('display','block')}else{return bt.css('display','none')}});return bt.click(function(){$('body,html').animate({scrollTop:0},800);return false})}}})(this));
</script>
<?php $this->footer(); ?>
</body>
</html>
