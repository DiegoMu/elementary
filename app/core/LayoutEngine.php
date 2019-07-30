<?php 
	namespace App\Core;
	use Symfony\Component\Yaml\Yaml;
	use Symfony\Component\Yaml\Exception\ParseException;

	class LayoutEngine extends Core
	{
		private $theme_settings;
		private $layout;

		public function __construct()
		{
			$this->message_handler = new MessageHandler();
			$this->setConfig();
			$this->setThemeConfig();
			$this->setLayout();
		}
		public function loadTheme()
		{
			$site_name 	= $this->config['site_name'];
			$resources 	= $this->prepareResources();
			$regions 	= $this->prepareLayout();
			$container_class = $this->theme_settings['layout']['container_class'];
			include(APP_ROOT . '/app/themes/' . strtolower($this->theme_settings['name']) . '/' . strtolower($this->theme_settings['name']) . '.page.php');
		}

		public function prepareResources() : array
		{
			$resourses_to_load = array();
			$resourses = $this->arraySortByField($this->theme_settings['require'], 'load_order');

			foreach ($resourses as $resource) {
				if ($resource['public']) {
					if (isset($resource['js'])) {
						foreach ($resource['js'] as $js_resource) {
							$js_resource = explode('/', $js_resource);
							$resourses_to_load['js'][] = '/resources/' .$resource['name'] . '/js/' . end($js_resource);
						}
					}
					if (isset($resource['css'])) {
						foreach ($resource['css'] as $css_resource) {
							$css_resource = explode('/', $css_resource);
							$resourses_to_load['css'][] = '/resources/' .$resource['name'] . '/css/' . end($css_resource);
						}
					}
				}
			}

			foreach ($this->theme_settings['jscirpts'] as $jscirpts) {
				$resourses_to_load['js'][] = '/resources/' . $this->theme_settings['jscripts_directory'] . '/' . $jscirpts;
			}

			foreach ($this->theme_settings['styleshets'] as $styleshet) {
				$resourses_to_load['css'][] = '/resources/' . $this->theme_settings['css_directory'] . '/' .$styleshet;
			}

			return $resourses_to_load;
		}

		public function setThemeConfig(){
			$theme = $this->config['theme']['active_theme'];
			try {
				$this->theme_settings = Yaml::parseFile(APP_ROOT . '/app/themes/' . strtolower($theme). '/settings.yaml');
			} catch (ParseException $e){
				$this->message_handler->setMessage('FNF01','Critical Error', $e->getMessage(), $e->getTraceAsString());
				$this->message_handler->printMessage();
				exit();
			}
		}

		public function setLayout(): void
		{
			foreach ($this->theme_settings['layout']['regions'] as $region) {
				$this->layout['regions'][$region['name']]['content'] = '';
				$this->layout['regions'][$region['name']]['display'] = true;
				$this->layout['regions'][$region['name']]['template'] = false;
			}
		}
		public function prepareLayout() : array
		{
			$regions_to_render = array();
			$regions = $this->arraySortByField($this->theme_settings['layout']['regions'], 'render_order');
			$c  = 0;
			foreach ($regions as $region) {
				if ($this->layout['regions'][$region['name']]['display']) {
					$regions_to_render[$c] = $region; 
					$regions_to_render[$c]['content'] = $this->layout['regions'][$region['name']]['content'];
					$regions_to_render[$c]['template'] = $this->layout['regions'][$region['name']]['template'];
					$c++;
				}
			}
			return $regions_to_render;
		}

		public function setRegion($region_name, $content, $config = array('display' => true), $template): void
		{
			$this->layout['regions'][$region_name]['content'] = $content;
			$this->layout['regions'][$region_name]['display'] = $config['display'];
			$this->layout['regions'][$region_name]['template'] = $template;
		}
		
		public function renderRegion($data, $template){
			if($template)
				include(APP_ROOT . '/app/themes/' . strtolower($this->theme_settings['name']) . '/' .$this->theme_settings['template_directoy'] . '/' . strtolower($this->theme_settings['name']). '.' . $template . '.page.php');
			else
				print ($data);
		}
	}