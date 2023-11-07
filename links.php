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
                    <!-- 友情链接优化 -->
                    <input type="radio" name="tab" id="link_info" class="reward_none" checked="">
                    <input type="radio" name="tab" id="link_friend" class="reward_none">

                    <div class="link_tab">
                            <div class="link_tab_list">
                                <label for="link_info"><span class="douban_option_info">友链说明</span></label>
                                <label for="link_friend"><span class="douban_option_friend">友情链接</span></label>
                            </div>
                    </div>

                    <div class="links_body_friend links reward_none">
                        <div class ="links-body">
                            <?php if(isPluginAvailable('Links')) {
                                Links_Plugin::output('<a href="{url}" target="_blank" title="{title}" class="links-item" no-linkTarget>
                                    <div class="links-content">
                                        <section class="links-avatar">
                                            <img src="{image}"class="links-img" />
                                        </section>
                                        <section class="links-profile">
                                            <h4 class="links-name">{name}</h4>
                                            <!-- <p class="links-description">{title}</p> 这个是站点描述想要的就把这段注释删掉-->
                                        </section>
                                    </div>
                                </a>'); }
                                else {
                                    echo 'Links 插件未启用，若要使用友情连接功能，请安装并启用 Links 插件。';
                                }?>
                        </div>
                    </div>
                    
                        <div class="meta-links">
                                <?php $this->content(); ?> 
                        </div>
                    
                </div>
                    
                </article>
                <section class="pager">
                </section>
                
            </main>
        </div>

        <style>
        /* links 友情链接优化 */
        article.content .meta-links, section.content .meta-links {
                border-bottom: 0;
                padding: 20px 0 38px 0%;
            }
        .links-item {
            display: inline-block;
            padding: .6em;
            border-radius: 5px;
            width: 30%;
            margin: .2em 0;
            box-sizing: border-box
            transition: box-shadow 0.5s ease-out;
        }

        .links-item:hover {
            transition: box-shadow 0.5s ease-out;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            }
        @media (max-width: 1200px) {
            .links-item {
                width: 33.33%
            }
        }
        @media (max-width: 674px) {
            .links-item {
                width: 50%
            }
        }@media (max-width: 478px) {
            .links-item {
                width: 100%
            }
        }

        .links-item:hover {
            background: var(--light-bg)
        }

        .links-content {
            display: flex;
            flex-direction: row;
            color: var(--text-color);
            align-items: center;
            /* border: 2px solid #ccc; */
            border-radius: 7px;
        }

        .links-img {
            height: 3.6em;
            width: 3.6em;
            transition: transform .3s;
            border-radius: 20%;
            max-width: fit-content
        }
        .links-item:hover .links-img {
            transform: scale(1.05)
        }

        .links-profile {
            margin-left: 1.8em;
            line-height: 1.2;
            padding: .2em 0
        }
        .links-profile h4 {
            margin: 0;
            font-weight: 400;
            font-size: 0.9em;
        }
        .links-profile p {
            margin: 0;
            color: var(--text-gray);
            font-size: .9em;
            line-height: 1.1;
            margin-top: .4em;
        }
        .links-container {
            clear: both;
            width: 100%;
            margin: 2em 0;
        }
        .links-body {
            padding: 20px;
        }

        .link_tab{
            text-align: center;
            margin-bottom: 2rem;
            margin-top: 2rem;
        }
        .link_tab_list{
            display: initial;
            padding: 10px 12px;
            border-radius: 100px;
            font-size: 14px;
            color: #17223b;
            background-color: #eeeeff;
        }
        .link_tab_list span {
            display: block;
            display: inline-block;
            padding: 0px 10px;
            cursor: pointer;
            border-radius: 100px;
        }
        h4.links-name {
            padding:0 0% !important;
        }
        h4.links-name:before {
            content: "#"!important;
            color: #555;
        }
        #link_info:checked ~ .link_body, #link_friend:checked ~ .links_body_friend,  .links_body_circle{
            display: block;
        }

        .reward_none {
            display: none;
        }
        #link_info:checked ~ .link_tab label[for="link_info"] span, #link_friend:checked ~ .link_tab label[for="link_friend"] span {
            background: #fff;
        }

        .links {
            width:100%; 
            padding:10px;
            float:initial; 
        }
</style>
<?php $this->need('footer.php'); ?>