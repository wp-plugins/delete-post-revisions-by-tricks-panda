<?php
/*
Plugin Name: Delete Post Revision
Plugin URI: http://www.trickspanda.com
Description: We created a tool which helps you to remove useless post revisions from your database.
Version: 1.0
Author: Hardeep Asrani
Author URI: http://www.hardeepasrani.com
*/
?>
<?php

if (!class_exists('TPPR_plugin'))
{
	class TPPR_plugin

	{
		public

		function __construct()
		{
			if (is_admin())
			{
				add_action('admin_menu', array(
					$this,
					'add_plugin_options_page'
				));
			}
		}

		public

		function add_plugin_options_page()
		{
			add_submenu_page('options-general.php', 'Delete Post Revisions', 'Delete Post Revisions', 'manage_options', 'tppr-settings-admin', array(
				$this,
				'create_admin_page'
			));
		}

		public

		function create_admin_page()
		{
?>
		<div class="wrap">
			<h2>Delete Post Revisions By Tricks Panda</h2>
			<p>We created a tool which helps you to remove useless post revisions from your database.</p>
			<form method="post" action="">
				<input type='submit' class='button button-primary' name='removeTPPR' value='Start'/>
			</form>			
			<p><?php
			global $wpdb;
			$myResOld = $wpdb->get_results("SELECT * FROM wp_posts WHERE post_type = 'revision'");
			$numTPPR = count($myResOld);
			if ($numTPPR > 0)
			{

				// print_r($myResOld);

					if (isset($_POST['removeTPPR']))
					{
					}
					else
					{
?><strong><?php
						echo $numTPPR
?></strong> post revision(s) found:<br /><?php
					}

				$i = 0;
				foreach($myResOld as $tpprObj)
				{
					if (isset($_POST['removeTPPR']))
					{
					}
					else
					{
						$i++;
						echo $i . ') ' . $tpprObj->wp_posts . ' ' . $tpprObj->post_title . '<br />';
					}
				}

				if (isset($_POST['removeTPPR']))
				{
					$myRes = $wpdb->get_results("DELETE FROM wp_posts WHERE post_type = 'revision'");
					$myResOld1 = $wpdb->get_results("SELECT * FROM wp_posts WHERE post_type = 'revision'");
					$numTPPR1 = count($myResOld1);
?><div id='setting-error-settings_updated' class='updated settings-error'><p><?php
					echo ($numTPPR - $numTPPR1) ?> old post revisions deleted.</p></div><?php
				}
			}
			else
			{
?>No post revisions found in database.<?php
			}

?></p>
			<?php
			$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']) , 'https') === FALSE ? 'http' : 'https';
			$host = $_SERVER['HTTP_HOST'];
			$script = $_SERVER['SCRIPT_NAME'];
			$params = $_SERVER['QUERY_STRING'];
			$currentUrl = $protocol . '://' . $host . $script . '?' . $params;
			echo '<p><a href="' . $currentUrl . '">Refresh list</a></p>';
?>
		</div>
		<?php
		}
	}
}

$TPPR_plugin = & new TPPR_plugin();