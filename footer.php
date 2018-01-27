
		<!-- Footer -->
			<section id="footer">
				<div class="container">
					<header class="major">
						<h2><?php bloginfo( 'name' )?></h2>
					</header>
					<p><?php bloginfo( 'description' )?></p>

				<!-- social ucons -->
				<?php 
				if (  has_nav_menu( 'highlights-social' ) ) {
					wp_nav_menu( array( 'theme_location' => 'highlights-social', 'menu_class' => 'actions' ) );
				} 			
				?>		

				<footer>
					<ul class="copyright">
						<li><em><?php highlights_footer_text()?></em></li>
						<li>theme: <a href="https://github.com/cogdog/wp-highlights">WP Highlights</a> based on <a href="https://html5up.net/highlights">HTML5 UP</a> modded by <a href="http://cog.dog">cog.dog</a></li>
					</ul>
				</footer>
				</div>
				
				
				
				
			</section>

			
	<?php wp_footer(); ?>
	</body>
</html>