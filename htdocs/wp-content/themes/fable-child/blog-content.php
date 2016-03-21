<?php
		global $post,$fable_parentPost;
		global $wp_query;

		//get category id (or name, slug) and store to the transient api
		$categoryId = $wp_query->queried_object->cat_ID;
		set_transient( 'category_id_visited', $categoryId, 1 * HOUR_IN_SECONDS );

		$Blog=new ThemeBlog();
		$Page=new ThemePage();
		$Post=new ThemePost();
		$Validation=new ThemeValidation();
		$WidgetArea=new ThemeWidgetArea();
		
		$widgetAreaData=$WidgetArea->getWidgetAreaByPost($fable_parentPost->post,true,true);

		$query=$Blog->getPost();
		$postCount=count($query->posts);

		if($postCount)
		{
?>
		<div class="theme-clear-fix">
			<div class="pb-header-subheader" style="display:none">
				<h2 class="pb-header">
					<span class="pb-header-content">
						<?php
						$title_cstm = get_post_meta(get_the_ID(), 'page-title-header', true);
						if($title_cstm != ''){
							echo $title_cstm;
						}
						else{
							echo "Kết qủa tìm kiếm";
						}
						?>
					</span>
				</h2>
				<h6 class="pb-subheader">
					<span class="pb-subheader-content">
						<?php echo get_post_meta(get_the_ID(), 'page-title-subheader', true); ?>
					</span>
				</h6>
				<div class="pb-header-underline">
				</div>
			</div>

			<ul class="theme-reset-list theme-clear-fix theme-blog">
<?php
			while($query->have_posts())
			{
				$query->the_post();
								
				$option=ThemeOption::getPostMeta($post);
				
				ThemeHelper::removeUIndex($option,'post_type');

				$visibleOption=array();

				if(get_post_type()=='post')
				{
					$visibleOption['post_tag_visible']=ThemeOption::getGlobalOption($post,'post_tag_visible');
					$visibleOption['post_author_visible']=ThemeOption::getGlobalOption($post,'post_author_visible');
					$visibleOption['post_category_visible']=ThemeOption::getGlobalOption($post,'post_category_visible');
					$visibleOption['post_comment_count_visible']=ThemeOption::getGlobalOption($post,'post_comment_count_visible') && comments_open(get_the_id());		
				}
?>
				<li id="post-<?php the_ID(); ?>" <?php post_class('theme-clear-fix theme-post theme-post-type-'.(is_sticky() ? 'sticky' : $option['post_type'])); ?>>
<?php
				$Post->formatPostDate($post->post_date,$day,$month,$year);
				$headerImportance=$widgetAreaData['location']==0 ? 2 : 4;
?>
					<div class="theme-post-section-header">
						<h<?php echo $headerImportance; ?> class="theme-post-header">
						<?php the_title(); ?>
						</h<?php echo $headerImportance; ?>>
<?php
				if(get_post_type()=='post')
				{
?>		
						<div class="theme-post-date">
							<a href="<?php echo get_month_link(get_the_time('Y'),get_the_time('m')); ?>" title="<?php echo sprintf(esc_attr__('Viev all posts from "%s %s"',THEME_DOMAIN),$month,$year); ?>">
								<?php echo get_the_date(); ?>
							</a>
						</div>
<?php
				}
?>	
					</div>
<?php
				if(get_post_type()=='post')
				{
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
					
					<div class="theme-post-section-preambule"><?php echo $preambule; ?></div>
<?php
						
							}
						
						break;
				
						default:
						
							if(has_post_thumbnail())
							{					
?>
					<div class="theme-post-section-icon">
						<div class="theme-post-icon theme-post-icon"></div>
					</div>
					
					<div class="theme-post-section-preambule">
						<div class="pb-image-box pb-image-preloader pb-image-preloader-animation-enable pb-image-hover pb-image-hover-type-fade">
							<a href="<?php the_permalink(); ?>" class="pb-image" title="<?php echo sprintf(esc_attr('Xem nội dung "%s"',THEME_DOMAIN),get_the_title()); ?>">
								<?php echo get_the_post_thumbnail(get_the_ID(),$Page->getImageClass($widgetAreaData['location'])); ?>
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
				}
				
				if(get_post_type()=='post')
				{
?>
					<div class="theme-post-section-header-cstm">
						<a href="<?php the_permalink(); ?>" title="<?php echo sprintf(esc_attr('Xem nội dung "%s"',THEME_DOMAIN),get_the_title()); ?>">
							<h6 class="theme-post-header">
								<?php the_title(); ?>
							</h6>
						</a>
						<a href="<?php the_permalink(); ?>" title="<?php echo sprintf(esc_attr('Xem nội dung "%s"',THEME_DOMAIN),get_the_title()); ?>">
							<div class="theme-post-section-content">
								<div class="theme-post-content">
									<?php the_excerpt(); ?>
								</div>
							</div>
						</a>
					</div>

<?php
				}
?>
					<div class="theme-post-section-button">
						<a href="<?php the_permalink(); ?>" class="theme-post-button-continue" title="<?php echo sprintf(esc_attr('Continue reading post "%s"',THEME_DOMAIN),get_the_title()); ?>"><?php esc_html_e('Continue reading',THEME_DOMAIN); ?><i class="pb-button-arrow pb-button-arrow-right"></i></a>
					</div>	
					
					<div class="theme-post-section-divider">
						<div class="theme-post-divider"></div>
					</div>

				</li>
<?php
			}
?>
			</ul>
			
			<div style="clear:both"></div>

			<?php echo $Blog->createPagination($query); ?>

		</div>
<?php
		}
		else echo do_shortcode('[pb_notice icon="bell_alt.png" icon_bg_color="FE6500"][pb_notice_first_line]'.__('Error',THEME_DOMAIN).'[/pb_notice_first_line][pb_notice_second_line]'.__('No post found.',THEME_DOMAIN).'[/pb_notice_second_line][/pb_notice]');