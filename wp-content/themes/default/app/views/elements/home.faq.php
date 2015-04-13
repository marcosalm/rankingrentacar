<?php 
if ( !isset($limit) ) { $limit = 3; }

$faqs = Post::find(array(
	'post_type'      => 'faq',
	'post_status'    => 'publish',
	'posts_per_page' => $limit
));

if ( isset($faqs) && is_array($faqs) && count($faqs) > 0 ) :
	$i = 1;
?>
<div class="row fac">
	<div class="limit">
		<div class="grid g12">
			<?php foreach($faqs as $faq) : ?>
			<div class="container t4">
				<span class="num"><?php echo $i; ?></span>
				<div class="bx-fac">
					<h3><?php echo strtoupper( $faq->getTitle() ); ?></h3>
					<p><?php echo strip_tags( rk_limit_text($faq->getContent(), 18) ); ?></p>
					<a href="<?php echo $faq->getPermalink(); ?>">Saiba mais &raquo;</a>
				</div>
			</div>
			<?php $i++; endforeach; ?>
		</div>
	</div>
</div>
<?php endif; ?>