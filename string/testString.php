<?php 
    $str = 'You customer service representative told me, "We dont give any guarantees"';
    echo addslashes($str);
    echo get_magic_quotes_gpc();
 ?> 