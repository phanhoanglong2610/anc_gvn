		<ul class="pb-field-list">
<?php
		if($this->data['visualMode']==1)
		{
?>
			<li class="pb-clear-fix">
				<h5 class="pb-group-header"><?php esc_html_e('Enable plugin for new pages',PLUGIN_PAGE_BUILDER_DOMAIN); ?></h5>
				<span class="pb-group-subheader"><?php esc_html_e('Enable plugin by default for all new pages.',PLUGIN_PAGE_BUILDER_DOMAIN); ?></span>
				<div class="pb-clear-fix">
					<div class="pb-clear-fix pb-radio-button">
						<input type="radio" name="<?php PBHelper::getFormName('enable_page'); ?>" id="<?php PBHelper::getFormName('enable_page_1'); ?>" value="1" <?php echo PBHelper::returnIf($this->data['option']['enable_page'],1); ?>/>
						<label for="<?php PBHelper::getFormName('enable_page_1'); ?>"><?php esc_html_e('Enable',PLUGIN_PAGE_BUILDER_DOMAIN); ?></label>
						<input type="radio" name="<?php PBHelper::getFormName('enable_page'); ?>" id="<?php PBHelper::getFormName('enable_page_2'); ?>" value="0" <?php echo PBHelper::returnIf($this->data['option']['enable_page'],0); ?>/>
						<label for="<?php PBHelper::getFormName('enable_page_2'); ?>"><?php esc_html_e('Disable',PLUGIN_PAGE_BUILDER_DOMAIN); ?></label>
					</div>	
				</div>
			</li>
			<li class="pb-clear-fix">
				<h5 class="pb-group-header"><?php esc_html_e('Enable plugin for new posts',PLUGIN_PAGE_BUILDER_DOMAIN); ?></h5>
				<span class="pb-group-subheader"><?php esc_html_e('Enable plugin by default for all new posts.',PLUGIN_PAGE_BUILDER_DOMAIN); ?></span>
				<div class="pb-clear-fix">
					<div class="pb-clear-fix pb-radio-button">
						<input type="radio" name="<?php PBHelper::getFormName('enable_post'); ?>" id="<?php PBHelper::getFormName('enable_post_1'); ?>" value="1" <?php echo PBHelper::returnIf($this->data['option']['enable_post'],1); ?>/>
						<label for="<?php PBHelper::getFormName('enable_post_1'); ?>"><?php esc_html_e('Enable',PLUGIN_PAGE_BUILDER_DOMAIN); ?></label>
						<input type="radio" name="<?php PBHelper::getFormName('enable_post'); ?>" id="<?php PBHelper::getFormName('enable_post_2'); ?>" value="0" <?php echo PBHelper::returnIf($this->data['option']['enable_post'],0); ?>/>
						<label for="<?php PBHelper::getFormName('enable_post_2'); ?>"><?php esc_html_e('Disable',PLUGIN_PAGE_BUILDER_DOMAIN); ?></label>
					</div>	
				</div>
			</li>
<?php
		}
?>
		</ul>