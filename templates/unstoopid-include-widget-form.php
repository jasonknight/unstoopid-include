<p>
  <label for="<?php echo $self->get_field_id('title'); ?>">
    <?php _e('Title:'); ?>
  </label>
	<input class="widefat" id="<?php echo $self->get_field_id('title'); ?>" name="<?php echo $self->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>
<p>
  <label for="<?php echo $self->get_field_id('selector'); ?>">
    <?php _e('Partials:'); ?>
  </label>
  <select id="<?php echo $self->get_field_id('selector'); ?>" 
	       class="widefat"  
	       onChange="unstoopid_append_partial(this);">
	  <?php  foreach ( $partials as $partial ) { ?>
	    <option value="<?php echo $partial->ID ?>"> <?php echo $partial->post_title; ?></option>
	  <?php } // endforeach ?>
	</select>
	<script type="text/javascript">
	  if ( ! window.unstoopid_append_partial ) {
	    window.unstoopid_append_partial = function (sender) {
	      if (typeof jQuery != 'undefined') {
	        (function ($) {
	          var elem = $(sender);
	          var ta_id = elem.attr('id').replace('selector','text');
	          var area = $('#' + ta_id);
	          area.val( area.val() + '[unstoopid_include ids="' + elem.val() + '"]' + "\n");
	        })(jQuery);
	      } else {
	        alert('<?php echo __("You must have jQuery for auto append to work.","unstoopid_include") ?>');
	      }
	    }
	  }
	  
	</script>
</p>

<textarea class="widefat" rows="16" cols="20" id="<?php echo $self->get_field_id('text'); ?>" name="<?php echo $self->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

<p>
  <label for="<?php echo $self->get_field_id('show_title'); ?>">
    <?php _e('Show Title?'); ?>
  </label>
  <select id="<?php echo $self->get_field_id('show_title'); ?>" 
	       class="widefat"
	       name="<?php echo $self->get_field_name('show_title'); ?>" >
	  <option value="yes" <?php echo ($show_title == 'yes' ? 'selected="selected"' : '') ?>> <?php echo __('Yes','unstoopid_include'); ?> </option>
	  <option value="no" <?php echo ($show_title == 'no' ? 'selected="selected"' : '') ?>> <?php echo __('No','unstoopid_include'); ?> </option>  
	</select>
</p>


