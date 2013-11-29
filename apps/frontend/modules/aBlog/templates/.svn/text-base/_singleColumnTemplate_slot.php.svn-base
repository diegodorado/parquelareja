<?php include_partial('aBlog/post_header', array('a_blog_post' => $aBlogPost)) ?>
<?php $options['excerptLength'] = 50?>
<div class="a-blog-item-excerpt-container">
	<div class="a-blog-item-excerpt">
		<?php echo $aBlogPost->getTextForArea('blog-body', $options['excerptLength']) ?>
	</div>
  <div class="a-blog-read-more">
    <?php echo link_to('Leer Más', 'a_blog_post', $aBlogPost, array('class' => 'a-blog-more')) ?>
  </div>
</div>
