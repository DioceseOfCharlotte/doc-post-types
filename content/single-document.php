<?php
/**
 * Single Document Template.
 *
 * @package  doc-post-types
 */
?>

<article <?php hybrid_attr( 'post' ); ?>>

		<div <?php hybrid_attr( 'entry-content' ); ?>>
			<?php the_excerpt(); ?>
			<?php $doc = get_post_meta( get_the_ID(), 'dpt_document_id', true ); ?>
			<?php $doc_link = wp_get_attachment_url( $doc ); ?>

			<?php if ( function_exists( 'members_can_current_user_view_post' ) && members_can_current_user_view_post( get_the_ID() ) ) : ?>

				<?php if ( $doc ) : ?>

					<div class="u-1of1 u-flex u-flex-jb u-mb">
						<a class="dl-link" href="<?php echo $doc_link; ?>" download>Download document <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/><path fill="none" d="M0 0h24v24H0z"/></svg></a>

						<a class="new-tab-link" href="<?php echo $doc_link; ?>" target="_blank" rel="noopener">View document in a new tab <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1.4em" height="1.4em"><path d="M19 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6v2H5v12h12v-6h2zM13 3v2h4.586l-7.793 7.793 1.414 1.414L19 6.414V11h2V3h-8z"/></svg></a>
					</div>


					<?php if ( doc_is_file( 'pdf' ) ) { ?>
				<object class="doc-embed" data="<?php echo $doc_link; ?>#pagemode=bookmarks" type="application/pdf" width="100%" height="600px">
					<iframe src="https://docs.google.com/viewer?url=<?php echo $doc_link; ?>&amp;hl=en_US&amp;embedded=true" width="100%" height="600px" style="border: none;">
						This browser does not support PDFs. Please download the PDF to view it:
					</iframe>
				</object>

			<?php } else { ?>

				<iframe src="https://docs.google.com/viewer?url=<?php echo $doc_link; ?>&amp;hl=en_US&amp;embedded=true" width="100%" height="500px" style="border: none;"></iframe>

			<?php } ?>

				<?php else : ?>

					<h3 class="u-1of1 u-text-center">This document wasn't found.</h3>
					<h4 class="u-1of1 u-text-center">Perhaps searching can help.</h4>
					<div class="u-1of1 u-text-center u-p2"><?php get_search_form(); ?></div>

				<?php endif; ?>

			<?php endif; ?>
		</div>

		<?php get_template_part( 'components/entry', 'footer' ); ?>

</article>
