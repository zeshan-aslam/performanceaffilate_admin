<?php
   function redirect_page($location)
    {

        if (!headers_sent()) {

            header('Location: ' . $location);

            exit;

        } else {
            echo '<script type="text/javascript">';
        }

        echo 'window.location.href="' . $location . '";';

        echo '</script>';

        echo '<noscript>';

        echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';

        echo '</noscript>';
    }
   
    redirect_page('https://performanceaffiliate.com/Admin/public');

?>