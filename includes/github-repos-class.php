<?php
	class GR_Widget extends WP_Widget
	{
		function __construct()
		{
			parent::__construct(
				'gr_widget',
				__('Github Repos', 'gr'),
				[
					'description' => __('A WordPress plugin widget for fetching github repos', 'gr')
				]
			);
		}


		// Backend form
		public function form($instance)
		{
			if (isset($instance['title'])) {
				$title = $instance['title'];
			}else{
				$title = 'Github Repos';
			}

			if (isset($instance['username'])) {
				$username = $instance['username'];
			}else{
				$username = 'Cool-Programmer';
			}

			if (isset($instance['count'])) {
				$count = $instance['count'];
			}else{
				$count = 3;
			}
			?>
				<div class="gr-wrap">
					<p>
						<label for="<?php echo $this->get_field_id('title') ?>"><?php __('Title', 'gr'); ?></label>
						<input type="text" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>" id="<?php echo $this->get_field_id('title'); ?>">
					</p>

					<p>
						<label for="<?php echo $this->get_field_id('username') ?>"><?php __('Username', 'gr'); ?></label>
						<input type="text" class="widefat" name="<?php echo $this->get_field_name('username'); ?>" value="<?php echo esc_attr($username); ?>" id="<?php echo $this->get_field_id('username'); ?>">
					</p>

					<p>
						<label for="<?php echo $this->get_field_id('count') ?>"><?php __('Count', 'gr'); ?></label>
						<input type="text" class="widefat" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo esc_attr($count); ?>" id="<?php echo $this->get_field_id('count'); ?>">
					</p>
				</div>
			<?php
		}


		// Update data
		public function update($new_instance, $old_instance)
		{
			$instance = [
				'title' 	=> (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '',
				'username' 	=> (!empty($new_instance['username'])) ? strip_tags($new_instance['username']) : '',
				'count' 	=> (!empty($new_instance['count'])) ? strip_tags($new_instance['count']) : ''
			];

			return $instance;
		}



		// Frontend display
		public function widget($args, $instance)
		{
			$title = apply_filters('widget_title', $instance['title']);
			$username = esc_attr($instance['username']);
			$count = esc_attr($instance['count']);

			echo $args['before_widget'];
				if (!empty($title)) {
					echo $args['before_title'];
						echo $title;
					echo $args['after_title'];
				}

			echo $this->showRepos($title, $username, $count);

			echo $args['after_widget'];
		}

		private function showRepos($title, $username, $count)
		{
			$url = "https://api.github.com/users/" . $username . "/repos?sort=created&per_page=".$count;
			$options = [
				"http" => [
					"user_agent" => $_SERVER['HTTP_USER_AGENT']
				]
			];
			$context = stream_context_create($options);
			$response = file_get_contents($url, false, $context);

			$repos = json_decode($response);

			// Output
			$output = '<ul class="repos">';
				foreach ($repos as $repo) {
					$output .= '<li>';
						$output .= '<div class="repo-title">';
							$output .= $repo->name;
						$output .= '</div>';

						$output .= '<div class="repo-desc">';
							$output .= $repo->description;
						$output .= '</div>';
						
						$output .= '<a href="'.$repo->html_url.'" target="_blank">View on GitHub</a>';

				}
			$output .= '</ul>';
			return $output;
		}
	}