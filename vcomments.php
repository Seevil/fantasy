<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<link rel="stylesheet" href="<?php $this->options->themeUrl('css/vcomments.css'); ?>">
<link rel="stylesheet" href="<?php $this->options->themeUrl('lib/OwO/OwO.min.css'); ?>">
<?php 
function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }

    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
?>
<?php
            $host = 'https://sdn.geekzu.org'; 
            $url = '/avatar/'; 
            $rating = Helper::options()->commentsAvatarRating;
            $hash = md5(strtolower($comments->mail));
			$email = strtolower($comments->mail);
			$qq=str_replace('@qq.com','',$email);
			if(strstr($email,"qq.com") && is_numeric($qq) && strlen($qq) < 11 && strlen($qq) > 4)
			{
			$avatar = '//q3.qlogo.cn/g?b=qq&nk='.$qq.'&s=100';
			}else{
			  $avatar = $host . $url . $hash . '?s=50' . '&r=' . $rating . '&d=mm';
			}       
            ?>
<div class="vcard" id="<?php $comments->theId(); ?>">
				<img class="vimg" src="<?php echo $avatar ?>">
				<div class="vh">
					<div class="vhead">
					<span class="vnick"><?php $comments->author(); ?></span><span class="vsys"><?php echo getBrowser($comments->agent); ?></span><span class="vsys"><?php echo getOs($comments->agent); ?></span>
					</div>
					<div class="vmeta">
						<span class="vtime"><?php $comments->dateWord(); ?></span><span class="vat comment-reply cp-<?php $comments->theId(); ?> text-muted comment-reply-link"><?php $comments->reply('回复'); ?></span><span id="vat cancel-comment-reply" class="cancel-comment-reply cl-<?php $comments->theId(); ?> text-muted comment-reply-link" style="display:none" ><?php $comments->cancelReply('取消'); ?></span>
					</div>
					<div class="vcontent">
						<p>
						<?php if ('waiting' == $comments->status): ?><div class="comment-waiting">您的评论需管理员审核后才能显示！</div><?php endif; ?>
							<?php showCommentContent($comments->coid); ?>
						</p>
					</div>
					<div class="vreply-wrapper" >
					</div>
					<?php if ($comments->children) { ?>
					<div class="vquote">
				<?php $comments->threadedComments($options); ?>
				</div>
				<?php } ?>
					
				</div>
			</div>
<?php } ?>
<?php $this->comments()->to($comments); ?>
<?php if($this->allow('comment')): ?>
<div class="m-comments">
<div id="comments" class="f-comments">
	<div id="vcomments" class=" v" data-class="v">
		<div class="vpanel">
			<div class="vwrap" id="<?php $this->respondId(); ?>">
				
				<form method="post" action="<?php $this->commentUrl() ?>" id="comment-form">
				<div class="adminui"><?php if($this->user->hasLogin()): ?>
	<?php _e('登录身份: '); ?><a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a>
					</div>
				<?php else: ?>
				
				<div class="vheader item3">
					<input name="author"  value="<?php $this->remember('author'); ?>" required placeholder="昵称" class="vnick vinput" type="text"><input name="mail" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> placeholder="邮箱" class="vmail vinput" type="email"><input name="url" value="<?php $this->remember('url'); ?>" <?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> placeholder="网址(http://)" class="vlink vinput" type="url">
				</div>
				<?php endif; ?>
				<div class="vedit">
					<textarea name="text" id="veditor" class="OwO-textarea veditor vinput" placeholder="说点什么?"><?php $this->remember('text'); ?></textarea>
					<div class="vrow">
						<div class="vcol vcol-60 status-bar">
						</div>
						<div class="vcol vcol-100 vctrl text-right">
							<span title="表情" class="vicon vemoji-btn OwO"></span>
						</div>
					</div>
				</div>
				
				<div class="vrow">
					<div class="vcol vcol-30">
						<a alt="Markdown is supported" href="https://guides.github.com/features/mastering-markdown/" class="vicon" target="_blank"><svg class="markdown" viewbox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M14.85 3H1.15C.52 3 0 3.52 0 4.15v7.69C0 12.48.52 13 1.15 13h13.69c.64 0 1.15-.52 1.15-1.15v-7.7C16 3.52 15.48 3 14.85 3zM9 11H7V8L5.5 9.92 4 8v3H2V5h2l1.5 2L7 5h2v6zm2.99.5L9.5 8H11V5h2v3h1.5l-2.51 3.5z"></path></svg></a>
					</div>
					<div class="vcol vcol-70 text-right">
						<button type="submit" title="Cmd|Ctrl+Enter" class="vsubmit vbtn">提交</button>
						<?php $security = $this->widget('Widget_Security'); ?>
					</div>
				</div>
				
				</form>
			</div>
		</div>
		<?php if($this->commentsNum!=0): ?>
		<div class="vcount" style="display: block;">
			<span class="vnum"><?php $this->commentsNum('%d'); ?></span> 评论
		</div>
		<?php else: ?>
		<div class="vempty" style="display:block;">快来做第一个评论的人吧~</div>
		<?php endif; ?>
		
		<div class="vcards">
		<?php if ($comments->have()): ?>
						<?php $comments->listComments(); ?>
						<?php endif; ?>	
		</div>
		<div class="vload-bottom text-center" >
		<?php $comments->pageNav('<i class="iconfont icon-left"></i>', '<i class="iconfont icon-right"></i>',10,'',array('wrapTag' => 'div', 'wrapClass' => 'pagination','itemTag' => '','currentClass' => 'page-number',)); ?>
		</div>
		
		
	</div>

</div>
</div>
<script type="text/javascript">
function showhidediv(id){var sbtitle=document.getElementById(id);if(sbtitle){if(sbtitle.style.display=='flex'){sbtitle.style.display='none';}else{sbtitle.style.display='flex';}}}
(function(){window.TypechoComment={dom:function(id){return document.getElementById(id)},pom:function(id){return document.getElementsByClassName(id)[0]},iom:function(id,dis){var alist=document.getElementsByClassName(id);if(alist){for(var idx=0;idx<alist.length;idx++){var mya=alist[idx];mya.style.display=dis}}},create:function(tag,attr){var el=document.createElement(tag);for(var key in attr){el.setAttribute(key,attr[key])}return el},reply:function(cid,coid){var comment=this.dom(cid),parent=comment.parentNode,response=this.dom("<?php echo $this->respondId(); ?>"),input=this.dom("comment-parent"),form="form"==response.tagName?response:response.getElementsByTagName("form")[0],textarea=response.getElementsByTagName("textarea")[0];if(null==input){input=this.create("input",{"type":"hidden","name":"parent","id":"comment-parent"});form.appendChild(input)}input.setAttribute("value",coid);if(null==this.dom("comment-form-place-holder")){var holder=this.create("div",{"id":"comment-form-place-holder"});response.parentNode.insertBefore(holder,response)}comment.appendChild(response);this.iom("comment-reply","");this.pom("cp-"+cid).style.display="none";this.iom("cancel-comment-reply","none");this.pom("cl-"+cid).style.display="";if(null!=textarea&&"text"==textarea.name){textarea.focus()}return false},cancelReply:function(){var response=this.dom("<?php echo $this->respondId(); ?>"),holder=this.dom("comment-form-place-holder"),input=this.dom("comment-parent");if(null!=input){input.parentNode.removeChild(input)}if(null==holder){return true}this.iom("comment-reply","");this.iom("cancel-comment-reply","none");holder.parentNode.insertBefore(response,holder);return false}}})();
</script>
	<script src="<?php $this->options->themeUrl('lib/OwO/OwO.min.js'); ?>"></script>
	<script type="text/javascript">
//OwO
var OwO_winds = new OwO({
    logo: '<svg viewbox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="16172" width="22" height="22"><path d="M512 1024a512 512 0 1 1 512-512 512 512 0 0 1-512 512zM512 56.888889a455.111111 455.111111 0 1 0 455.111111 455.111111 455.111111 455.111111 0 0 0-455.111111-455.111111zM312.888889 512A85.333333 85.333333 0 1 1 398.222222 426.666667 85.333333 85.333333 0 0 1 312.888889 512z" p-id="16173"></path><path d="M512 768A142.222222 142.222222 0 0 1 369.777778 625.777778a28.444444 28.444444 0 0 1 56.888889 0 85.333333 85.333333 0 0 0 170.666666 0 28.444444 28.444444 0 0 1 56.888889 0A142.222222 142.222222 0 0 1 512 768z" p-id="16174"></path><path d="M782.222222 391.964444l-113.777778 59.733334a29.013333 29.013333 0 0 1-38.684444-10.808889 28.444444 28.444444 0 0 1 10.24-38.684445l113.777778-56.888888a28.444444 28.444444 0 0 1 38.684444 10.24 28.444444 28.444444 0 0 1-10.24 36.408888z" p-id="16175"></path><path d="M640.568889 451.697778l113.777778 56.888889a27.875556 27.875556 0 0 0 38.684444-10.24 27.875556 27.875556 0 0 0-10.24-38.684445l-113.777778-56.888889a28.444444 28.444444 0 0 0-38.684444 10.808889 28.444444 28.444444 0 0 0 10.24 38.115556z" p-id="16176"></path></svg>',
    container: document.getElementsByClassName('OwO')[0],
    target: document.getElementsByClassName('OwO-textarea')[0],
    api: '<?php if ($this->options->Emoji == 'able'): ?><?php $this->options->themeUrl('lib/OwO/OwO.json'); ?><?php else: ?><?php $this->options->themeUrl('lib/OwO/OwOmini.json'); ?><?php endif; ?>',
    position: 'down',
    width: '100%',
    maxHeight: '250px'
});</script>
<?php endif; ?>