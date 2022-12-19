

function wpb_catlist_desc($atts = []) { 
$string = '<div class = "product-cat">';
$category_link = get_category_link( $category_id ); 
$catlist = get_terms( 'product_cat' );
if ( ! empty( $catlist ) ) {
    foreach ( $catlist as $key => $item ) {
        $down=0;
        $dbDate=get_field('date', 'term_'.$item->term_id);
        $compareDate=date('n/j/Y',strtotime(get_field('date', 'term_'.$item->term_id)));
        $todayDate = date('n/j/Y');

        $datetime1 = new DateTime($dbDate);
        $datetime2 = new DateTime();
        $interval = $datetime2->diff($datetime1);
        $difference=0;
        $todayLabel=get_field('date', 'term_'.$item->term_id);
        if($datetime1>$datetime2 || $compareDate==$todayDate){
            $difference=$interval->format('%a');
            $difference=$difference+1;    
        }
        if($compareDate==$todayDate){
            $todayLabel="Today";
			$whatTime=date("H",strtotime(get_field('time', 'term_'.$item->term_id)));
			if($whatTime>21){
				$todayLabel="At Night";
			}
		}
        $wporg_atts = shortcode_atts(
            array(
                'title' => 'Brock',
            ), $atts, $tag
        );
        if($difference > 7){ $down=1; }
        if($down==0 && $wporg_atts['title']=='up' && $difference > 0 && $difference < 8){
            $string .= '<div class = "product-card"><a href ='. get_category_link($item->term_id) .'>';
             $thumbnail_id = get_woocommerce_term_meta($item->term_id, 'thumbnail_id', true);
             $cat_image = wp_get_attachment_url($thumbnail_id);
                 $string .= "<div class = 'cat-img'><img src='{$cat_image}'/></div>";      
                $string .= '<div class = "cat-btm"><div class = "cat-title"><h3>'. $item->name . '<h3></div>';
             $string .= '<div class = "date-time"><h4>' .$todayLabel. '</h4>' ;
             $string .= '<h4> Time: '  . get_field('time', 'term_'.$item->term_id) .'</h4></div>' ;
                $string .= '<div class = "cat-desc">'. $item->description . '</div></div>';
             $string .= '<div class = "view-more"><a href ='. get_category_link($item->term_id) .'> View More </a><img src="'.get_template_directory_uri(). '/inc/assets/images/arrow.svg"/></div>' ;      
            $string .= '</div>'; 
        }else{
            if($down==1 && $wporg_atts['title']!='up'){

                $string .= '<div class = "product-card">';
                    $thumbnail_id = get_woocommerce_term_meta($item->term_id, 'thumbnail_id', true);
                    $cat_image = wp_get_attachment_url($thumbnail_id);
                    $string .= "<div class = 'cat-img'><img src='{$cat_image}'/></div>";      
                    $string .= '<div class = "cat-btm"><div class = "cat-title"><h3>'. $item->name . '<h3></div>';
                    $string .= '<div class = "date-time"><h4>' . get_field('date', 'term_'.$item->term_id)  .'</h4>' ;
                    $string .= '<h4> Time: '  . get_field('time', 'term_'.$item->term_id) .'</h4></div>' ;
                    $string .= '<div class = "cat-desc">'. $item->description . '</div></div>';
                    $string .= '<div class = "view-more"><a href ='. get_category_link($item->term_id) .'> View More </a><img src="'.get_template_directory_uri(). '/inc/assets/images/arrow.svg"/></div>' ;      
                $string .= '</a></div>'; 
            }
        }
    }
}
$string .= '</div>';
  
return $string;
    
}
add_shortcode('wpb_categories', 'wpb_catlist_desc');
