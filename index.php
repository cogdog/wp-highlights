<?php 

	get_header(); 
	
	// store custom CSS for backgrounds
	$section_css = '';

	// custom query for posts listed by menu order
	
	$the_query = new WP_Query(array(
		'post_type' => 'post', 
		'post_status' => 'publish', 
		'orderby' => 'menu_order', 
		'order' => 'ASC',
		'posts_per_page' => 10,
	) );

	// First Loop for the nav and extra CSS
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
		
			$the_query->the_post();
			
			// make unique div ids, stash in array
			$my_id = 'post' . get_the_id();
			$the_divs[] = $my_id;
				
		} // while 
		
		// rewind so we can reuse for the content
		$the_query->rewind_posts();
		
	} // $the_query->have_posts()
	?>


		<h1 class="single-title"><?php highlights_intro_header()?></h1>
		<div class="subtitle">
			<?php highlights_intro_blurb()?>
		</div>
	</header>
	<div class="container">
		<ul class="actions">
			<li><a href="#<?php echo $the_divs[0]?>" class="button special scrolly">Begin</a></li>
		</ul>
	</div>
</section>

<?php // Second Loop for the stuff to display

if ( $the_query->have_posts() ) {
	
	$section_count = -1; // keep the count

	while ( $the_query->have_posts() ) {
		$the_query->the_post();
					
			// bump count
			$section_count++;
			
			// what's next?
			$next_section = $section_count + 1;
			?>
			<section id="<?php echo $the_divs[$section_count]?>" class="main special">
				<div class="container">
					<span class="image fit primary"><?php the_post_thumbnail();?></span>
					<div class="content">
						<header class="major">
							<h2><?php the_title(); ?></h2>
						</header>
						
						<p><?php the_content( 'more...' );?></p>
						
						<?php edit_post_link('Edit This', '<p class="edit-this"><span class="fa fa-pencil-square-o" aria-hidden="true"></span> ', '</p>');?>
					</div>
							
				<!-- section navigation -->
				
				<?php if ( $section_count == count($the_divs) - 1 ) :?>
				
					<div class="morebutton">
						<a class="button special icon fa-chevron-up" href="#top">TOP</a>
					</div>';
					
					
					
					 
				<?php else:?>
					<a href="#<?php echo $the_divs[$next_section]?>" class="goto-next scrolly">Next</a>
					
				<?php endif?>
				</div>
			</section>	
		<?php
		} // while $the_query->have_posts()
	} // if $the_query->have_posts() 
	?>
	
<?php get_footer(); ?>