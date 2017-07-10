	</div>
	
<?php if( is_active_sidebar( 'sidebar_footer' ) ) : ?>	
<footer id="footer">
	<div class="container">
		<div class="row animated" id="absolute-footer">
			<?php dynamic_sidebar( 'sidebar_footer' ); ?>
		</div><!-- #absolute-footer -->
	</div><!-- .container -->
</footer><!-- #footer -->
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>WPLOCKER.COM