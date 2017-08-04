<?php
/**
 * Description Here
 *
 * @package     ${NAMESPACE}
 * @since       0.0.1
 * @author      Jeff Cleverley
 * @link        https://github.com/JeffCleverley/
 * @license     GNU General Public License 2.0+
 *
 */

$text_domain = FAQ_MODULE_TEXT_DOMAIN;

$help_header_first_list = __('Things to remember when adding or editing an FAQ:', $text_domain );
$help_item1 = __('Make sure you clearly explain the question and give content to why it might cause a problem for someone, if possible.', $text_domain );
$help_item2 = __('Clearly explain your answer, try to imagine how a user reading your answer might interpret it. Give examples where needed. Consider saving the FAQ as a draft and coming back to it later.', $text_domain );
$help_header_second_list = __('If you want to schedule the '. $custom_post_type_name . ' to be published in the future:', $text_domain );
$help_item4 =  __('Under the Publish module, click on the Edit link next to Publish.', $text_domain );
$help_item5 = __('Change the date to the date to actually publish the ' . $custom_post_type_name . ', then click on Ok.', $text_domain );
$header_more_information = __('For more information:', $text_domain );
$help_link = __('<a href="https//:github.com/JeffCleverley/CollapsibleContent" target="_blank">Collapsible Content Plugin Documentation</a>', $text_domain );

ob_start();
?>
	<div>
		<h3><?php echo $help_header_first_list ?></h3>
		<ul>
			<li><?php echo $help_item1 ?></li>
			<li><?php echo $help_item2 ?></li>
		</ul>
	</div>
	<div>
		<h4><?php echo $help_header_second_list ?></h4>
		<ul>
			<li><?php echo $help_item4 ?></li>
			<li><?php echo $help_item5 ?></li>
		</ul>
		<h4><?php echo $header_more_information ?></h4>
		<p><?php echo $help_link ?></p>
	</div>

<?php
$help_content = ob_get_clean();