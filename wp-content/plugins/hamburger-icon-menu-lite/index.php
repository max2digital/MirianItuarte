<?php

/*
Plugin Name: Hamburger Icon Menu Lite
Plugin URI: 
Description: This plugin is allows you to create side flyout or fullscreen menu with hamburger icon. It have two layouts of menu items output (vertical and horizontal). You can set different parameters such as menu bar and icon color, size, position and so on.
Author: borisolhor
Version: 1.0
Author URI: http://codecanyon.net/user/borisolhor?ref=borisolhor
*/

if (!defined('ABSPATH')) die("Can't load this file directly");

function iwpmenu_resources() {
    
    wp_register_style('iwpmenu_style', plugins_url('css/iwpmenu.css', __FILE__));
    wp_enqueue_style('iwpmenu_style');

    wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css' );
    
    wp_enqueue_script('jquery');
    
    wp_register_script('iwpmenu_script', plugins_url('js/iwpmenu.js', __FILE__));
    wp_enqueue_script('iwpmenu_script');

}
add_action('init', 'iwpmenu_resources');

require_once 'settings.php';

// Output menu

function iwpmenu_output() {

	$options = get_option('iwpmenu_general');

    $social_options = get_option('iwpmenu_social');

    $bar_options = get_option('iwpmenu_bar');

    $general_options = get_option('iwpmenu_general');

    if(is_array($social_options)) {
        $options = array_merge($options, $social_options);
    }

    if(is_array($bar_options)) {
        $options = array_merge($options, $bar_options);
    }

    if(is_array($general_options)) {
        $options = array_merge($options, $general_options);
    }

	$menu_slug = $options['general_menu'];

	if($menu_slug == 'none') return false;

	?>
	<div id="iwpmenu_icon">
		<i class="iwpmenu_open_button"><svg width="100%" height="100%" viewBox="0 0 750 750" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
    <g id="Hamburger" sketch:type="MSLayerGroup" transform="translate(76.000000, 130.000000)" fill="#000000">
        <path class="hamburger_layer" d="M27.7109738,291 L569.614461,291 L569.614461,290.997309 C569.716963,290.999102 569.819597,291 569.922361,291 C585.396757,291 597.941234,270.628956 597.941234,245.5 C597.941234,220.371044 585.396757,200 569.922361,200 C569.819597,200 569.716963,200.000898 569.614461,200 L27.7109738,200 C12.3784178,200.270773 0,220.537922 0,245.5 C0,270.462078 12.3784178,290.729227 27.7109738,290.997309 Z" id="Rectangle-1" sketch:type="MSShapeGroup"></path>
        <path class="hamburger_layer" d="M27.7109738,491 L569.614461,491 L569.614461,490.997309 C569.716963,490.999102 569.819597,491 569.922361,491 C585.396757,491 597.941234,470.628956 597.941234,445.5 C597.941234,420.371044 585.396757,400 569.922361,400 C569.819597,400 569.716963,400.000898 569.614461,400 L27.7109738,400 C12.3784178,400.270773 0,420.537922 0,445.5 C0,470.462078 12.3784178,490.729227 27.7109738,490.997309 Z" id="Rectangle-2" sketch:type="MSShapeGroup"></path>
        <path class="hamburger_layer" d="M27.7109738,91 L569.614461,91 L569.614461,90.9973094 C569.716963,90.9991016 569.819597,91 569.922361,91 C585.396757,91 597.941234,70.6289561 597.941234,45.5 C597.941234,20.3710439 585.396757,0 569.922361,0 C569.819597,0 569.716963,0.000898385358 569.614461,0 L27.7109738,0 C12.3784178,0.270772558 0,20.5379219 0,45.5 C0,70.4620781 12.3784178,90.7292274 27.7109738,90.9973094 Z" id="Rectangle-3" sketch:type="MSShapeGroup"></path>
    </g>
</svg></i>
		<i class="iwpmenu_close_button"><svg width="100%" height="100%" viewBox="0 0 750 750" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
    <g id="Close" sketch:type="MSLayerGroup" transform="translate(102.000000, 102.000000)" fill="#000000">
        <path class="close_layer" d="M-30.9843421,324.048048 L576.264879,324.048048 L576.264879,324.045028 C576.379742,324.047039 576.494752,324.048048 576.609907,324.048048 C593.950293,324.048048 608.007452,301.186481 608.007452,272.985309 C608.007452,244.784136 593.950293,221.922569 576.609907,221.922569 C576.494752,221.922569 576.379742,221.923578 576.264879,221.922569 L-30.9843421,221.922569 C-48.1657829,222.226446 -62.0368591,244.971417 -62.0368591,272.985309 C-62.0368591,300.9992 -48.1657829,323.744171 -30.9843421,324.045028 Z" id="Rectangle-1" sketch:type="MSShapeGroup" transform="translate(272.985297, 272.985309) rotate(-45.000000) translate(-272.985297, -272.985309) "></path>
        <path class="close_layer" d="M-30.9619558,324.05032 L576.247107,324.05032 L576.247107,324.0473 C576.361962,324.049312 576.476965,324.05032 576.592112,324.05032 C593.931351,324.05032 607.987581,301.188753 607.987581,272.987581 C607.987581,244.786409 593.931351,221.924842 576.592112,221.924842 C576.476965,221.924842 576.361962,221.92585 576.247107,221.924842 L-30.9619558,221.924842 C-48.1422603,222.228718 -62.0124192,244.973689 -62.0124192,272.987581 C-62.0124192,301.001473 -48.1422603,323.746443 -30.9619558,324.0473 Z" id="Rectangle-2" sketch:type="MSShapeGroup" transform="translate(272.987581, 272.987581) rotate(-315.000000) translate(-272.987581, -272.987581) "></path>
    </g>
</svg></i>
	</div>
	<div id='iwpmenu_bar'>
	<?php
	$menu_options = array(
        'menu'=>$menu_slug,
        'walker' => new iwp_walker()
    );
	wp_nav_menu($menu_options);
	?>
	</div>
    
	<?php
}

add_action('wp_footer', 'iwpmenu_output');

// Generate CSS file after plugin activation
function activate_generate_iwp_css() {
    $general = get_option( 'iwpmenu_general' );
    $icon = get_option( 'iwpmenu_icon' );
    $bar = get_option( 'iwpmenu_bar' );
    $items = get_option( 'iwpmenu_items' );
    $is_google_font = true;
    $default_fonts = array(
        "Georgia",
        "Palatino",
        "Times",
        "Arial",
        "Tahoma",
        "Helvetica",
        "Verdana"
    );
    if(in_array($items['item_font_family'], $default_fonts)) {
        $is_google_font = false;
    }

    ob_start();
    require ('css/iwpmenu.php');
    $css = ob_get_clean();
    file_put_contents(plugin_dir_path(__FILE__ ).'css/iwpmenu.css', $css, LOCK_EX);
}

// Generate JS file after plugin activation
function activate_generate_iwp_js() {
    $general = get_option( 'iwpmenu_general' );
    $bar = get_option( 'iwpmenu_bar' );
    $item = get_option( 'iwpmenu_items' );

    ob_start();
    require ('js/iwpmenu.php');
    $js = ob_get_clean();
    file_put_contents(plugin_dir_path(__FILE__ ).'js/iwpmenu.js', $js, LOCK_EX);
}

function get_googlefont_list() {
    $result = array(
        "ABeeZee" => "ABeeZee",
        "Abel" => "Abel",
        "Abril Fatface" => "Abril Fatface",
        "Aclonica" => "Aclonica",
        "Acme" => "Acme",
        "Actor" => "Actor",
        "Adamina" => "Adamina",
        "Advent Pro" => "Advent Pro",
        "Aguafina Script" => "Aguafina Script",
        "Akronim" => "Akronim",
        "Aladin" => "Aladin",
        "Aldrich" => "Aldrich",
        "Alef" => "Alef",
        "Alegreya" => "Alegreya",
        "Alegreya SC" => "Alegreya SC",
        "Alegreya Sans" => "Alegreya Sans",
        "Alegreya Sans SC" => "Alegreya Sans SC",
        "Alex Brush" => "Alex Brush",
        "Alfa Slab One" => "Alfa Slab One",
        "Alice" => "Alice",
        "Alike" => "Alike",
        "Alike Angular" => "Alike Angular",
        "Allan" => "Allan",
        "Allerta" => "Allerta",
        "Allerta Stencil" => "Allerta Stencil",
        "Allura" => "Allura",
        "Almendra" => "Almendra",
        "Almendra Display" => "Almendra Display",
        "Almendra SC" => "Almendra SC",
        "Amarante" => "Amarante",
        "Amaranth" => "Amaranth",
        "Amatic SC" => "Amatic SC",
        "Amethysta" => "Amethysta",
        "Amiri" => "Amiri",
        "Amita" => "Amita",
        "Anaheim" => "Anaheim",
        "Andada" => "Andada",
        "Andika" => "Andika",
        "Angkor" => "Angkor",
        "Annie Use Your Telescope" => "Annie Use Your Telescope",
        "Anonymous Pro" => "Anonymous Pro",
        "Antic" => "Antic",
        "Antic Didone" => "Antic Didone",
        "Antic Slab" => "Antic Slab",
        "Anton" => "Anton",
        "Arapey" => "Arapey",
        "Arbutus" => "Arbutus",
        "Arbutus Slab" => "Arbutus Slab",
        "Architects Daughter" => "Architects Daughter",
        "Archivo Black" => "Archivo Black",
        "Archivo Narrow" => "Archivo Narrow",
        "Arimo" => "Arimo",
        "Arizonia" => "Arizonia",
        "Armata" => "Armata",
        "Artifika" => "Artifika",
        "Arvo" => "Arvo",
        "Arya" => "Arya",
        "Asap" => "Asap",
        "Asset" => "Asset",
        "Astloch" => "Astloch",
        "Asul" => "Asul",
        "Atomic Age" => "Atomic Age",
        "Aubrey" => "Aubrey",
        "Audiowide" => "Audiowide",
        "Autour One" => "Autour One",
        "Average" => "Average",
        "Average Sans" => "Average Sans",
        "Averia Gruesa Libre" => "Averia Gruesa Libre",
        "Averia Libre" => "Averia Libre",
        "Averia Sans Libre" => "Averia Sans Libre",
        "Averia Serif Libre" => "Averia Serif Libre",
        "Bad Script" => "Bad Script",
        "Balthazar" => "Balthazar",
        "Bangers" => "Bangers",
        "Basic" => "Basic",
        "Battambang" => "Battambang",
        "Baumans" => "Baumans",
        "Bayon" => "Bayon",
        "Belgrano" => "Belgrano",
        "Belleza" => "Belleza",
        "BenchNine" => "BenchNine",
        "Bentham" => "Bentham",
        "Berkshire Swash" => "Berkshire Swash",
        "Bevan" => "Bevan",
        "Bigelow Rules" => "Bigelow Rules",
        "Bigshot One" => "Bigshot One",
        "Bilbo" => "Bilbo",
        "Bilbo Swash Caps" => "Bilbo Swash Caps",
        "Biryani" => "Biryani",
        "Bitter" => "Bitter",
        "Black Ops One" => "Black Ops One",
        "Bokor" => "Bokor",
        "Bonbon" => "Bonbon",
        "Boogaloo" => "Boogaloo",
        "Bowlby One" => "Bowlby One",
        "Bowlby One SC" => "Bowlby One SC",
        "Brawler" => "Brawler",
        "Bree Serif" => "Bree Serif",
        "Bubblegum Sans" => "Bubblegum Sans",
        "Bubbler One" => "Bubbler One",
        "Buda" => "Buda",
        "Buenard" => "Buenard",
        "Butcherman" => "Butcherman",
        "Butterfly Kids" => "Butterfly Kids",
        "Cabin" => "Cabin",
        "Cabin Condensed" => "Cabin Condensed",
        "Cabin Sketch" => "Cabin Sketch",
        "Caesar Dressing" => "Caesar Dressing",
        "Cagliostro" => "Cagliostro",
        "Calligraffitti" => "Calligraffitti",
        "Cambay" => "Cambay",
        "Cambo" => "Cambo",
        "Candal" => "Candal",
        "Cantarell" => "Cantarell",
        "Cantata One" => "Cantata One",
        "Cantora One" => "Cantora One",
        "Capriola" => "Capriola",
        "Cardo" => "Cardo",
        "Carme" => "Carme",
        "Carrois Gothic" => "Carrois Gothic",
        "Carrois Gothic SC" => "Carrois Gothic SC",
        "Carter One" => "Carter One",
        "Caudex" => "Caudex",
        "Cedarville Cursive" => "Cedarville Cursive",
        "Ceviche One" => "Ceviche One",
        "Changa One" => "Changa One",
        "Chango" => "Chango",
        "Chau Philomene One" => "Chau Philomene One",
        "Chela One" => "Chela One",
        "Chelsea Market" => "Chelsea Market",
        "Chenla" => "Chenla",
        "Cherry Cream Soda" => "Cherry Cream Soda",
        "Cherry Swash" => "Cherry Swash",
        "Chewy" => "Chewy",
        "Chicle" => "Chicle",
        "Chivo" => "Chivo",
        "Cinzel" => "Cinzel",
        "Cinzel Decorative" => "Cinzel Decorative",
        "Clicker Script" => "Clicker Script",
        "Coda" => "Coda",
        "Coda Caption" => "Coda Caption",
        "Codystar" => "Codystar",
        "Combo" => "Combo",
        "Comfortaa" => "Comfortaa",
        "Coming Soon" => "Coming Soon",
        "Concert One" => "Concert One",
        "Condiment" => "Condiment",
        "Content" => "Content",
        "Contrail One" => "Contrail One",
        "Convergence" => "Convergence",
        "Cookie" => "Cookie",
        "Copse" => "Copse",
        "Corben" => "Corben",
        "Courgette" => "Courgette",
        "Cousine" => "Cousine",
        "Coustard" => "Coustard",
        "Covered By Your Grace" => "Covered By Your Grace",
        "Crafty Girls" => "Crafty Girls",
        "Creepster" => "Creepster",
        "Crete Round" => "Crete Round",
        "Crimson Text" => "Crimson Text",
        "Croissant One" => "Croissant One",
        "Crushed" => "Crushed",
        "Cuprum" => "Cuprum",
        "Cutive" => "Cutive",
        "Cutive Mono" => "Cutive Mono",
        "Damion" => "Damion",
        "Dancing Script" => "Dancing Script",
        "Dangrek" => "Dangrek",
        "Dawning of a New Day" => "Dawning of a New Day",
        "Days One" => "Days One",
        "Dekko" => "Dekko",
        "Delius" => "Delius",
        "Delius Swash Caps" => "Delius Swash Caps",
        "Delius Unicase" => "Delius Unicase",
        "Della Respira" => "Della Respira",
        "Denk One" => "Denk One",
        "Devonshire" => "Devonshire",
        "Dhurjati" => "Dhurjati",
        "Didact Gothic" => "Didact Gothic",
        "Diplomata" => "Diplomata",
        "Diplomata SC" => "Diplomata SC",
        "Domine" => "Domine",
        "Donegal One" => "Donegal One",
        "Doppio One" => "Doppio One",
        "Dorsa" => "Dorsa",
        "Dosis" => "Dosis",
        "Dr Sugiyama" => "Dr Sugiyama",
        "Droid Sans" => "Droid Sans",
        "Droid Sans Mono" => "Droid Sans Mono",
        "Droid Serif" => "Droid Serif",
        "Duru Sans" => "Duru Sans",
        "Dynalight" => "Dynalight",
        "EB Garamond" => "EB Garamond",
        "Eagle Lake" => "Eagle Lake",
        "Eater" => "Eater",
        "Economica" => "Economica",
        "Ek Mukta" => "Ek Mukta",
        "Electrolize" => "Electrolize",
        "Elsie" => "Elsie",
        "Elsie Swash Caps" => "Elsie Swash Caps",
        "Emblema One" => "Emblema One",
        "Emilys Candy" => "Emilys Candy",
        "Engagement" => "Engagement",
        "Englebert" => "Englebert",
        "Enriqueta" => "Enriqueta",
        "Erica One" => "Erica One",
        "Esteban" => "Esteban",
        "Euphoria Script" => "Euphoria Script",
        "Ewert" => "Ewert",
        "Exo" => "Exo",
        "Exo 2" => "Exo 2",
        "Expletus Sans" => "Expletus Sans",
        "Fanwood Text" => "Fanwood Text",
        "Fascinate" => "Fascinate",
        "Fascinate Inline" => "Fascinate Inline",
        "Faster One" => "Faster One",
        "Fasthand" => "Fasthand",
        "Fauna One" => "Fauna One",
        "Federant" => "Federant",
        "Federo" => "Federo",
        "Felipa" => "Felipa",
        "Fenix" => "Fenix",
        "Finger Paint" => "Finger Paint",
        "Fira Mono" => "Fira Mono",
        "Fira Sans" => "Fira Sans",
        "Fjalla One" => "Fjalla One",
        "Fjord One" => "Fjord One",
        "Flamenco" => "Flamenco",
        "Flavors" => "Flavors",
        "Fondamento" => "Fondamento",
        "Fontdiner Swanky" => "Fontdiner Swanky",
        "Forum" => "Forum",
        "Francois One" => "Francois One",
        "Freckle Face" => "Freckle Face",
        "Fredericka the Great" => "Fredericka the Great",
        "Fredoka One" => "Fredoka One",
        "Freehand" => "Freehand",
        "Fresca" => "Fresca",
        "Frijole" => "Frijole",
        "Fruktur" => "Fruktur",
        "Fugaz One" => "Fugaz One",
        "GFS Didot" => "GFS Didot",
        "GFS Neohellenic" => "GFS Neohellenic",
        "Gabriela" => "Gabriela",
        "Gafata" => "Gafata",
        "Galdeano" => "Galdeano",
        "Galindo" => "Galindo",
        "Gentium Basic" => "Gentium Basic",
        "Gentium Book Basic" => "Gentium Book Basic",
        "Geo" => "Geo",
        "Geostar" => "Geostar",
        "Geostar Fill" => "Geostar Fill",
        "Germania One" => "Germania One",
        "Gidugu" => "Gidugu",
        "Gilda Display" => "Gilda Display",
        "Give You Glory" => "Give You Glory",
        "Glass Antiqua" => "Glass Antiqua",
        "Glegoo" => "Glegoo",
        "Gloria Hallelujah" => "Gloria Hallelujah",
        "Goblin One" => "Goblin One",
        "Gochi Hand" => "Gochi Hand",
        "Gorditas" => "Gorditas",
        "Goudy Bookletter 1911" => "Goudy Bookletter 1911",
        "Graduate" => "Graduate",
        "Grand Hotel" => "Grand Hotel",
        "Gravitas One" => "Gravitas One",
        "Great Vibes" => "Great Vibes",
        "Griffy" => "Griffy",
        "Gruppo" => "Gruppo",
        "Gudea" => "Gudea",
        "Gurajada" => "Gurajada",
        "Habibi" => "Habibi",
        "Halant" => "Halant",
        "Hammersmith One" => "Hammersmith One",
        "Hanalei" => "Hanalei",
        "Hanalei Fill" => "Hanalei Fill",
        "Handlee" => "Handlee",
        "Hanuman" => "Hanuman",
        "Happy Monkey" => "Happy Monkey",
        "Headland One" => "Headland One",
        "Henny Penny" => "Henny Penny",
        "Herr Von Muellerhoff" => "Herr Von Muellerhoff",
        "Hind" => "Hind",
        "Holtwood One SC" => "Holtwood One SC",
        "Homemade Apple" => "Homemade Apple",
        "Homenaje" => "Homenaje",
        "IM Fell DW Pica" => "IM Fell DW Pica",
        "IM Fell DW Pica SC" => "IM Fell DW Pica SC",
        "IM Fell Double Pica" => "IM Fell Double Pica",
        "IM Fell Double Pica SC" => "IM Fell Double Pica SC",
        "IM Fell English" => "IM Fell English",
        "IM Fell English SC" => "IM Fell English SC",
        "IM Fell French Canon" => "IM Fell French Canon",
        "IM Fell French Canon SC" => "IM Fell French Canon SC",
        "IM Fell Great Primer" => "IM Fell Great Primer",
        "IM Fell Great Primer SC" => "IM Fell Great Primer SC",
        "Iceberg" => "Iceberg",
        "Iceland" => "Iceland",
        "Imprima" => "Imprima",
        "Inconsolata" => "Inconsolata",
        "Inder" => "Inder",
        "Indie Flower" => "Indie Flower",
        "Inika" => "Inika",
        "Irish Grover" => "Irish Grover",
        "Istok Web" => "Istok Web",
        "Italiana" => "Italiana",
        "Italianno" => "Italianno",
        "Jacques Francois" => "Jacques Francois",
        "Jacques Francois Shadow" => "Jacques Francois Shadow",
        "Jaldi" => "Jaldi",
        "Jim Nightshade" => "Jim Nightshade",
        "Jockey One" => "Jockey One",
        "Jolly Lodger" => "Jolly Lodger",
        "Josefin Sans" => "Josefin Sans",
        "Josefin Slab" => "Josefin Slab",
        "Joti One" => "Joti One",
        "Judson" => "Judson",
        "Julee" => "Julee",
        "Julius Sans One" => "Julius Sans One",
        "Junge" => "Junge",
        "Jura" => "Jura",
        "Just Another Hand" => "Just Another Hand",
        "Just Me Again Down Here" => "Just Me Again Down Here",
        "Kalam" => "Kalam",
        "Kameron" => "Kameron",
        "Kantumruy" => "Kantumruy",
        "Karla" => "Karla",
        "Karma" => "Karma",
        "Kaushan Script" => "Kaushan Script",
        "Kavoon" => "Kavoon",
        "Kdam Thmor" => "Kdam Thmor",
        "Keania One" => "Keania One",
        "Kelly Slab" => "Kelly Slab",
        "Kenia" => "Kenia",
        "Khand" => "Khand",
        "Khmer" => "Khmer",
        "Khula" => "Khula",
        "Kite One" => "Kite One",
        "Knewave" => "Knewave",
        "Kotta One" => "Kotta One",
        "Koulen" => "Koulen",
        "Kranky" => "Kranky",
        "Kreon" => "Kreon",
        "Kristi" => "Kristi",
        "Krona One" => "Krona One",
        "Kurale" => "Kurale",
        "La Belle Aurore" => "La Belle Aurore",
        "Laila" => "Laila",
        "Lakki Reddy" => "Lakki Reddy",
        "Lancelot" => "Lancelot",
        "Lateef" => "Lateef",
        "Lato" => "Lato",
        "League Script" => "League Script",
        "Leckerli One" => "Leckerli One",
        "Ledger" => "Ledger",
        "Lekton" => "Lekton",
        "Lemon" => "Lemon",
        "Libre Baskerville" => "Libre Baskerville",
        "Life Savers" => "Life Savers",
        "Lilita One" => "Lilita One",
        "Lily Script One" => "Lily Script One",
        "Limelight" => "Limelight",
        "Linden Hill" => "Linden Hill",
        "Lobster" => "Lobster",
        "Lobster Two" => "Lobster Two",
        "Londrina Outline" => "Londrina Outline",
        "Londrina Shadow" => "Londrina Shadow",
        "Londrina Sketch" => "Londrina Sketch",
        "Londrina Solid" => "Londrina Solid",
        "Lora" => "Lora",
        "Love Ya Like A Sister" => "Love Ya Like A Sister",
        "Loved by the King" => "Loved by the King",
        "Lovers Quarrel" => "Lovers Quarrel",
        "Luckiest Guy" => "Luckiest Guy",
        "Lusitana" => "Lusitana",
        "Lustria" => "Lustria",
        "Macondo" => "Macondo",
        "Macondo Swash Caps" => "Macondo Swash Caps",
        "Magra" => "Magra",
        "Maiden Orange" => "Maiden Orange",
        "Mako" => "Mako",
        "Mallanna" => "Mallanna",
        "Mandali" => "Mandali",
        "Marcellus" => "Marcellus",
        "Marcellus SC" => "Marcellus SC",
        "Marck Script" => "Marck Script",
        "Margarine" => "Margarine",
        "Marko One" => "Marko One",
        "Marmelad" => "Marmelad",
        "Martel" => "Martel",
        "Martel Sans" => "Martel Sans",
        "Marvel" => "Marvel",
        "Mate" => "Mate",
        "Mate SC" => "Mate SC",
        "Maven Pro" => "Maven Pro",
        "McLaren" => "McLaren",
        "Meddon" => "Meddon",
        "MedievalSharp" => "MedievalSharp",
        "Medula One" => "Medula One",
        "Megrim" => "Megrim",
        "Meie Script" => "Meie Script",
        "Merienda" => "Merienda",
        "Merienda One" => "Merienda One",
        "Merriweather" => "Merriweather",
        "Merriweather Sans" => "Merriweather Sans",
        "Metal" => "Metal",
        "Metal Mania" => "Metal Mania",
        "Metamorphous" => "Metamorphous",
        "Metrophobic" => "Metrophobic",
        "Michroma" => "Michroma",
        "Milonga" => "Milonga",
        "Miltonian" => "Miltonian",
        "Miltonian Tattoo" => "Miltonian Tattoo",
        "Miniver" => "Miniver",
        "Miss Fajardose" => "Miss Fajardose",
        "Modak" => "Modak",
        "Modern Antiqua" => "Modern Antiqua",
        "Molengo" => "Molengo",
        "Molle" => "Molle",
        "Monda" => "Monda",
        "Monofett" => "Monofett",
        "Monoton" => "Monoton",
        "Monsieur La Doulaise" => "Monsieur La Doulaise",
        "Montaga" => "Montaga",
        "Montez" => "Montez",
        "Montserrat" => "Montserrat",
        "Montserrat Alternates" => "Montserrat Alternates",
        "Montserrat Subrayada" => "Montserrat Subrayada",
        "Moul" => "Moul",
        "Moulpali" => "Moulpali",
        "Mountains of Christmas" => "Mountains of Christmas",
        "Mouse Memoirs" => "Mouse Memoirs",
        "Mr Bedfort" => "Mr Bedfort",
        "Mr Dafoe" => "Mr Dafoe",
        "Mr De Haviland" => "Mr De Haviland",
        "Mrs Saint Delafield" => "Mrs Saint Delafield",
        "Mrs Sheppards" => "Mrs Sheppards",
        "Muli" => "Muli",
        "Mystery Quest" => "Mystery Quest",
        "NTR" => "NTR",
        "Neucha" => "Neucha",
        "Neuton" => "Neuton",
        "New Rocker" => "New Rocker",
        "News Cycle" => "News Cycle",
        "Niconne" => "Niconne",
        "Nixie One" => "Nixie One",
        "Nobile" => "Nobile",
        "Nokora" => "Nokora",
        "Norican" => "Norican",
        "Nosifer" => "Nosifer",
        "Nothing You Could Do" => "Nothing You Could Do",
        "Noticia Text" => "Noticia Text",
        "Noto Sans" => "Noto Sans",
        "Noto Serif" => "Noto Serif",
        "Nova Cut" => "Nova Cut",
        "Nova Flat" => "Nova Flat",
        "Nova Mono" => "Nova Mono",
        "Nova Oval" => "Nova Oval",
        "Nova Round" => "Nova Round",
        "Nova Script" => "Nova Script",
        "Nova Slim" => "Nova Slim",
        "Nova Square" => "Nova Square",
        "Numans" => "Numans",
        "Nunito" => "Nunito",
        "Odor Mean Chey" => "Odor Mean Chey",
        "Offside" => "Offside",
        "Old Standard TT" => "Old Standard TT",
        "Oldenburg" => "Oldenburg",
        "Oleo Script" => "Oleo Script",
        "Oleo Script Swash Caps" => "Oleo Script Swash Caps",
        "Open Sans" => "Open Sans",
        "Open Sans Condensed" => "Open Sans Condensed",
        "Oranienbaum" => "Oranienbaum",
        "Orbitron" => "Orbitron",
        "Oregano" => "Oregano",
        "Orienta" => "Orienta",
        "Original Surfer" => "Original Surfer",
        "Oswald" => "Oswald",
        "Over the Rainbow" => "Over the Rainbow",
        "Overlock" => "Overlock",
        "Overlock SC" => "Overlock SC",
        "Ovo" => "Ovo",
        "Oxygen" => "Oxygen",
        "Oxygen Mono" => "Oxygen Mono",
        "PT Mono" => "PT Mono",
        "PT Sans" => "PT Sans",
        "PT Sans Caption" => "PT Sans Caption",
        "PT Sans Narrow" => "PT Sans Narrow",
        "PT Serif" => "PT Serif",
        "PT Serif Caption" => "PT Serif Caption",
        "Pacifico" => "Pacifico",
        "Palanquin" => "Palanquin",
        "Palanquin Dark" => "Palanquin Dark",
        "Paprika" => "Paprika",
        "Parisienne" => "Parisienne",
        "Passero One" => "Passero One",
        "Passion One" => "Passion One",
        "Pathway Gothic One" => "Pathway Gothic One",
        "Patrick Hand" => "Patrick Hand",
        "Patrick Hand SC" => "Patrick Hand SC",
        "Patua One" => "Patua One",
        "Paytone One" => "Paytone One",
        "Peddana" => "Peddana",
        "Peralta" => "Peralta",
        "Permanent Marker" => "Permanent Marker",
        "Petit Formal Script" => "Petit Formal Script",
        "Petrona" => "Petrona",
        "Philosopher" => "Philosopher",
        "Piedra" => "Piedra",
        "Pinyon Script" => "Pinyon Script",
        "Pirata One" => "Pirata One",
        "Plaster" => "Plaster",
        "Play" => "Play",
        "Playball" => "Playball",
        "Playfair Display" => "Playfair Display",
        "Playfair Display SC" => "Playfair Display SC",
        "Podkova" => "Podkova",
        "Poiret One" => "Poiret One",
        "Poller One" => "Poller One",
        "Poly" => "Poly",
        "Pompiere" => "Pompiere",
        "Pontano Sans" => "Pontano Sans",
        "Port Lligat Sans" => "Port Lligat Sans",
        "Port Lligat Slab" => "Port Lligat Slab",
        "Pragati Narrow" => "Pragati Narrow",
        "Prata" => "Prata",
        "Preahvihear" => "Preahvihear",
        "Press Start 2P" => "Press Start 2P",
        "Princess Sofia" => "Princess Sofia",
        "Prociono" => "Prociono",
        "Prosto One" => "Prosto One",
        "Puritan" => "Puritan",
        "Purple Purse" => "Purple Purse",
        "Quando" => "Quando",
        "Quantico" => "Quantico",
        "Quattrocento" => "Quattrocento",
        "Quattrocento Sans" => "Quattrocento Sans",
        "Questrial" => "Questrial",
        "Quicksand" => "Quicksand",
        "Quintessential" => "Quintessential",
        "Qwigley" => "Qwigley",
        "Racing Sans One" => "Racing Sans One",
        "Radley" => "Radley",
        "Rajdhani" => "Rajdhani",
        "Raleway" => "Raleway",
        "Raleway Dots" => "Raleway Dots",
        "Ramabhadra" => "Ramabhadra",
        "Ramaraja" => "Ramaraja",
        "Rambla" => "Rambla",
        "Rammetto One" => "Rammetto One",
        "Ranchers" => "Ranchers",
        "Rancho" => "Rancho",
        "Ranga" => "Ranga",
        "Rationale" => "Rationale",
        "Ravi Prakash" => "Ravi Prakash",
        "Redressed" => "Redressed",
        "Reenie Beanie" => "Reenie Beanie",
        "Revalia" => "Revalia",
        "Ribeye" => "Ribeye",
        "Ribeye Marrow" => "Ribeye Marrow",
        "Righteous" => "Righteous",
        "Risque" => "Risque",
        "Roboto" => "Roboto",
        "Roboto Condensed" => "Roboto Condensed",
        "Roboto Slab" => "Roboto Slab",
        "Rochester" => "Rochester",
        "Rock Salt" => "Rock Salt",
        "Rokkitt" => "Rokkitt",
        "Romanesco" => "Romanesco",
        "Ropa Sans" => "Ropa Sans",
        "Rosario" => "Rosario",
        "Rosarivo" => "Rosarivo",
        "Rouge Script" => "Rouge Script",
        "Rozha One" => "Rozha One",
        "Rubik Mono One" => "Rubik Mono One",
        "Rubik One" => "Rubik One",
        "Ruda" => "Ruda",
        "Rufina" => "Rufina",
        "Ruge Boogie" => "Ruge Boogie",
        "Ruluko" => "Ruluko",
        "Rum Raisin" => "Rum Raisin",
        "Ruslan Display" => "Ruslan Display",
        "Russo One" => "Russo One",
        "Ruthie" => "Ruthie",
        "Rye" => "Rye",
        "Sacramento" => "Sacramento",
        "Sail" => "Sail",
        "Salsa" => "Salsa",
        "Sanchez" => "Sanchez",
        "Sancreek" => "Sancreek",
        "Sansita One" => "Sansita One",
        "Sarina" => "Sarina",
        "Sarpanch" => "Sarpanch",
        "Satisfy" => "Satisfy",
        "Scada" => "Scada",
        "Scheherazade" => "Scheherazade",
        "Schoolbell" => "Schoolbell",
        "Seaweed Script" => "Seaweed Script",
        "Sevillana" => "Sevillana",
        "Seymour One" => "Seymour One",
        "Shadows Into Light" => "Shadows Into Light",
        "Shadows Into Light Two" => "Shadows Into Light Two",
        "Shanti" => "Shanti",
        "Share" => "Share",
        "Share Tech" => "Share Tech",
        "Share Tech Mono" => "Share Tech Mono",
        "Shojumaru" => "Shojumaru",
        "Short Stack" => "Short Stack",
        "Siemreap" => "Siemreap",
        "Sigmar One" => "Sigmar One",
        "Signika" => "Signika",
        "Signika Negative" => "Signika Negative",
        "Simonetta" => "Simonetta",
        "Sintony" => "Sintony",
        "Sirin Stencil" => "Sirin Stencil",
        "Six Caps" => "Six Caps",
        "Skranji" => "Skranji",
        "Slabo 13px" => "Slabo 13px",
        "Slabo 27px" => "Slabo 27px",
        "Slackey" => "Slackey",
        "Smokum" => "Smokum",
        "Smythe" => "Smythe",
        "Sniglet" => "Sniglet",
        "Snippet" => "Snippet",
        "Snowburst One" => "Snowburst One",
        "Sofadi One" => "Sofadi One",
        "Sofia" => "Sofia",
        "Sonsie One" => "Sonsie One",
        "Sorts Mill Goudy" => "Sorts Mill Goudy",
        "Source Code Pro" => "Source Code Pro",
        "Source Sans Pro" => "Source Sans Pro",
        "Source Serif Pro" => "Source Serif Pro",
        "Special Elite" => "Special Elite",
        "Spicy Rice" => "Spicy Rice",
        "Spinnaker" => "Spinnaker",
        "Spirax" => "Spirax",
        "Squada One" => "Squada One",
        "Sree Krushnadevaraya" => "Sree Krushnadevaraya",
        "Stalemate" => "Stalemate",
        "Stalinist One" => "Stalinist One",
        "Stardos Stencil" => "Stardos Stencil",
        "Stint Ultra Condensed" => "Stint Ultra Condensed",
        "Stint Ultra Expanded" => "Stint Ultra Expanded",
        "Stoke" => "Stoke",
        "Strait" => "Strait",
        "Sue Ellen Francisco" => "Sue Ellen Francisco",
        "Sumana" => "Sumana",
        "Sunshiney" => "Sunshiney",
        "Supermercado One" => "Supermercado One",
        "Suranna" => "Suranna",
        "Suravaram" => "Suravaram",
        "Suwannaphum" => "Suwannaphum",
        "Swanky and Moo Moo" => "Swanky and Moo Moo",
        "Syncopate" => "Syncopate",
        "Tangerine" => "Tangerine",
        "Taprom" => "Taprom",
        "Tauri" => "Tauri",
        "Teko" => "Teko",
        "Telex" => "Telex",
        "Tenali Ramakrishna" => "Tenali Ramakrishna",
        "Tenor Sans" => "Tenor Sans",
        "Text Me One" => "Text Me One",
        "The Girl Next Door" => "The Girl Next Door",
        "Tienne" => "Tienne",
        "Timmana" => "Timmana",
        "Tinos" => "Tinos",
        "Titan One" => "Titan One",
        "Titillium Web" => "Titillium Web",
        "Trade Winds" => "Trade Winds",
        "Trocchi" => "Trocchi",
        "Trochut" => "Trochut",
        "Trykker" => "Trykker",
        "Tulpen One" => "Tulpen One",
        "Ubuntu" => "Ubuntu",
        "Ubuntu Condensed" => "Ubuntu Condensed",
        "Ubuntu Mono" => "Ubuntu Mono",
        "Ultra" => "Ultra",
        "Uncial Antiqua" => "Uncial Antiqua",
        "Underdog" => "Underdog",
        "Unica One" => "Unica One",
        "UnifrakturCook" => "UnifrakturCook",
        "UnifrakturMaguntia" => "UnifrakturMaguntia",
        "Unkempt" => "Unkempt",
        "Unlock" => "Unlock",
        "Unna" => "Unna",
        "VT323" => "VT323",
        "Vampiro One" => "Vampiro One",
        "Varela" => "Varela",
        "Varela Round" => "Varela Round",
        "Vast Shadow" => "Vast Shadow",
        "Vesper Libre" => "Vesper Libre",
        "Vibur" => "Vibur",
        "Vidaloka" => "Vidaloka",
        "Viga" => "Viga",
        "Voces" => "Voces",
        "Volkhov" => "Volkhov",
        "Vollkorn" => "Vollkorn",
        "Voltaire" => "Voltaire",
        "Waiting for the Sunrise" => "Waiting for the Sunrise",
        "Wallpoet" => "Wallpoet",
        "Walter Turncoat" => "Walter Turncoat",
        "Warnes" => "Warnes",
        "Wellfleet" => "Wellfleet",
        "Wendy One" => "Wendy One",
        "Wire One" => "Wire One",
        "Yanone Kaffeesatz" => "Yanone Kaffeesatz",
        "Yellowtail" => "Yellowtail",
        "Yeseva One" => "Yeseva One",
        "Yesteryear" => "Yesteryear",
        "Zeyada" => "Zeyada"
    );

    return $result;
}

// Set default settings
function set_iwp_default_settings() {
    global $wpdb;

    $results_general = $wpdb->get_results( "SELECT * FROM wp_options WHERE option_name = 'iwpmenu_general'", OBJECT );
    $results_icon = $wpdb->get_results( "SELECT * FROM wp_options WHERE option_name = 'iwpmenu_icon'", OBJECT );
    $results_bar = $wpdb->get_results( "SELECT * FROM wp_options WHERE option_name = 'iwpmenu_bar'", OBJECT );
    $results_items = $wpdb->get_results( "SELECT * FROM wp_options WHERE option_name = 'iwpmenu_items'", OBJECT );
    // if settings empty - set default values
    if(count($results_general) == 0) {
    	$wpdb->insert(
    		'wp_options',
    		array(
    			'option_name' => 'iwpmenu_general',
    			'option_value' => 'a:2:{s:12:"general_menu";s:4:"none";s:16:"general_position";s:5:"right";}'
			)
		);
    } 

    if(count($results_icon) == 0) {
        $wpdb->insert(
            'wp_options',
            array(
                'option_name' => 'iwpmenu_icon',
                'option_value' => 'a:8:{s:9:"icon_size";s:2:"24";s:13:"icon_position";s:5:"fixed";s:10:"icon_color";s:4:"#000";s:16:"close_icon_color";s:4:"#fff";s:22:"icon_horizontal_margin";s:2:"35";s:28:"icon_horizontal_margin_units";s:2:"px";s:20:"icon_vertical_margin";s:2:"35";s:26:"icon_vertical_margin_units";s:2:"px";}'
            )
        );
    }

    if(count($results_bar) == 0) {
        $wpdb->insert(
            'wp_options',
            array(
                'option_name' => 'iwpmenu_bar',
                'option_value' => 'a:4:{s:9:"bar_color";s:7:"#000000";s:16:"bar_border_color";s:7:"#ffffff";s:9:"bar_width";s:3:"300";s:15:"bar_width_units";s:2:"px";}'
            )
        );
    }

    if(count($results_items) == 0) {
        $wpdb->insert(
            'wp_options',
            array(
                'option_name' => 'iwpmenu_items',
                'option_value' => 'a:12:{s:16:"item_top_padding";s:2:"70";s:22:"item_top_padding_units";s:2:"px";s:19:"item_text_alignment";s:6:"center";s:16:"item_font_family";s:9:"Open Sans";s:19:"item_main_font_size";s:2:"16";s:25:"item_main_font_size_units";s:2:"px";s:18:"item_sub_font_size";s:2:"14";s:24:"item_sub_font_size_units";s:2:"px";s:16:"item_line_height";s:2:"18";s:22:"item_line_height_units";s:2:"px";s:20:"item_main_font_color";s:7:"#ffffff";s:26:"item_hover_main_font_color";s:4:"#aaa";}'
            )
        );
    }

}

function iwpmenu_activate() {
    activate_generate_iwp_css();
    
    activate_generate_iwp_js();

    set_iwp_default_settings();
}

register_activation_hook(__FILE__, 'iwpmenu_activate');


function iwp_add_nav_icon( $menu_item ) {
    $menu_item->icon = sanitize_text_field(get_post_meta( $menu_item->ID, '_menu_item_icon', true ));
    return $menu_item;
}

// add custom menu fields to menu
add_filter( 'wp_setup_nav_menu_item', 'iwp_add_nav_icon' );
function iwp_update_nav_icon( $menu_id, $menu_item_db_id, $args ) {
    // Check if element is properly sent
    if ( is_array( $_REQUEST['menu-item-icon']) ) {
        $icon_value = sanitize_text_field($_REQUEST['menu-item-icon'][$menu_item_db_id]);
        update_post_meta( $menu_item_db_id, '_menu_item_icon', $icon_value );
    }
}

// save menu custom fields
add_action( 'wp_update_nav_menu_item', 'iwp_update_nav_icon', 10, 3 );

function iwp_edit_walker($walker,$menu_id) {

    return 'Walker_Nav_Menu_Edit_Icon';

}

// edit menu walker
add_filter( 'wp_edit_nav_menu_walker', 'iwp_edit_walker', 10, 2 );

include_once( 'edit_custom_walker.php' );
include_once( 'custom_walker.php' );
