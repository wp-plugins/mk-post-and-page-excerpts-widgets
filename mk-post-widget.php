<?php

/**
 * Adds MK_Post_Widget widget.
 */
class MK_Post_Widget extends WP_Widget {

  /**
   * Register widget with WordPress.
   */
  public function __construct() {
    parent::__construct(
            'mk_post_widget', // Base ID
            'MK Post Widget', // Name
            array('description' => __('A MK Post Widget', 'text_domain'),) // Args
    );
  }

  /**
   * Front-end display of widget.
   */
  public function widget($args, $instance) {
    global $post;
    extract($args);
    $mk_post_title = apply_filters('widget_title', $instance['mk_post_title']);
    $mk_post_select = $instance['mk_post_select'];
    $mk_post_show_title = $instance['mk_post_show_title'];
    $mk_post_show_content = $instance['mk_post_show_content'];
    $mk_post_content_length = $instance['mk_post_content_length'];
    $mk_post_show_img = $instance['mk_post_show_img'];
    $mk_post_align_img = $instance['mk_post_align_img'];
    $mk_post_img_size = $instance['mk_post_img_size']; 
    $mk_post_readmore = $instance['mk_post_readmore'];

    echo $before_widget;
    if (!empty($mk_post_title)) {
      echo $before_title . $mk_post_title . $after_title;
    }
    if (!empty($mk_post_select)) {
      $post = get_post($mk_post_select);

      if ($mk_post_show_img == 1) {
        echo '<div class="mk-post-featured-image mk-post-align-'.$mk_post_align_img.'"><a href="' . get_permalink($post->ID) . '" title="' . esc_attr($post->post_title) . '">';
        echo get_the_post_thumbnail($post->ID, $mk_post_img_size);
        echo '</a></div>';
      }

      if ($mk_post_show_title == 1) {
        echo '<h3 class="mk-post-title">' . $post->post_title . '</h3>';
      }

      if ($mk_post_show_content == 1) {
        echo '<p>' . $this->mk_post_excerpts($post->post_content, $mk_post_content_length) . "...</p>";
      }
      
      if(!empty($mk_post_readmore)){
        echo '<a href="' . get_permalink($post->ID) . '" title="' . esc_attr($post->post_title) . '" class="mk-post-readmore">'.$mk_post_readmore.'</a>';
      }else{
        echo '<a href="' . get_permalink($post->ID) . '" title="' . esc_attr($post->post_title) . '" class="mk-post-readmore">Read More...</a>';
      }
    }
    echo $after_widget;
  }

  /**
   * Sanitize widget form values as they are saved.
   */
  public function update($new_instance, $old_instance) {
    $instance = array();
    $instance['mk_post_title'] = strip_tags($new_instance['mk_post_title']);
    $instance['mk_post_select'] = $new_instance['mk_post_select'];
    $instance['mk_post_show_title'] = $new_instance['mk_post_show_title'];
    $instance['mk_post_show_content'] = $new_instance['mk_post_show_content'];
    $instance['mk_post_content_length'] = $new_instance['mk_post_content_length'];
    $instance['mk_post_show_img'] = $new_instance['mk_post_show_img'];
    $instance['mk_post_align_img'] = strip_tags($new_instance['mk_post_align_img']);
    $instance['mk_post_img_size'] = strip_tags($new_instance['mk_post_img_size']);    
    $instance['mk_post_readmore'] = strip_tags($new_instance['mk_post_readmore']);
    return $instance;
  }

  /**
   * Back-end widget form.
   */
  public function form($instance) {
    global $post;
    if (isset($instance['mk_post_title'])) {
      $mk_post_title = $instance['mk_post_title'];
    } else {
      $mk_post_title = __('MK Posts', 'text_domain');
    }
    if (isset($instance['mk_post_select'])) {
      $mk_post_select = $instance['mk_post_select'];
    } else {
      $mk_post_select = "";
    }
    if (isset($instance['mk_post_show_title'])) {
      $mk_post_show_title = $instance['mk_post_show_title'];
    } else {
      $mk_post_show_title = "1";
    }
    if (isset($instance['mk_post_show_content'])) {
      $mk_post_show_content = $instance['mk_post_show_content'];
    } else {
      $mk_post_show_content = "1";
    }
    if (isset($instance['mk_post_content_length'])) {
      $mk_post_content_length = $instance['mk_post_content_length'];
    } else {
      $mk_post_content_length = "300";
    }
    if (isset($instance['mk_post_show_img'])) {
      $mk_post_show_img = $instance['mk_post_show_img'];
    } else {
      $mk_post_show_img = "1";
    }
    if (isset($instance['mk_post_align_img'])) {
      $mk_post_align_img = $instance['mk_post_align_img'];
    } else {
      $mk_post_align_img = "";
    }    
    if (isset($instance['mk_post_img_size'])) {
      $mk_post_img_size = $instance['mk_post_img_size'];
    } else {
      $mk_post_img_size = "full";
    }
    
    if (isset($instance['mk_post_readmore'])) {
      $mk_post_readmore = $instance['mk_post_readmore'];
    } else {
      $mk_post_readmore = "Read More...";
    }
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('mk_post_title'); ?>"><?php _e('Title:'); ?></label> 
      <input class="widefat" id="<?php echo $this->get_field_id('mk_post_title'); ?>" name="<?php echo $this->get_field_name('mk_post_title'); ?>" type="text" value="<?php echo esc_attr($mk_post_title); ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('mk_post_select'); ?>"><?php _e('Select post:'); ?></label>
      <select class="widefat" name="<?php echo $this->get_field_name('mk_post_select'); ?>" id="<?php echo $this->get_field_id('mk_post_select'); ?>">
        <option value="">-- Select --</option>
        <?php
        $args = array('numberposts' => -1, 'orderby' => 'title');
        $posts = get_posts($args);
        foreach ($posts as $post) : setup_postdata($post);
          $selected = $post->ID == $mk_post_select ? 'selected="selected"' : '';
          ?>
          <option <?php echo $selected; ?> value="<?php echo $post->ID; ?>"><?php the_title(); ?></option>
        <?php endforeach; ?>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('mk_post_show_title'); ?>"><?php _e('Show post title:'); ?></label>
      <select class="widefat" name="<?php echo $this->get_field_name('mk_post_show_title'); ?>" id="<?php echo $this->get_field_id('mk_post_show_title'); ?>">
        <option value="1" <?php echo $mk_post_show_title == 1 ? 'selected="selected"' : ''; ?>>Yes</option>
        <option value="0" <?php echo $mk_post_show_title == 0 ? 'selected="selected"' : ''; ?>>No</option>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('mk_post_show_content'); ?>"><?php _e('Show post content:'); ?></label>
      <select class="widefat" name="<?php echo $this->get_field_name('mk_post_show_content'); ?>" id="<?php echo $this->get_field_id('mk_post_show_content'); ?>">
        <option value="1" <?php echo $mk_post_show_content == 1 ? 'selected="selected"' : ''; ?>>Yes</option>
        <option value="0" <?php echo $mk_post_show_content == 0 ? 'selected="selected"' : ''; ?>>No</option>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('mk_post_content_length'); ?>"><?php _e('Show post content length:'); ?></label>
      <input type="text" value="<?php echo esc_attr($mk_post_content_length); ?>" class="widefat" name="<?php echo $this->get_field_name('mk_post_content_length'); ?>" id="<?php echo $this->get_field_id('mk_post_content_length'); ?>"/>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('mk_post_show_img'); ?>"><?php _e('Show featured image:'); ?></label>
      <select class="widefat" name="<?php echo $this->get_field_name('mk_post_show_img'); ?>" id="<?php echo $this->get_field_id('mk_post_show_img'); ?>">
        <option value="1" <?php echo $mk_post_show_img == 1 ? 'selected="selected"' : ''; ?>>Yes</option>
        <option value="0" <?php echo $mk_post_show_img == 0 ? 'selected="selected"' : ''; ?>>No</option>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('mk_post_align_img'); ?>"><?php _e('Align featured image:'); ?></label>
      <select class="widefat" name="<?php echo $this->get_field_name('mk_post_align_img'); ?>" id="<?php echo $this->get_field_id('mk_post_align_img'); ?>">
        <option value="">-- Select --</option>
        <option value="left" <?php echo $mk_post_align_img == "left" ? 'selected="selected"' : ''; ?>>Left</option>
        <option value="right" <?php echo $mk_post_align_img == "right" ? 'selected="selected"' : ''; ?>>Right</option>
        <option value="center" <?php echo $mk_post_align_img == "center" ? 'selected="selected"' : ''; ?>>Center</option>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('mk_post_img_size'); ?>"><?php _e('Featured image size:'); ?></label>
      <select class="widefat" name="<?php echo $this->get_field_name('mk_post_img_size'); ?>" id="<?php echo $this->get_field_id('mk_post_img_size'); ?>">
        <option value="">-- Select --</option>
        <option value="thumbnail" <?php echo $mk_post_img_size == "thumbnail" ? 'selected="selected"' : ''; ?>>Thumbnail</option>
        <option value="medium" <?php echo $mk_post_img_size == "medium" ? 'selected="selected"' : ''; ?>>Medium</option>
        <option value="large" <?php echo $mk_post_img_size == "large" ? 'selected="selected"' : ''; ?>>Large</option>
        <option value="full" <?php echo $mk_post_img_size == "full" ? 'selected="selected"' : ''; ?>>Full</option>
      </select>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('mk_post_readmore'); ?>"><?php _e('Read more text:'); ?></label>
      <input type="text" value="<?php echo esc_attr($mk_post_readmore); ?>" class="widefat" name="<?php echo $this->get_field_name('mk_post_readmore'); ?>" id="<?php echo $this->get_field_id('mk_post_readmore'); ?>"/>
    </p>
    <p align="center"><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7N283YV4KLEQ2" title="Donate" target="_blank"><img src="https://www.paypalobjects.com/en_GB/i/btn/btn_donateCC_LG.gif" alt="Donate" title="Donate" /></a></p>
    <?php
  }

  /*
   * Function to get the excerpts of the post
   */

  public function mk_post_excerpts($content, $length = 300) {
    $tempStr = substr($content, 0, $length);
    return substr($tempStr, 0, strripos($tempStr, " "));
  }

}

// class MK_Post_Widget