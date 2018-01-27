<?php 
	get_header(); 
?>
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
				<h1 class="single-title"><?php the_title(); ?></h1>
			</header>	
				<div class="container">
					<ul class="actions">
						<li><a href="#more" class="button special scrolly">More</a></li>
					</ul>
				</div>
			</section>

			<section id="more" class="main special">
				<div class="container">
					<span class="image fit primary"><?php the_post_thumbnail();?></span>
					<div class="content">
						
						<?php the_content();?>
						
						<?php edit_post_link('Edit This', '<p class="edit-this"><span class="fa fa-pencil-square-o" aria-hidden="true"></span> ', '</p>');?>
						
						
											
						<!-- home navigation -->
						<div class="morebutton">
							<a class="button special icon fa-chevron-left" href="<?php echo site_url()?>">RETURN</a>
						</div>';

					</div>
				
				</div><!-- //containter -->
			</section>	
   		<?php endwhile;?>
	<?php endif; ?> 
	  	
<?php get_footer(); ?>