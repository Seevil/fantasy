<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

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
<li id="<?php $comments->theId(); ?>" class="comment">
		<div class="comment_wrapper">
		<div class="author">
		            <?php
            //头像CDN by Rich
            $host = 'https://gravatar.loli.net'; 
            $url = '/avatar/'; 
            $rating = Helper::options()->commentsAvatarRating;
            $hash = md5(strtolower($comments->mail));
			$email = strtolower($comments->mail);
			$qq=str_replace('@qq.com','',$email);
			if(strstr($email,"qq.com") && is_numeric($qq) && strlen($qq) < 11 && strlen($qq) > 4)
			{
			$avatar = '//q3.qlogo.cn/g?b=qq&nk='.$qq.'&s=100';
			}else{
			  $avatar = $host . $url . $hash . '?s=48' . '&r=' . $rating . '&d=mm';
			}       
            ?>
							  <div class="avatar"><img src="<?php echo $avatar ?>">
							  </div>
							  <div class="author-name">
								<b><?php $comments->author(); ?></b>
						<a href="javascript:void(0)" onclick="reply_comment(' <?php $comments->author('', false); ?>', '<?php $comments->sequence(); ?>')" class="reply">reply</a>
							  </div>
							  <div class="author-date"><small><?php $comments->date('Y-m-d H:i'); ?></small>
							  </div>
							</div>
							<div class="comment_content"><div class="p_part olfont"><p><?php $comments->content(); ?></p></div></div>
							<?php if ($comments->children) { ?>
							<?php $comments->threadedComments($options); ?>
							<?php } ?>
						  </div>
						</li>
<?php } ?>
<?php $this->comments()->to($comments); ?>
<?php if($this->allow('comment')): ?>
  <section id="comments">
  
                    <link href="<?php $this->options->themeUrl('css/comment.css'); ?>" type="text/css" rel="stylesheet"/>
                    <div class="doc_comments">
                        <div class="doc_comments_wrapper">
                            <div class="comments_block_title">发表评论</div>
                            <div class="new_comment_form_container">
                                <form id="new_comment_form" method="post" action="<?php $this->commentUrl() ?>">
                                   <?php if($this->user->hasLogin()): ?>
								   <div class="comment_trigger">
                                        <div class="avatar">
										<?php if($this->options->logoUrl): ?><img src="<?php $this->options->logoUrl();?>" alt="<?php $this->options->title() ?>" /><?php else : ?><img src="<?php $this->options->themeUrl('css/pic.png'); ?>"/><?php endif; ?>
                                        </div>
                                        <div class="trigger_title">撰写评论</div>
                                    </div>
                                    <div class="new_comment">
                                      <textarea   name="text" cols="50"  rows="2" class="textarea_box" required><?php $this->remember('text'); ?></textarea>
                                        <span class="comment_error"></span>
                                    </div>
                                    <div class="comment_triggered">
                                        <div class="input_body">
                                            <ul class="ident">
                                            </ul>
                                            <input type="submit" value="提交评论" class="comment_submit_button c_button"/>
											 <?php $security = $this->widget('Widget_Security'); ?>
									<input type="hidden" name="_" value="<?php echo $security->getToken($this->request->getReferer())?>">
                                        </div>
                                    </div>
								   <?php else: ?>
                                    <div class="comment_trigger">
                                        <div class="avatar">
                                            <img src="<?php $this->options->themeUrl('css/visitor.png'); ?>"/>
                                        </div>
                                        <div class="trigger_title">撰写评论</div>
                                    </div>
                                    <div class="new_comment">
                                      <textarea   name="text" cols="50"  rows="2" class="textarea_box" required><?php $this->remember('text'); ?></textarea>
                                        <span class="comment_error"></span>
                                    </div>
                                    <div class="comment_triggered">
                                        <div class="input_body">
                                            <ul class="ident">
                                                <li>
                                                    <input type="text" name="author"  value="<?php $this->remember('author'); ?>" required placeholder="昵称"/>
                                                </li>
                                                <li>
                                                    <input type="text" name="mail" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> placeholder="邮箱"/>
                                                </li>
                                                <li>
                                                    <input type="text" name="url" value="<?php $this->remember('url'); ?>" <?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> placeholder="网站"/>
                                                </li>
                                            </ul>
                                            <input type="submit" value="提交评论" class="comment_submit_button c_button"/>
											 <?php $security = $this->widget('Widget_Security'); ?>
									<input type="hidden" name="_" value="<?php echo $security->getToken($this->request->getReferer())?>">
                                        </div>
                                    </div>
									<?php endif; ?>
                                </form>
                            </div>
                            <ul class="comments">
							<?php if ($comments->have()): ?>
							<?php $comments->listComments(); ?>
							<?php endif; ?>
						 
						</ul>
					<script type="text/javascript" src="<?php $this->options->themeUrl('css/script.js'); ?>"></script> 					
                        </div>
                    </div>
                </section>
			<?php endif; ?>