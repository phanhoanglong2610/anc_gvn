<?php
		global $post,$fable_parentPost;
		
		the_post();

		$Page=new ThemePage();
		$Post=new ThemePost();
		$Validation=new ThemeValidation();
		$WidgetArea=new ThemeWidgetArea();
		
		$widgetAreaData=$WidgetArea->getWidgetAreaByPost($fable_parentPost->post,true,true);
		
		$option=ThemeOption::getPostMeta($post);
		
		ThemeHelper::removeUIndex($option,'post_type');
		
		$visibleOption=array();

		$visibleOption['post_tag_visible']=ThemeOption::getGlobalOption($post,'post_tag_visible');
		$visibleOption['post_author_visible']=ThemeOption::getGlobalOption($post,'post_author_visible');
		$visibleOption['post_category_visible']=ThemeOption::getGlobalOption($post,'post_category_visible');
		$visibleOption['post_comment_count_visible']=ThemeOption::getGlobalOption($post,'post_comment_count_visible') && comments_open(get_the_id());	
		$visibleOption['post_navigation_visible']=ThemeOption::getGlobalOption($post,'post_navigation_visible');
?>
		<div <?php post_class('theme-clear-fix theme-post theme-post-type-'.(is_sticky() ? 'sticky' : $option['post_type'])); ?> id="post-<?php the_ID(); ?>">
<?php
		switch($option['post_type'])
		{
			case 'audio':
			case 'video':
			case 'image_slider':
						
				if($option['post_type']=='image_slider')
					$option['post_type_preambule']=preg_replace('/\[pb_nivo_slider/','[pb_nivo_slider url="'.get_permalink().'" ',$option['post_type_preambule']);

				$preambule=do_shortcode($option['post_type_preambule']);
				if($Validation->isNotEmpty($preambule))
				{
?>
			<div class="theme-post-section-icon">
				<div class="theme-post-icon"></div>
			</div>
					
			<div class="theme-post-section-preambule">
				<?php echo $preambule; ?>
			</div>
<?php
				}

			break;
				
			default:
						
				if(has_post_thumbnail())
				{		
					list($link)=wp_get_attachment_image_src(get_post_thumbnail_id(),'full');
?>
			<div class="theme-post-section-icon">
				<div class="theme-post-icon theme-post-icon"></div>
			</div>

			<div class="theme-post-section-preambule">
				<div class="pb-image-box pb-image-preloader pb-image-preloader-animation-enable pb-image-hover pb-image-hover-type-fade pb-image-type-image">
					<a href="<?php echo esc_attr($link); ?>" class="pb-image">
						<?php echo get_the_post_thumbnail(get_the_ID(),$Page->getImageClass($widgetAreaData['location'])); ?>
						<span><span><span></span></span></span>
					</a>
				</div>
			</div>
<?php				
				}						
		}

		if(in_array(true,$visibleOption))
		{
?>
			<div class="theme-post-section-meta">
						
				<div class="theme-post-meta">
<?php
			if($visibleOption['post_tag_visible']==1) echo $Post->createTagList();
			if($visibleOption['post_category_visible']==1) echo $Post->createCategoryList();
					
			if($visibleOption['post_author_visible']==1)
			{
?>
					<div class="theme-post-meta-author">
						<a href="<?php echo get_author_posts_url($post->post_author); ?>" title="<?php echo sprintf(esc_attr('View all posts from "%s"',THEME_DOMAIN),get_the_author()); ?>"><?php the_author(); ?></a>
					</div>
<?php
			}
			if($visibleOption['post_comment_count_visible']==1)
			{
?>
					<div class="theme-post-meta-comment-count"><a href="<?php the_permalink(); ?>#comments" title="<?php echo sprintf(esc_attr('View all comments from post "%s"',THEME_DOMAIN),get_the_title()); ?>"><?php comments_number(); ?></a></div>							
<?php
			}
?>
				</div>
					
			</div>
<?php
		}
?>
			<div class="theme-post-section-content">
				<div class="theme-post-content">
					<?php the_content(); ?>
				</div>
				<div class="theme-blog-pagination-box">
					<div class="theme-blog-pagination">
<?php 
				wp_link_pages(array
				(
					'before'		=>	null,
					'after'			=>	null,
					'link_before'	=> '<span>',
					'link_after'	=> '</span>'
				)); 
?>
					</div>
				</div>
			</div>
<?php
		if(comments_open())
		{
?>
			<div class="theme-post-section-button">
				<a href="<?php the_permalink(); ?>" class="theme-post-button-continue" id="theme-post-button-leave-a-reply" title="<?php echo sprintf(esc_attr('Leave a reply for post "%s"',THEME_DOMAIN),get_the_title()); ?>"><?php esc_html_e('Leave a reply',THEME_DOMAIN); ?><i class="pb-button-arrow pb-button-arrow-right"></i></a>
			</div>	
<?php
		}
		if($visibleOption['post_navigation_visible'])
		{
			$navigation=$Post->createPostNavigation();
			if($Validation->isNotEmpty($navigation))
			{
?>
			<div class="theme-post-section-navigation">
				<?php echo $navigation; ?>
			</div>
<?php
			}
		}
		
		if((comments_open()) && (!post_password_required()))
		{
?>
			<div id="comments">
				<?php comments_template(); ?>
			</div>
<?php
			$Comment=new ThemeComment();

			$commenter=wp_get_current_commenter();
			$req=get_option('require_name_email');
			$aria_req=($req ? ' aria-required=\'true\'' : '');

			$field=array();

			$field['author']=
			'
				<p class="theme-clear-fix">
					<label for="author" class="theme-infield-label">'.__('Name',THEME_DOMAIN).($req ? ' <span class="required">*</span>' : '').'</label>
					<input id="author" name="author" type="text" value="'.esc_attr($commenter['comment_author']).'" size="30"'.$aria_req.'/>
				</p>
			';

			$field['email']=
			'
				<p class="theme-clear-fix">
					<label for="email" class="theme-infield-label">'.__('Email',THEME_DOMAIN).($req ? ' <span class="required">*</span>' : '').'</label>
					<input id="email" name="email" type="text" value="'.esc_attr($commenter['comment_author_email']).'" size="30"'.$aria_req.'/>
				</p>
			';

			$field['url']=
			'
				<p class="theme-clear-fix">
					<label for="url" class="theme-infield-label">'.__('Website',THEME_DOMAIN).'</label>
					<input id="url" name="url" type="text" value="'.esc_attr($commenter['comment_author_url']).'" size="30"/>
				</p>
			';

			$commentField=
			'
				<p class="theme-clear-fix">
					<label for="comment" class="theme-infield-label">'.__('Comment',THEME_DOMAIN).' <span class="required">*</span></label>
					<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
				</p>	
			';

			$argument=array
			(
				'id_form'				=>	'comment-form',
				'title_reply'			=>	'<span class="pb-header-content">'.__('Leave Your Reply',THEME_DOMAIN).'</span>',
				'cancel_reply_link'		=>	__('Cancel reply',THEME_DOMAIN),
				'comment_field'			=>	$commentField,
				'fields'				=>	apply_filters('comment_form_default_fields',$field),
				'label_submit'			=>	__('Post comment',THEME_DOMAIN)
			);

			comment_form($argument); 
?>			
			<script type="text/javascript">
				jQuery(document).ready(function($) 
				{
					$().ThemeComment({'requestURL':'<?php echo admin_url('admin-ajax.php'); ?>','page':<?php echo $Comment->page; ?>});
				});
			</script>
<?php
		}
?>
		</div>