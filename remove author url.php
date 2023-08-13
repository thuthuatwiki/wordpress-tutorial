/*xoá url tác giả*/
add_filter( 'generate_post_author_output','tu_no_author_link' );
function tu_no_author_link() {
	printf( ' <span class="byline">%1$s</span>',
		sprintf( '<span class="author vcard" itemtype="http://schema.org/Person" itemscope="itemscope" itemprop="author">%1$s <span class="fn n author-name" itemprop="name">%4$s</span></span>',
			__( 'by','generatepress'),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'generatepress' ), get_the_author() ) ),
			esc_html( get_the_author() )
		)
	);
}
