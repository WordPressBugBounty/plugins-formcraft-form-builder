<?php
defined( 'ABSPATH' ) or die( 'Cheating, huh?' );
global $fcb_version, $wpdb, $forms_table;
// phpcs:ignore
$form_id = intval($_GET['id']);
$qry = $wpdb->get_results( $wpdb->prepare("SELECT * FROM %s WHERE id = %d", $forms_table, $form_id));
?>
<input type='hidden' id='form_id' value='<?php echo esc_attr($form_id); ?>'>
<?php wp_nonce_field( 'formcraft' ); ?>
<div ng-app='FormCraft'>
	<div class='formcraftbasic-css' ng-controller='FormController' ng-init='AngularInit()'>
		<div class='options-head'>
			<a href='admin.php?page=formcraft_basic_dashboard' class='button blue options-head-button'><i class='fcb-icon'>keyboard_arrow_left</i>Dashboard</a>
			<div class='add_fields'>
				<button class='button blue options-head-button icon-{{Options.show_fields}}' ng-click='Options.show_fields = !Options.show_fields'><i class='icon-angle-down fcb-icon'>keyboard_arrow_down</i><i class='icon-angle-up fcb-icon'>keyboard_arrow_up</i><?php esc_html_e('Add Field','formcraft_basic') ?></button>
				<div ng-show='Options.show_fields' class='ng-hide'>
					<div ondragstart="drag(event)" ondragend="dragEnd(event)" dnd-draggable class='button' ng-click='addFormElement("oneLineText")'><?php esc_html_e('One Line Input','formcraft_basic') ?></div>
					<div ondragstart="drag(event)" ondragend="dragEnd(event)" dnd-draggable class='button' ng-click='addFormElement("email")'><?php esc_html_e('Email Input','formcraft_basic') ?></div>
					<div ondragstart="drag(event)" ondragend="dragEnd(event)" dnd-draggable class='button' ng-click='addFormElement("textarea")'><?php esc_html_e('Comment Box','formcraft_basic') ?></div>
					<div ondragstart="drag(event)" ondragend="dragEnd(event)" dnd-draggable class='button' ng-click='addFormElement("checkbox")'><?php esc_html_e('Checkboxes','formcraft_basic') ?></div>
					<div ondragstart="drag(event)" ondragend="dragEnd(event)" dnd-draggable class='button' ng-click='addFormElement("dropdown")'><?php esc_html_e('Dropdown','formcraft_basic') ?></div>
					<div ondragstart="drag(event)" ondragend="dragEnd(event)" dnd-draggable class='button' ng-click='addFormElement("datepicker")'><?php esc_html_e('Datepicker','formcraft_basic') ?></div>
					<div ondragstart="drag(event)" ondragend="dragEnd(event)" dnd-draggable class='button' ng-click='addFormElement("customText")'><?php esc_html_e('Custom Text','formcraft_basic') ?></div>
					<div ondragstart="drag(event)" ondragend="dragEnd(event)" dnd-draggable class='button' ng-click='addFormElement("submit")'><?php esc_html_e('Submit','formcraft_basic') ?></div>
					<div class='premium-fields'>
						<div class='button'>Premium <i class='fcb-icon'>keyboard_arrow_right</i></div>
						<div class='premium-fields-list'>
							<button class='button'>Password</button>
							<button class='button'>File Upload</button>
							<button class='button'>Slider</button>
							<button class='button'>Timepicker</button>
							<button class='button'>Star Rating</button>
							<button class='button'>Smiley Rating</button>
							<button class='button'>Choice Matrix</button>
							<button class='button'>reCaptcha</button>
						</div>
					</div>
				</div>
			</div>
			<div>
				<button class='button blue options-head-button active-{{Builder.Config.showOptions}}' ng-click='Builder.Config.showOptions = !Builder.Config.showOptions; Builder.Config.showLogic = false'>
					<i class='fcb-icon'>settings</i> <?php esc_html_e('Settings','formcraft_basic') ?>
				</button>
			</div>
			<div>
				<button class='button blue options-head-button active-{{Builder.Config.showLogic}}' ng-click='Builder.Config.showLogic = !Builder.Config.showLogic; Builder.Config.showOptions = false'>
					<i class='fcb-icon'>shuffle</i> <?php esc_html_e('Logic','formcraft_basic') ?>
				</button>
			</div>				
			<div>
				<button style='width: 128px; height: 3.1em' id='form_save_button' ng-click='saveForm()' class='button blue options-head-button'><span class='fcb-spinner small'><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></span><span class='one'><i class='fcb-icon'>cloud_upload</i> <?php esc_html_e('Save Form','formcraft_basic') ?></span></button>
			</div>
			<div>
				<button type='submit' ng-click='saveForm("preview")' id='form_preview_button' class='button blue options-head-button'><i class='fcb-icon'>open_in_new</i> <?php esc_html_e('Preview','formcraft_basic') ?></button>
			</div>
		</div>
		<div class='promo-head'>
			<a data-toggle='fcbmodal' data-target='#upgrade_modal'  class='button blue options-head-button'><i class='fcb-icon'>star</i> <?php esc_html_e('Premium Features','formcraft_basic') ?></a>
		</div>
		<div class='form-cover-builder hide-form'>
			<span class='fcb-spinner fcb-spinner-form small'><div class='bounce1'></div><div class='bounce2'></div><div class='bounce3'></div></span>
			<div id='form-cover-html' class='nos-{{Builder.FormElements.length}}' style='width: {{Builder.form_width_nos}}px'>
				<!--RFH-->
				<div class='no-fields' ng-click='Options.show_fields = true'><?php esc_html_e('+ Add a Field','formcraft_basic'); ?></div>
				<div style='width: {{Builder.form_width}}' class='form_width_change'><span><?php esc_html_e('Width','formcraft_basic') ?></span><input ng-model='Builder.form_width' type='text'/><i data-html='true' data-toggle='tooltip' title='<?php esc_html_e('You should use a value like <Strong>300px</strong>, or <Strong>420px</strong> here.<br>You can also define a percent based width, like <strong>50%</strong>, which will set the width of the form to 50% the width of its container. ','formcraft_basic') ?>' class='fcb-icon'>help</i></div>
				<!--RTH--><form ondrop="drop(event)" ondragover="allowDrop(event)" dnd-list='Builder.FormElements' data-id='<?php echo esc_attr($form_id); ?>' class='fcb_form align-{{Builder.form_align}} frame-{{Builder.form_frame}}' style='width: {{Builder.form_width}}; background-color: {{Builder.form_background}}; color: {{Builder.font_color}}; font-size: {{Builder.font_size}}%'><div ng-class-odd="'odd'" ng-class='["form-element", "form-element-"+element.elementDefaults.identifier, "options-"+element.show_options, "index-"+element.show_options]' ng-class-even="'even'" ng-repeat='element in Builder.FormElements' index='{{$index}}' style='width: {{element.elementDefaults.field_width}}'><span class='error'></span><div ng-click='element.show_options = !element.show_options' class='form-element-html' compile='element.element'></div><!--RFH--><span class='options-panel' ondragstart="dragStart(event)" dnd-draggable='element' ondrag="setHeight(event)" dnd-moved='Builder.FormElements.splice($index, 1);' ondragend='removeAnimate()'><i class='fcb-icon drag-icon'>drag_handle</i></span><div ng-show='element.show_options' class='form-options'><div class='sub-options'><div title='Field ID'>{{element.elementDefaults.identifier}}</div><span title='Delete Field' ng-click='removeFormElement($index)' class='delete'><i class='fcb-icon'>add_circle</i></span><span title='Duplicate Field' ng-click='duplicateFormElement($index)' class='duplicate'><i class='fcb-icon'>add_circle</i></span></div><div class='options-main' compile='element.elementOptions'></div></div><!--RTH--></div></form>
			</div>
		</div>

		<div class='side-panel'>
			<div style='width: 500px' class='side-panel-one form-options' ng-show='Builder.Config.showOptions'>
				<div class='side-panel-header'>
					<div class='side-panel-header-title'><?php esc_html_e('Settings','formcraft_basic'); ?></div>
					<nav class='nav-tabs' data-content='#options_tabs'>
						<span class='active'><?php esc_html_e('Styling','formcraft_basic'); ?></span>
						<span><?php esc_html_e('Notifications','formcraft_basic'); ?></span>
						<span><?php esc_html_e('Embed','formcraft_basic'); ?></span>
						<span><?php esc_html_e('Others','formcraft_basic'); ?></span>
					</nav>
				</div>
				<div class='side-panel-content'>
					<div id='options_tabs' class='nav-content'>
						<div class='active'>
							<div class='group'>
								<div class='group-title'>
									<?php esc_html_e('Form Styling','formcraft_basic'); ?>
								</div>
								<div>
									<span class='option-label'><?php esc_html_e('Form Background','formcraft_basic'); ?></span>
									<input type="text" value="#fff" class="color-picker" ng-model='Builder.form_background'>
								</div>
								<div>
									<span class='option-label'><?php esc_html_e('Font Size','formcraft_basic'); ?></span>
									<button class='button' ng-click='Builder.font_size = Builder.font_size + 5'>+</button>
									<button class='button' ng-click='Builder.font_size = Builder.font_size - 5'>-</button>
									&nbsp; {{Builder.font_size}}%
								</div>
								<div>
									<span class='option-label'><?php esc_html_e('Font Color','formcraft_basic'); ?></span>
									<input type="text" value="#fff" class="color-picker" ng-model='Builder.font_color'>
								</div>
								<div>
									<label>
										<span class='option-label'>Form Frame</span>
										<input type='checkbox' ng-model='Builder.form_frame' ng-true-value='"hidden"' ng-false-value='"visible"'> <?php esc_html_e('Remove','formcraft_basic'); ?>
									</label>
								</div>
							</div>
						</div>
						<div>
							<div class='group'>
								<div class='group-title'>
									<?php esc_html_e('Email Recipients','formcraft_basic'); ?>
								</div>
								<div>
									<span class='option-label'><?php esc_html_e('Send Emails To','formcraft_basic'); ?></span>
									<input type="text" placeholder="dan@example.com, joe@example.com" ng-model='Builder.Config.Email.recipients' style='width: 300px'>
								</div>
							</div>
							<div class='group'>
								<div class='group-title'>
									<?php esc_html_e('Email Settings','formcraft_basic'); ?>
								</div>
								<div>
									<span class='option-label'><?php esc_html_e('From Email','formcraft_basic'); ?></span>
									<input type="text" placeholder="john@example.com" ng-model='Builder.Config.Email.email_from' style='width: 300px'>
									<span class='tooltip-cover'><i data-html='true' class='fcb-icon tooltip-icon' data-toggle='tooltip' title='This will set the From Email address for the email notifications.<br>You can use an email here, like joe@example.com, or you can populate this with a form value, using the field ID:<br><strong>[field2]</strong>'>help</i></span>
								</div>
								<div>
									<span class='option-label'><?php esc_html_e('From Name','formcraft_basic'); ?></span>
									<input type="text" placeholder="John Doe" ng-model='Builder.Config.Email.name_from' style='width: 300px'>
									<span class='tooltip-cover'><i data-html='true' class='fcb-icon tooltip-icon' data-toggle='tooltip' title='This will set the From Name address for the email notifications.<bR>You can use a name here, like John Doe, or you can populate this with a form value, using the field ID:<br><strong>[field3]</strong>'>help</i></span>
								</div>
								<div>
									<span class='option-label'><?php esc_html_e('Email Subject','formcraft_basic'); ?></span>
									<input type="text" placeholder="New Form Submission" ng-model='Builder.Config.Email.subject' style='width: 300px'>
									<span class='tooltip-cover'><i data-html='true' class='fcb-icon tooltip-icon' data-toggle='tooltip' title='You can use form values here, using their field ID: <strong>[field1]</strong>'>help</i></span>
								</div>
							</div>
						</div>
						<div>
							<div class='group'>
								<div class='group-title'>
									<?php esc_html_e('Dedicated Form Page','formcraft_basic'); ?>
								</div>
								<div>
									<span class='option-label'><?php esc_html_e('Form Link','formcraft_basic'); ?></span>
									<textarea onclick='select()' style='width: 350px' rows='1' class='copy-code' readonly><?php echo esc_url(get_site_url().'/form/'.$form_id); ?></textarea>
								</div>
								<div>
									<span class='option-label'><?php esc_html_e('Public Access','formcraft_basic'); ?></span>
									<label><input type='checkbox' ng-model='Builder.Config.disable_form_link'/> Disable</label>
								</div>
							</div>
							<div class='group'>
								<div class='group-title'>
									<?php esc_html_e('Using Shortcode','formcraft_basic'); ?>
								</div>
								<div>
									<span class='option-label'><?php esc_html_e('Form Alignment','formcraft_basic'); ?></span>
									<label><input type='radio' ng-model='temp_align' name='temp_form_align' value='left'><?php esc_html_e('Left','formcraft_basic'); ?></label>&nbsp;
									<label><input type='radio' ng-model='temp_align' name='temp_form_align' value='center'><?php esc_html_e('Center','formcraft_basic'); ?></label>&nbsp;
									<label><input type='radio' ng-model='temp_align' name='temp_form_align' value='right'><?php esc_html_e('Right','formcraft_basic'); ?></label>
								</div>
								<div>
									<span class='option-label'><?php esc_html_e('Shortcode','formcraft_basic'); ?></span>
									<textarea onclick='select()' style='width: 350px' rows='1' class='copy-code' readonly>[fcb id='<?php echo esc_attr($form_id); ?>' align='{{temp_align}}'][/fcb]</textarea>
								</div>
							</div>
						</div>
						<div>
							<div class='group'>
								<div class='group-title'>
									<?php esc_html_e('Export Form','formcraft_basic'); ?>
								</div>
								<div>
									<a target='_blank' href='<?php echo esc_url(get_site_url()); ?>?formcraft_export_form=<?php echo esc_attr($form_id); ?>' class='button'><?php esc_html_e('Export Form File','formcraft_basic'); ?></a>
									<p class='description'>
										You can import this form template on any other WordPress site with the plugin installed.
									</p>
								</div>
							</div>
							<div class='group'>
								<div class='group-title'>
									<?php esc_html_e('Custom Messages','formcraft_basic'); ?>
								</div>
								<div>
									<span class='option-label'><?php esc_html_e('Form Sent','formcraft_basic'); ?></span>
									<input type='text' ng-model='Builder.Config.messages.form_sent' style="width: 365px">
								</div>
								<div>
									<span class='option-label'><?php esc_html_e('Validation Errors','formcraft_basic'); ?></span>
									<input type='text' ng-model='Builder.Config.messages.form_errors' style="width: 365px">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div style='width: 580px' class='side-panel-one form-logic' ng-show='Builder.Config.showLogic'>
				<div class='side-panel-header'>
					<div class='side-panel-header-title'>
						Conditional Logic
					</div>
				</div>
				<div class='side-panel-content'>
					<div class='fcb-locked'>
						<img src='<?php echo esc_url(plugins_url( '../assets/images/logic.png', __FILE__ )); ?>'/>
						<div class='fcb-lockribbon'></div>
						<a target='_blank' href='http://codecanyon.net/item/formcraft-premium-wordpress-form-builder/5335056?ref=ncrafts&source=basic' class='fcb-lock'><i class='fcb-icon'>lock_outline</i>get FormCraft Premium</a>
						<a class='fcb-lock-footer' target='_blank' href='http://formcraft-wp.com/?source=basic'>learn about other features</a>
					</div>					
				</div>
			</div>
		</div>
		<div class="fcbmodal fcbfade" id="upgrade_modal">
			<div class="fcbmodal-dialog">
				<div class="fcbmodal-content">
					<div class="fcbmodal-header">
						<h4 class="fcbmodal-title"><?php esc_html_e('What\'s in FormCraft Premium','formcraft_basic') ?></h4>
						<button class='fcbclose' type="button" class="close" data-dismiss="fcbmodal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
								<div class="fcbmodal-body" style="height: 420px; overflow: auto; padding: 10px 20px">
				<ol>
					<li>
						<h2><?php esc_html_e('Conditional Logic','formcraft_basic'); ?></h2>
						<p><?php esc_html_e('Use conditional logic to show / hide fields, set email recipients, or custom redirection URLs.','formcraft_basic'); ?></p>
					</li>
					<li>
						<h2><?php esc_html_e('Math Logic','formcraft_basic'); ?></h2>
						<p><?php esc_html_e('Use our live updating math logic to make order and quote forms','formcraft_basic'); ?></p>
					</li>
					<li>
						<h2><?php esc_html_e('Save Form Progress','formcraft_basic'); ?></h2>
						<p><?php esc_html_e('Automatically save your users\'s form data as they type in, allowing them to resume the form later on.','formcraft_basic'); ?></p>
					</li>
					<li>
						<h2><?php esc_html_e('20+ Form Fields','formcraft_basic'); ?></h2>
						<p><?php esc_html_e('Choose from over 20+ form fields, including emoticon rating, thumb-rating, star rating, matrix, image, captcha, etc ...','formcraft_basic'); ?></p>
					</li>
					<li>
						<h2><?php esc_html_e('Accept File Uploads','formcraft_basic'); ?></h2>
						<p><?php esc_html_e('Add a multi-file upload field, allow your users to upload files.','formcraft_basic'); ?></p>
					</li>
					<li>
						<h2><?php esc_html_e('Add-Ons','formcraft_basic'); ?></h2>
						<p><?php esc_html_e('Dozens of downlodable add-ons, including multi-page forms, PayPal, Stripe, user registration, form to post, MailChimp, Campaign Monitor, etc ...','formcraft_basic'); ?></p>
						<a target='_blank' href='http://formcraft-wp.com/addons/?source=basic'>read more</a>
					</li>
					<li>
						<h2><?php esc_html_e('Payments','formcraft_basic'); ?></h2>
						<p><?php esc_html_e('Use our payment add-ons (Stripe, PayPal ...) and create beautiful payment forms for your site.','formcraft_basic'); ?></p>
					</li>
					<li>
						<h2><?php esc_html_e('Popup Forms','formcraft_basic'); ?></h2>
						<p><?php esc_html_e('Embed forms on your site as popup, slide-in, or inline forms.','formcraft_basic'); ?></p>
					</li>
					<li>
						<h2><?php esc_html_e('Free Templates','formcraft_basic'); ?></h2>
						<p><?php esc_html_e('Dozens of free form templates bundled with the plugin. More with each add-on.','formcraft_basic'); ?></p>
					</li>
					<li>
						<h2><?php esc_html_e('Export Data','formcraft_basic'); ?></h2>
						<p><?php esc_html_e('Export all your submissions for a spreadsheet.','formcraft_basic'); ?></p>
					</li>
					<li>
						<h2><?php esc_html_e('Auto-responders','formcraft_basic'); ?></h2>
						<p><?php esc_html_e('Send personalized auto-responders to users who fill your form. Customize all the email content of auto-responders.','formcraft_basic'); ?></p>
					</li>
					<li>
						<h2><?php esc_html_e('Analytics','formcraft_basic'); ?></h2>
						<p><?php esc_html_e('Get form analytics inside the WordPress dashboard','formcraft_basic'); ?></p>
					</li>
					<li>
						<h2><?php esc_html_e('Documentation and Support','formcraft_basic'); ?></h2>
						<p><?php esc_html_e('Get access to our online documentation, and get free support in case you run into an issue.','formcraft_basic'); ?></p>
					</li>
				</ol>
			<a style='display: block; text-align: right; padding: 10px; font-size: 13px; padding-right: 8px; color: #48e; text-decoration: none' href='http://formcraft-wp.com/?source=basic' target='_blank'/>read more about FormCraft Premium</a>				
			</div>
			<div class='fcbmodal-footer'>
				<a class='button blue' target='_blank' href='http://codecanyon.net/item/formcraft-premium-wordpress-form-builder/5335056?ref=ncrafts&source=basic'><?php esc_html_e('Get FormCraft Premium','formcraft_basic'); ?> <i class='fcb-icon' style='position: relative; right: -5px'>keyboard_arrow_right</i></a>
			</div>
		</div>
			</div>
		</div>
	</div>
</div>
<?php

?>