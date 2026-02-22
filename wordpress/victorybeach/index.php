<?php get_header(); ?>

<?php 
// Helper variabele voor het pad naar je afbeeldingen
$theme_url = get_template_directory_uri(); 
?>


<div class="banner">
    <img src="<?php echo $theme_url; ?>/images/Vibes-logo.png" alt="Vibes Logo" class="logo">
    </div>
</div>



<div class="container">
    <?php
    // We halen alle pagina's op die je in de admin hebt aangemaakt
    $args = array(
        'post_type'      => 'page',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order', // Gebruik de 'Order' instelling uit WP
        'order'          => 'ASC',
    );

    $sections_query = new WP_Query($args);

    if ( $sections_query->have_posts() ) :
        while ( $sections_query->have_posts() ) : $sections_query->the_post(); ?>
            
            <section id="<?php echo $post->post_name; ?>" class="js-section">
                <div>
                    <div class="section-header"><?php the_title(); ?></div>
                    <div class="section-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>

        <?php endwhile;
        wp_reset_postdata();
    else :
        echo '<section><p>Geen pagina\'s gevonden. Maak eerst pagina\'s aan in de WordPress admin.</p></section>';
    endif;
    ?>
</div>

<img src="<?php echo $theme_url; ?>/images/NextPageIcon.png" 
    alt="Volgende" 
    class="next-page-icon" 
    id="nextSectionBtn">

<script>
/**
 * Script om naar de volgende sectie te scrollen
 */
document.getElementById('nextSectionBtn').addEventListener('click', function() {
    const sections = document.querySelectorAll('.js-section');
    if (sections.length === 0) return;

    // We kijken waar we nu zijn (midden van het scherm als referentie)
    const scrollPosition = window.scrollY + (window.innerHeight / 3);
    let nextSection = sections[0]; // Terug naar begin als we niks vinden

    for (let i = 0; i < sections.length; i++) {
        // Zoek de eerste sectie die onder de huidige scrollpositie ligt
        if (sections[i].offsetTop > scrollPosition + 10) {
            nextSection = sections[i];
            break;
        }
    }

    // Scroll naar de sectie
    window.scrollTo({
        top: nextSection.offsetTop,
        behavior: 'smooth'
    });

    // Update de URL met het anker (#) zonder te refreshen
    if (nextSection.id) {
        history.pushState(null, null, '#' + nextSection.id);
    }
});

/**
 * Zorg dat de banner hoogte dynamisch wordt verwerkt in de CSS padding
 */
function updateSectionPadding() {
    const banner = document.querySelector('.banner');
    if (banner) {
        const height = banner.offsetHeight + 'px';
        document.documentElement.style.setProperty('--banner-height', height);
    }
}

window.addEventListener('load', updateSectionPadding);
window.addEventListener('resize', updateSectionPadding);

// Initial check voor ankers in de URL bij laden (bijv. victorybeach.nl/#inschrijven)
window.addEventListener('load', () => {
    const hash = window.location.hash;
    if (hash) {
        const target = document.querySelector(hash);
        if (target) {
            setTimeout(() => {
                target.scrollIntoView({ behavior: 'smooth' });
            }, 500);
        }
    }
});
</script>

<?php get_footer(); ?>