<?php

class MikadoHtmlDeployWidget extends DeployMikadoWidget {
	public function __construct() {
		parent::__construct(
			'mkdf_html_widget', // Base ID
			'Mikado Raw HTML' // Name
		);

		$this->setParams();
	}

	protected function setParams() {
		$this->params = array(
			array(
				'name'        => 'html',
				'type'        => 'textarea',
				'title'       => 'Raw HTML'
			)
		);
	}

	public function widget($args, $instance) {
		print $args['before_widget']; ?>
		<div class="mkdf-html-widget">
			<?php print $instance['html']; ?>
		</div>
		<?php print $args['after_widget'];
	}

}