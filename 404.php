<?php

get_header(); ?>


			
				<h1 class="single-title">Room 404</h1>
				<div class="subtitle">Yikes! We could not find what you were looking for.</div>
			</header>	
				<div class="container">
					<ul class="actions">
						<li><a href="#more" class="button special scrolly">Help</a></li>
					</ul>
				</div>
			</section>

			<section id="more" class="main special">
				<div class="container">
					<div class="content">
						<p>Apparently you were looking for something we do not have. No worries, mistakes happen. This site does not have a <em>huge</em> amount of content, these are the major sections:</p>
						
						<ul>
						
					<?php
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
								echo '<li><a href="' . get_the_permalink() . '">' . get_the_title() . "</a></li>\n"; 

							} // while 
		
							// rewind so we can reuse for the content
							$the_query->rewind_posts();
		
						} // $the_query->have_posts()
					?>
					
					</ul>
					
					<h2>Other Pages</h2>
					
					<ul>
					<?php wp_list_pages( array( 'title_li' => '' ) ); ?>
					</ul>
					
					<p>If all else fails then <a href="<?php echo site_url()?>">return to the front door</a> and try the links there.</p>
						
						<!-- home navigation -->
						<div class="morebutton">
							<a class="button special icon fa-chevron-left" href="<?php echo site_url()?>">RETURN</a>
						</div>';				

					</div>
				
				</div><!-- //containter -->
			</section>	

	  	
<?php get_footer(); ?>