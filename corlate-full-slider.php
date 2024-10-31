<?php 
/**
Plugin Name: Responsive Slider
Plugin URI: https://goo.gl/mU32f7
Author: Mohammad Tajul Islam
Author URI: https://www.facebook.com/tajulislamdu
Version: 1.0.1
Description: Full Wide Slider
License: GPLv2 or later
Text Domain: comet
*/


defined('ABSPATH') or die("Get Lost from here, you idot");


Class corlate_full_slider{

	public function __construct(){

		

		// settings api
		add_action('admin_init', array($this, 'comet_settings_api'));

		// new menu for api settings
		 add_action('admin_menu', array($this, 'breaking_news_menu'));


		// custom metabox
		add_action('add_meta_boxes', array($this, 'corlate_slide_metabox'));

		add_action('save_post', array($this, 'corlate_slide_save'));
		

		// shortcode
		add_shortcode('corlate_full_slider', array($this, 'corlate_slide_shortcode'));


		// theme css and js files
		add_action('wp_enqueue_scripts', array($this, 'corlate_slide_files'));

		// header css
		 add_action('wp_head', array($this, 'slider_header_css'));



		// activate post_type: corlate_slider_cb_func
		add_action('init', array($this, 'corlate_slider_cb_func'));

		

	}


/**
*
*
*
* Settings Api Start Here
*
*
*
*
*/

public function comet_settings_api(){

/**
*
* Title section
*
*
*/
	add_settings_section('corlate_slider_color', 'Slider Color Section', array($this,'breaking_news_change_text_cb'), 'breaking_news_slug');


// slide bg color
	add_settings_field('corlate_slide_color', 'Slider Color', array($this, 'b_news_text_cb'), 'breaking_news_slug', 'corlate_slider_color');

	register_setting('corlate_slider_color', 'comet_breaking_news_common');


// slide bg hover color
	add_settings_field('corlate_slide_color_hover', 'Slider Hover Color', array($this, 'breaking_news_text_color_cb'), 'breaking_news_slug', 'corlate_slider_color');

	register_setting('corlate_slider_color', 'comet_breaking_news_common');



}


// section subtitle
public function breaking_news_change_text_cb(){
?>

<span>Change Slider Title Settings from here</span>
<a href="https://goo.gl/mU32f7">Video Instruction </a>

<?php
}


// change breaking news title
public function b_news_text_cb(){
	$options =(array)get_option('comet_breaking_news_common');
	$title = $options['corlate_slide_color'];
?>
	
	<input type="color" name="comet_breaking_news_common[corlate_slide_color]"  class="regular-text" value="<?php echo $title; ?>">

<?php 
}


// breaking news text color
public function breaking_news_text_color_cb(){
	$options = (array)get_option('comet_breaking_news_common');
	$slide_hover = $options['corlate_slide_color_hover'];
?>

<input type="color" name="comet_breaking_news_common[corlate_slide_color_hover]"  value="<?php echo $slide_hover; ?>" id="corlate_slide_color_hover"><br />


<?php 
}

// breaking news text background
public function b_text_bg_color(){
	$options = (array)get_option('comet_breaking_news_common');
	$bg_color = $options ['breaking_news_text_bg_color'];
?>

<input type="color" name="comet_breaking_news_common[breaking_news_text_bg_color]" id=""  value="<?php echo $bg_color; ?>">

<?php 
}


//
public function comet_news_cat_text_cb(){
	$options = (array) get_option('comet_breaking_news_common');
	$cat_text = $options['comet_new_cat_text'];
?>

<input type="text" name="comet_breaking_news_common[comet_new_cat_text]" 
value="<?php echo $cat_text; ?>" class="regular-text">

<?php 
}



/**
*
*
* menu for news options
*
*
*
*/
public function breaking_news_menu(){

	add_submenu_page('edit.php?post_type=corlate_slide', 'Slider Setting Options', 'Slider Options', 'manage_options', 'breaking_news_slug', array($this, 'breaking_news_cb') );

}

// callback
public function breaking_news_cb(){
?>
	<h1 style="text-align:center; color:green; margin:25px 0;">Slider Setting Options</h1>


	<form action="options.php" method="post">
			
	<?php echo do_settings_sections('breaking_news_slug'); ?>

	<?php echo settings_fields('corlate_slider_color'); ?>

		<?php echo submit_button(); ?>
	</form>
		<?php echo settings_errors(); ?>
<?php 
}




/**
*
*
*
* Settings api ends
*
*
*
*/

	// metabox callback function
	public function corlate_slide_metabox(){
		add_meta_box('corlate_slide_metabox_info', 'Corlate Slide Info', array($this, 'corlate_slide_metabox_cb'), 'corlate_slide', 'normal');

	}

	// metabox input form
	function corlate_slide_metabox_cb(){
		
	?>
	<p>
		<label for="slide_bg"><strong>Slide Background  Image Link :</strong></label> <br />
		<input type="text" name="slide_bg" id="slide_bg" class="widefat" value="<?php echo get_post_meta( get_the_ID(), 'slide_bg_image', true); ?>">
	</p>


	<p>
		<label for="news_content"><strong>Read More Text : </strong></label>
		<input type="text" name="news_content" id="news_content" class="widefat" value="<?php echo get_post_meta( get_the_ID(), 'b_news_content', true); ?> ">

	</p>


	<p>
		<label for="news_link"><strong> Read More Text Link :</strong></label>
		<input type="url" name="news_link" id="news_link" class="widefat" value="<?php echo get_post_meta( get_the_ID(), 'b_news_link', true); ?>">

	</p>
	<?php
	}

	// breaking news save
	public function corlate_slide_save(){

		$news_catagory = $_REQUEST['slide_bg']; 
		$news_content	= $_REQUEST['news_content'];
		$news_link	= $_REQUEST['news_link'];

		update_post_meta( get_the_ID(), 'slide_bg_image', $news_catagory);
		update_post_meta( get_the_ID(), 'b_news_content', $news_content);
		update_post_meta( get_the_ID(), 'b_news_link', $news_link);

	}

	// showing metadata in dashboard 




	// corlate slide shortcode
	public function corlate_slide_shortcode($atts, $content){

	$options = (array)get_option('comet_breaking_news_common');
	$bg_color = $options ['breaking_news_text_bg_color'];


	$bg_color = $options ['breaking_news_text_bg_color'];

		extract( shortcode_atts(array(
			'title_cat_color' => $bg_color,
		), $atts));

	ob_start();	
	?>	



	    <section id="main-slider" class="no-margin">
        <div class="carousel slide">
            <ol class="carousel-indicators">
                <li data-target="#main-slider" data-slide-to="0"></li>
                <li data-target="#main-slider" data-slide-to="1"></li>
                <li data-target="#main-slider" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">

			<?php 
			$q = new WP_Query(array(
				'post_type' => 'corlate_slide',
				'posts_per_page' => -1
			));
			
			while( $q->have_posts() ):$q->the_post();
			$bg_full_image = get_post_meta(get_the_ID(), 'slide_bg_image', true);
			$read_more_text = get_post_meta(get_the_ID(), 'b_news_content', true);
			$read_more_text_url = get_post_meta(get_the_ID(), 'b_news_link', true);

			?>
                <div class="item" style="background-image: url(<?php echo $bg_full_image; ?>)">
                    <div class="container">
                        <div class="row slide-margin">
                            <div class="col-sm-6">
                                <div class="carousel-content">
                                    <h1 class="animation animated-item-1"><?php the_title(); ?></h1>
                                    <h2 class="animation animated-item-2"><?php the_content(); ?></h2>
                                    <a class="btn-slide animation animated-item-3" href="<?php echo $read_more_text_url; ?>"><?php echo $read_more_text; ?></a>
                                </div>
                            </div>

                            <div class="col-sm-6 hidden-xs animation animated-item-4">
                                <div class="slider-img">
									<?php the_post_thumbnail('', array('class' => 'img-responsive') ); ?>
                                    
                                </div>
                            </div>

                        </div>
                    </div>
                </div><!--/.item-->
			<?php endwhile; ?>
        

            </div><!--/.carousel-inner-->
        </div><!--/.carousel-->
        <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
            <i class="fa fa-chevron-left"></i>
        </a>
        <a class="next hidden-xs" href="#main-slider" data-slide="next">
            <i class="fa fa-chevron-right"></i>
        </a>
    </section><!--/#main-slider-->


	<?php  return ob_get_clean();
	}





	// plugin all css and js files
	public function corlate_slide_files(){

		/**
		*
		* css files
		*
		*/		
		 wp_register_style('bootstrap', Plugins_url('/css/bootstrap.min.css', __FILE__), array(), '4.0.1', 'all');
		
		 wp_register_style('font-awesome', Plugins_url('/css/font-awesome.min.css', __FILE__), array(), '4.0.2', 'all');
		
		 wp_register_style('animate', Plugins_url('/css/animate.min.css', __FILE__ ), array(), '4.0.3', 'all');
		
		wp_register_style('corlate-slider', Plugins_url('/css/corlate-slider.css', __FILE__), array(), '4.0.4', 'all');
		
		
		
		
		wp_enqueue_style('bootstrap');
		wp_enqueue_style('font-awesome');
		wp_enqueue_style('animate'); 
		wp_enqueue_style('corlate-slider');


		/**
		*
		* js files
		*
		*/
	 wp_enqueue_script('bootstrap-js', Plugins_url('/js/bootstrap.min.js', __FILE__), array('jquery'), '5.0.1', true);
	

	wp_enqueue_script('corlate-slider-js', Plugins_url('/js/corlate-slider.js', __FILE__), array('jquery'), '5.0.2', true);
	
	  wp_enqueue_script('wow-js', Plugins_url('/js/wow.min.js', __FILE__), array('jquery'), '5.0.3', true);


	}


// header theme css
	public function slider_header_css(){

	$options = (array)get_option('comet_breaking_news_common');
	$bg_color = $options ['corlate_slide_color'];
	$slide_hover = $options['corlate_slide_color_hover'];
	?>

	<style>
	



#main-slider .prev, #main-slider .next {
  background-color: <?php echo $bg_color;?>;
  color: #ffffff;

}


html body #main-slider .prev:hover, #main-slider .next:hover {
  background-color: <?php echo $slide_hover; ?>;
}


html body #main-slider .carousel .btn-slide {
	background: <?php echo $bg_color;?> none repeat scroll 0 0;
	color: #ffffff;
}	


html body #main-slider .carousel .btn-slide:hover {
	background: <?php echo $slide_hover; ?> none repeat scroll 0 0; 
	color: #ffffff;
}


html body #main-slider .carousel-indicators .active::after {
  background: <?php echo $bg_color;?> none repeat scroll 0 0;
  border: 1px solid <?php echo $bg_color;?> ;
}

#main-slider .carousel h1 {
  color: #ffffff;
  font-size: 30px;
}

#main-slider .carousel h2 {
  color: #ffffff;
  font-size: 20px
}
		
		

	</style>


	<?php 
	}




	// callback function for post_type: corlate_slider_cb_func
	public function corlate_slider_cb_func(){
		
			// slider
	register_post_type('corlate_slide',array(
		'label' => 'Slides', 
		'labels' => array(
			'name' 				=> 'Slides',
			'singular_name' 	=> 'Slide',
			'menu_name' 		=> 'Slides', 
			'add_new' 			=> 'Add New Slide', 
			'add_new_item' 		=> 'Add New Slide', 
			'edit_item' 		=> 'Edit Slides', 
			'view_item' 		=> 'View Slide',
			'search_items' => 'Search Slide',
			'not_found' => 'No Slide Found',
			'not_found_in_trash' => 'No Slide Found in Trash'
		),
		'public' => true,
		'description' => 'Use me for Slide',
		'menu_position' => 5,
		'menu_icon' => 'dashicons-images-alt2',
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
	));
	

	}

}

$news = new corlate_full_slider();