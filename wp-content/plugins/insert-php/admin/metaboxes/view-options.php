<?php

class WINP_ViewOptionsMetaBox extends Wbcr_FactoryMetaboxes404_Metabox {

	/**
	 * A visible title of the metabox.
	 *
	 * Inherited from the class FactoryMetabox.
	 * @link http://codex.wordpress.org/Function_Reference/add_meta_box
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $title;

	/**
	 * The priority within the context where the boxes should show ('high', 'core', 'default' or 'low').
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_meta_box
	 * Inherited from the class FactoryMetabox.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $priority = 'core';

	public $css_class = 'factory-bootstrap-410 factory-fontawesome-000';

	protected $errors = array();
	protected $source_channel;
	protected $facebook_group_id;
	protected $paginate_url;

	public function __construct($plugin)
	{
		parent::__construct($plugin);

		$this->title = __('Conditional execution logic for the snippet', 'insert-php');
	}

	/**
	 * Configures a metabox.
	 *
	 * @since 1.0.0
	 * @param Wbcr_Factory410_ScriptList $scripts A set of scripts to include.
	 * @param Wbcr_Factory410_StyleList $styles A set of style to include.
	 * @return void
	 */
	public function configure($scripts, $styles)
	{
		$styles->add(WINP_PLUGIN_URL . '/admin/assets/css/view-opt.css');

		$scripts->add(WINP_PLUGIN_URL . '/admin/assets/js/view-opt.js');
	}

	/**
	 * Prints visibility conditions
	 */
	function printVisibilityConditions()
	{
		// filter parameters
		$groupedFilterParams = array(
			array(
				'id' => 'user',
				'title' => __('User', 'insert-php'),
				'items' => array(
					array(
						'id' => 'user-role',
						'title' => __('Role', 'insert-php'),
						'type' => 'select',
						'values' => array(
							'type' => 'ajax',
							'action' => 'wbcr_inp_ajax_get_user_roles'
						),
						'description' => __('A role of the user who views your website. The role "guest" is applied to unregistered users.', 'insert-php')
					),
					array(
						'id' => 'user-registered',
						'title' => __('Registration Date', 'insert-php'),
						'type' => 'date',
						'description' => __('The date when the user who views your website was registered. For unregistered users this date always equals to 1 Jan 1970.', 'insert-php')
					),
					array(
						'id' => 'user-mobile',
						'title' => __('Mobile Device', 'insert-php'),
						'type' => 'select',
						'values' => array(
							array('value' => 'yes', 'title' => __('Yes', 'insert-php')),
							array('value' => 'no', 'title' => __('No', 'insert-php'))
						),
						'description' => __('Determines whether the user views your website from mobile device or not.', 'insert-php')
					),
					array(
						'id' => 'user-cookie-name',
						'title' => __('Cookie Name', 'insert-php'),
						'type' => 'text',
						'onlyEquals' => true,
						'description' => __('Determines whether the user\'s browser has a cookie with a given name.', 'insert-php')
					)
				)
			),
			/*array(
				'id' => 'session',
				'title' => __('Session', 'insert-php'),
				'items' => array(
					array(
						'id' => 'session-pageviews',
						'title' => __('Total Pageviews', 'insert-php'),
						'type' => 'integer',
						'description' => sprintf(__('The total count of pageviews made by the user within one\'s current session on your website. You can specify a duration of the sessions <a href="%s" target="_blank">here</a>.', 'insert-php'), admin_url('edit.php?post_type=' . WINP_SNIPPETS_POST_TYPE))
					),
					array(
						'id' => 'session-locker-pageviews',
						'title' => __('Locker Pageviews', 'insert-php'),
						'type' => 'integer',
						'description' => sprintf(__('The count of views of pages where lockers located, made by the user within one\'s current session on your website. You can specify a duration of the sessions <a href="%s" target="_blank">here</a>.', 'insert-php'), admin_url('edit.php?post_type=' . WINP_SNIPPETS_POST_TYPE))
					),
					array(
						'id' => 'session-landing-page',
						'title' => __('Landing Page', 'insert-php'),
						'type' => 'text',
						'description' => sprintf(__('A page of your website from which the user starts one\'s current session. You can specify a duration of the sessions <a href="%s" target="_blank">here</a>.', 'insert-php'), admin_url('edit.php?post_type=' . WINP_SNIPPETS_POST_TYPE))
					),
					array(
						'id' => 'session-referrer',
						'title' => __('Referrer', 'insert-php'),
						'type' => 'text',
						'description' => sprintf(__('A referrer URL which has brought the user to your website within the user\'s current session. You can specify a duration of the sessions <a href="%s" target="_blank">here</a>.', 'insert-php'), admin_url('edit.php?post_type=' . WINP_SNIPPETS_POST_TYPE))
					)
				)
			),*/
			array(
				'id' => 'location',
				'title' => __('Location', 'insert-php'),
				'items' => array(
					array(
						'id' => 'location-page',
						'title' => __('Current Page', 'insert-php'),
						'type' => 'text',
						'description' => __('An URL of the current page where a user who views your website is located.', 'insert-php')
					),
					array(
						'id' => 'location-referrer',
						'title' => __('Current Referrer', 'insert-php'),
						'type' => 'text',
						'description' => __('A referrer URL which has brought a user to the current page.', 'insert-php')
					),
					array(
						'id' => 'location-post-type',
						'title' => __('Post type', 'insert-php'),
						'type' => 'select',
						'values' => array(
							'type' => 'ajax',
							'action' => 'wbcr_inp_ajax_get_post_types'
						),
						'description' => __('A post type of the current page.', 'insert-php')
					),
					array(
						'id' => 'location-taxonomy',
						'title' => __('Taxonomy', 'insert-php'),
						'type' => 'select',
						'values' => array(
							'type' => 'ajax',
							'action' => 'wbcr_inp_ajax_get_taxonomies'
						),
						'description' => __('A taxonomy of the current page.', 'insert-php')
					),
					array(
						'id' => 'location-some-page',
						'title' => __('Page', 'insert-php'),
						'type' => 'select',
						'values' => array(
							'type' => 'ajax',
							'action' => 'wbcr_inp_ajax_get_page_list'
						),
						'description' => __('List of specific pages.', 'insert-php')
					)
				)
			),
			/*array(
				'id' => 'post',
				'title' => __('Post', 'insert-php'),
				'items' => array(
					array(
						'id' => 'post-published',
						'title' => __('Publication Date', 'insert-php'),
						'type' => 'date',
						'description' => __('The publication date of a post where a user who views your website is located currently.', 'insert-php')
					)
				)
			),*/
		);

		$groupedFilterParams = apply_filters('wbcr/inp/visibility/filter_params', $groupedFilterParams);

		$filterParams = array();
		foreach($groupedFilterParams as $filterGroup) {
			$filterParams = array_merge($filterParams, $filterGroup['items']);
		}

		// templates
		$templates = array(
			array(
				'id' => 'hide_for_members',
				'title' => __('[Hide For Members]: Show the locker only for guests', 'insert-php'),
				'filter' => array(
					'type' => 'showif',
					'conditions' => array(
						array(
							'type' => 'condition',
							'param' => 'user-role',
							'operator' => 'equals',
							'value' => 'guest'
						)
					)
				)
			),
			array(
				'id' => 'mobile',
				'title' => __('[Hide On Mobile]: Hide the locker on mobile devices', 'insert-php'),
				'filter' => array(
					'type' => 'hideif',
					'conditions' => array(
						array(
							'type' => 'condition',
							'param' => 'user-mobile',
							'operator' => 'equals',
							'value' => 'yes'
						)
					)
				)
			),
			array(
				'id' => 'delayed_lock',
				'title' => __('[Delayed Lock]: Show the locker only in posts older than 5 days', 'insert-php'),
				'filter' => array(
					'type' => 'showif',
					'conditions' => array(
						array(
							'type' => 'condition',
							'param' => 'post-published',
							'operator' => 'older',
							'value' => array(
								'type' => 'relative',
								'unitsCount' => 5,
								'units' => 'days'
							)
						)
					)
				)
			)
		);

		$templates = apply_filters('wbcr/inp/visibility/filter_templates', $templates);
		?>
        <div class="factory-fontawesome-000 winp-advanded-options">
            <div class="winp-empty" id="winp-advanced-visability-options">
                <script>
                    window.winp = window.winp || {};
                    window.winp.filtersParams = <?php echo json_encode( $filterParams ) ?>;
                    window.winp.templates = <?php echo json_encode( $templates ) ?>;
                </script>
                <div class="winp-editor-wrap">
                    <div class="winp-when-empty">
                        <?php _e('No filters specified. <a href="#" class="winp-add-filter">Click here</a> to add one.', 'insert-php') ?>
                    </div>
                    <div class="winp-filters"></div>
                </div>
                <div class="winp-filter winp-template">
                    <div class="winp-point"></div>
                    <div class="winp-head">
                        <div class="winp-left">
                            <span style="margin-left: 0;">
                                <strong><?php _e('Show IF', 'insert-php') ?>:</strong>
                            </span>
                            <select class="winp-filter-type">
                                <option value="showif"><?php _e('Display On IF', 'insert-php'); ?></option>
                                <option value="hideif"><?php _e('Do Not Display IF', 'insert-php'); ?></option>
                            </select>
                            <span><?php _e('or', 'insert-php') ?></span>
                            <a href="#" class="button btn-remove-filter">x</a>
                        </div>
                        <?php /*
                        <div class="winp-templates winp-right">
                            <span><strong><?php _e('Template', 'insert-php') ?></strong></span>
                            <select class="winp-select-template">
                                <option><?php _e('- select a template -', 'insert-php') ?></option>
                                <?php foreach($templates as $template) { ?>
                                    <option value="<?php echo $template['id'] ?>"><?php echo $template['title'] ?></option>
                                <?php } ?>
                            </select>
                            <a href="#" class="button winp-btn-apply-template"><?php _e('Apply', 'insert-php') ?></a>
                        </div>
                        */ ?>
                    </div>
                    <div class="winp-box">
                        <div class="winp-when-empty">
                            <?php _e('No conditions specified. <a href="#" class="winp-link-add">Click here</a> to add one.', 'insert-php') ?>
                        </div>
                        <div class="winp-conditions"></div>
                    </div>
                </div>
                <div class="winp-scope winp-template">
                    <div class="winp-and"><span><?php _e('and', 'insert-php') ?></span></div>
                </div>
                <div class="winp-condition winp-template">
                    <div class="winp-or"><?php _e('or', 'insert-php') ?></div>
                    <span class="winp-params">
                        <select class="winp-param-select">
                            <?php foreach($groupedFilterParams as $filterParam) { ?>
                                <optgroup label="<?php echo $filterParam['title'] ?>">
                                    <?php foreach($filterParam['items'] as $param) { ?>
                                        <option value="<?php echo $param['id'] ?>">
                                            <?php echo $param['title'] ?>
                                        </option>
                                    <?php } ?>
                                </optgroup>
                            <?php } ?>
                        </select>
                        <i class="winp-hint">
                            <span class="winp-hint-icon"></span>
                            <span class="winp-hint-content"></span>
                        </i>
                    </span>

                    <span class="winp-operators">
                        <select class="winp-operator-select">
                            <option value="equals"><?php _e('Equals', 'insert-php') ?></option>
                            <option value="notequal"><?php _e('Doesn\'t Equal', 'insert-php') ?></option>
                            <option value="greater"><?php _e('Greater Than', 'insert-php') ?></option>
                            <option value="less"><?php _e('Less Than', 'insert-php') ?></option>
                            <option value="older"><?php _e('Older Than', 'insert-php') ?></option>
                            <option value="younger"><?php _e('Younger Than', 'insert-php') ?></option>
                            <option value="contains"><?php _e('Contains', 'insert-php') ?></option>
                            <option value="notcontain"><?php _e('Doesn\'t Сontain', 'insert-php') ?></option>
                            <option value="between"><?php _e('Between', 'insert-php') ?></option>
                        </select>
                    </span>
                    <span class="winp-value"></span>

                    <span class="winp-controls">
                        <div class="button-group">
                            <a href="#" class="button button-sm button-default winp-btn-remove">-</a>
                            <a href="#" class="button button-sm button-default winp-btn-or"><?php _e('OR', 'insert-php') ?></a>
                            <a href="#" class="button button-sm button-default winp-btn-and"><?php _e('AND', 'insert-php') ?></a>
                        </div>
                    </span>
                </div>
                <div class="winp-date-control winp-relative winp-template">
                    <div class="winp-inputs">
                        <div class="winp-between-date">
                            <div class="winp-absolute-date">
                                <span class="winp-label"> <?php _e('from', 'insert-php') ?> </span>

                                <div class="winp-date-control winp-date-start" data-date="today">
                                    <input size="16" type="text" readonly="readonly" class="winp-date-value-start" data-date="today"/>
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <span class="winp-label"> <?php _e('to', 'insert-php') ?> </span>

                                <div class="winp-date-control winp-date-end" data-date="today">
                                    <input size="16" type="text" readonly="readonly" class="winp-date-value-end" data-date="today"/>
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <div class="winp-relative-date">
                                <span class="winp-label"> <?php _e('older than', 'insert-php') ?> </span>
                                <input type="text" class="winp-date-value winp-date-value-start" value="1"/>
                                <select class="winp-date-start-units">
                                    <option value="seconds"><?php _e('Second(s)', 'insert-php') ?></option>
                                    <option value="minutes"><?php _e('Minutes(s)', 'insert-php') ?></option>
                                    <option value="hours"><?php _e('Hours(s)', 'insert-php') ?></option>
                                    <option value="days"><?php _e('Day(s)', 'insert-php') ?></option>
                                    <option value="weeks"><?php _e('Week(s)', 'insert-php') ?></option>
                                    <option value="months"><?php _e('Month(s)', 'insert-php') ?></option>
                                    <option value="years"><?php _e('Year(s)', 'insert-php') ?></option>
                                </select>
                                <span class="winp-label"> <?php _e(', younger than', 'insert-php') ?> </span>
                                <input type="text" class="winp-date-value winp-date-value-end" value="2"/>
                                <select class="winp-date-end-units">
                                    <option value="seconds"><?php _e('Second(s)', 'insert-php') ?></option>
                                    <option value="minutes"><?php _e('Minutes(s)', 'insert-php') ?></option>
                                    <option value="hours"><?php _e('Hours(s)', 'insert-php') ?></option>
                                    <option value="days"><?php _e('Day(s)', 'insert-php') ?></option>
                                    <option value="weeks"><?php _e('Week(s)', 'insert-php') ?></option>
                                    <option value="months"><?php _e('Month(s)', 'insert-php') ?></option>
                                    <option value="years"><?php _e('Year(s)', 'insert-php') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="winp-solo-date">
                            <div class="winp-absolute-date">
                                <div class="winp-date-control" data-date="today">
                                    <input size="16" type="text" class="winp-date-value" readonly="readonly" data-date="today"/>
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <div class="winp-relative-date">
                                <input type="text" class="winp-date-value" value="1"/>
                                <select class="winp-date-value-units">
                                    <option value="seconds"><?php _e('Second(s)', 'insert-php') ?></option>
                                    <option value="minutes"><?php _e('Minutes(s)', 'insert-php') ?></option>
                                    <option value="hours"><?php _e('Hours(s)', 'insert-php') ?></option>
                                    <option value="days"><?php _e('Day(s)', 'insert-php') ?></option>
                                    <option value="weeks"><?php _e('Week(s)', 'insert-php') ?></option>
                                    <option value="months"><?php _e('Month(s)', 'insert-php') ?></option>
                                    <option value="years"><?php _e('Year(s)', 'insert-php') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="winp-switcher">
                        <label><input type="radio" checked="checked" value="relative"/>
                            <span><?php _e('relative', 'insert-php') ?></span></label>
                        <label><input type="radio" value="absolute"/>
                            <span><?php _e('absolute', 'insert-php') ?></span>
                        </label>
                    </div>
                </div>
                <!--div class="wrap">
                    <button type="button" class="button button-default winp-add-filter winp-btn-left">
                        <?php //_e('Add new condition', 'insert-php') ?>
                    </button>
                </div-->
                <?php $changed_filters = get_post_meta( get_the_ID(), WINP_Plugin::app()->getPrefix() . 'changed_filters', true ); ?>
                <input id="winp_changed_filters" name="wbcr_inp_changed_filters" value="<?php echo empty( $changed_filters ) ? 0 : 1 ?>" type="hidden" />
                <input id="winp_visibility_filters" name="wbcr_inp_snippet_filters"
                       value='<?php echo json_encode( get_post_meta( get_the_ID(), WINP_Plugin::app()->getPrefix() . 'snippet_filters' ) ) ?>'
                       type="hidden" />
            </div>
        </div>
		<?php
	}

	/**
	 * html
	 */
	public function html()
	{
		$this->printVisibilityConditions();
	}

}