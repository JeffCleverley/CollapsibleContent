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

$help_header_first_list = __('Things to remember when adding or editing a Team Bio:', 'teambios');
$help_item1 = __('Include and be specific about the teams achievements.', 'teambios');
$help_item2 = __('Give examples of how the abilities and skillsets contained within the team - include brief details about appropriate context.', 'teambios');
$help_header_second_list = __('If you want to schedule the Team Bio to be published in the future:', 'teambios');
$help_item4 =  __('Under the Publish module, click on the Edit link next to Publish.', 'teambios');
$help_item5 = __('Change the date to the date to actual publish the Team Bio, then click on Ok.', 'teambios');
$header_more_information = __('For more information:', 'teambios');
$help_link = __('<a href="https//:github.com/JeffCleverley/TeamBios" target="_blank">Team Bios Plugin Documentation</a>', 'teambios');

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