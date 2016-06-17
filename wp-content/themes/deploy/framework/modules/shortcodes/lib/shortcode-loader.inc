<?php

namespace Deploy\MikadofModules\Shortcodes\Lib;

use Deploy\MikadofModules\CallToAction\CallToAction;
use Deploy\MikadofModules\Counter\Countdown;
use Deploy\MikadofModules\Counter\Counter;
use Deploy\MikadofModules\ElementsHolder\ElementsHolder;
use Deploy\MikadofModules\ElementsHolderItem\ElementsHolderItem;
use Deploy\MikadofModules\GoogleMap\GoogleMap;
use Deploy\MikadofModules\Separator\Separator;
use Deploy\MikadofModules\PieCharts\PieChartDoughnut\PieChartDoughnut;
use Deploy\MikadofModules\PieCharts\PieChartPie\PieChartPie;
use Deploy\MikadofModules\PieCharts\PieChartWithIcon\PieChartWithIcon;
use Deploy\MikadofModules\PieCharts\PieChartBasic\PieChartBasic;
use Deploy\MikadofModules\Shortcodes\AnimationsHolder\AnimationsHolder;
use Deploy\MikadofModules\Shortcodes\BlogCarousel\BlogCarousel;
use Deploy\MikadofModules\Shortcodes\ComparisonPricingTables\ComparisonPricingTablesHolder;
use Deploy\MikadofModules\Shortcodes\Icon\Icon;
use Deploy\MikadofModules\Shortcodes\IconSlider\IconSlider;
use Deploy\MikadofModules\Shortcodes\IconSlider\IconSliderItem;
use Deploy\MikadofModules\Shortcodes\ImageGallery\ImageGallery;
use Deploy\MikadofModules\Shortcodes\ImageWithText\ImageWithText;
use Deploy\MikadofModules\Shortcodes\InfoBox\InfoBox;
use Deploy\MikadofModules\Shortcodes\InfoCardSlider\InfoCardSlider;
use Deploy\MikadofModules\Shortcodes\InfoCardSlider\InfoCardSliderItem;
use Deploy\MikadofModules\Shortcodes\ProcessCarousel\ProcessCarouselHolder;
use Deploy\MikadofModules\Shortcodes\ProcessCarousel\ProcessCarouselItem;
use Deploy\MikadofModules\Shortcodes\SectionTitle\SectionTitle;
use Deploy\MikadofModules\Shortcodes\ShapeSeparator\ShapeSeparator;
use Deploy\MikadofModules\Shortcodes\TabbedGallery\TabbedGalleryHolder;
use Deploy\MikadofModules\Shortcodes\TextSliderHolder\TextSliderHolder;
use Deploy\MikadofModules\Shortcodes\TextSliderItem\TextSliderItem;
use Deploy\MikadofModules\Shortcodes\VideoBanner\VideoBanner;
use Deploy\MikadofModules\Shortcodes\WorkingHours\WorkingHours;
use Deploy\MikadofModules\SocialShare\SocialShare;
use Deploy\MikadofModules\Team\Team;
use Deploy\MikadofModules\OrderedList\OrderedList;
use Deploy\MikadofModules\UnorderedList\UnorderedList;
use Deploy\MikadofModules\Message\Message;
use Deploy\MikadofModules\ProgressBar\ProgressBar;
use Deploy\MikadofModules\IconListItem\IconListItem;
use Deploy\MikadofModules\Tabs\Tabs;
use Deploy\MikadofModules\Tab\Tab;
use Deploy\MikadofModules\PricingTables\PricingTables;
use Deploy\MikadofModules\PricingTable\PricingTable;
use Deploy\MikadofModules\Accordion\Accordion;
use Deploy\MikadofModules\AccordionTab\AccordionTab;
use Deploy\MikadofModules\BlogList\BlogList;
use Deploy\MikadofModules\Shortcodes\Button\Button;
use Deploy\MikadofModules\Blockquote\Blockquote;
use Deploy\MikadofModules\CustomFont\CustomFont;
use Deploy\MikadofModules\Highlight\Highlight;
use Deploy\MikadofModules\VideoButton\VideoButton;
use Deploy\MikadofModules\Dropcaps\Dropcaps;
use Deploy\MikadofModules\Shortcodes\IconWithText\IconWithText;
use Deploy\MikadofModules\Shortcodes\TwitterSlider\TwitterSlider;
use Deploy\MikadofModules\Shortcodes\Process\Process;
use Deploy\MikadofModules\Shortcodes\TabbedGallery\TabbedGalleryItem;
use Deploy\MikadofModules\Shortcodes\ComparisonPricingTables\ComparisonPricingTable;

/**
 * Class ShortcodeLoader
 */
class ShortcodeLoader {
	/**
	 * @var private instance of current class
	 */
	private static $instance;
	/**
	 * @var array
	 */
	private $loadedShortcodes = array();

	/**
	 * Private constuct because of Singletone
	 */
	private function __construct() {}

	/**
	 * Private sleep because of Singletone
	 */
	private function __wakeup() {}

	/**
	 * Private clone because of Singletone
	 */
	private function __clone() {}

	/**
	 * Returns current instance of class
	 * @return ShortcodeLoader
	 */
	public static function getInstance() {
		if(self::$instance == null) {
			return new self;
		}

		return self::$instance;
	}

	/**
	 * Adds new shortcode. Object that it takes must implement ShortcodeInterface
	 * @param ShortcodeInterface $shortcode
	 */
	private function addShortcode(ShortcodeInterface $shortcode) {
		if(!array_key_exists($shortcode->getBase(), $this->loadedShortcodes)) {
			$this->loadedShortcodes[$shortcode->getBase()] = $shortcode;
		}
	}

	/**
	 * Adds all shortcodes.
	 *
	 * @see ShortcodeLoader::addShortcode()
	 */
	private function addShortcodes() {
		$this->addShortcode(new ElementsHolder());
		$this->addShortcode(new ElementsHolderItem());
		$this->addShortcode(new Team());
		$this->addShortcode(new Icon());
		$this->addShortcode(new CallToAction());
		$this->addShortcode(new OrderedList());
		$this->addShortcode(new UnorderedList());
		$this->addShortcode(new Message());
		$this->addShortcode(new Counter());
		$this->addShortcode(new Countdown());
		$this->addShortcode(new ProgressBar());
		$this->addShortcode(new IconListItem());
		$this->addShortcode(new Tabs());
		$this->addShortcode(new Tab());
		$this->addShortcode(new PricingTables());
		$this->addShortcode(new PricingTable());
		$this->addShortcode(new PieChartPie());
		$this->addShortcode(new PieChartDoughnut());
		$this->addShortcode(new PieChartWithIcon());
		$this->addShortcode(new PieChartBasic());
		$this->addShortcode(new Accordion());
		$this->addShortcode(new AccordionTab());
		$this->addShortcode(new BlogList());
		$this->addShortcode(new Button());
		$this->addShortcode(new Blockquote());
		$this->addShortcode(new CustomFont());
		$this->addShortcode(new Highlight());
		$this->addShortcode(new ImageGallery());
		$this->addShortcode(new GoogleMap());
		$this->addShortcode(new Separator());
		$this->addShortcode(new VideoButton());
		$this->addShortcode(new Dropcaps());
		$this->addShortcode(new IconWithText());
		$this->addShortcode(new SocialShare());
		$this->addShortcode(new TwitterSlider());
		$this->addShortcode(new Process());
		$this->addShortcode(new BlogCarousel());
		$this->addShortcode(new ShapeSeparator());
		$this->addShortcode(new TextSliderHolder());
		$this->addShortcode(new TextSliderItem());
		$this->addShortcode(new InfoCardSlider());
		$this->addShortcode(new InfoCardSliderItem());
		$this->addShortcode(new IconSlider());
		$this->addShortcode(new IconSliderItem());
		$this->addShortcode(new AnimationsHolder());
		$this->addShortcode(new ImageWithText());
		$this->addShortcode(new SectionTitle());
		$this->addShortcode(new VideoBanner());
		$this->addShortcode(new ProcessCarouselHolder());
		$this->addShortcode(new ProcessCarouselItem());
		$this->addShortcode(new TabbedGalleryHolder());
		$this->addShortcode(new TabbedGalleryItem());
		$this->addShortcode(new InfoBox());
		$this->addShortcode(new WorkingHours());
		$this->addShortcode(new ComparisonPricingTablesHolder());
		$this->addShortcode(new ComparisonPricingTable());
	}
	/**
	 * Calls ShortcodeLoader::addShortcodes and than loops through added shortcodes and calls render method
	 * of each shortcode object
	 */
	public function load() {
		$this->addShortcodes();

		foreach ($this->loadedShortcodes as $shortcode) {
			add_shortcode($shortcode->getBase(), array($shortcode, 'render'));
		}

	}
}

$shortcodeLoader = ShortcodeLoader::getInstance();
$shortcodeLoader->load();