<div class="d-flex justify-content-center align-items-center content-wrapper" style="height: 100vh;">
    <div class="card" style="min-width: 400px;">
        <div class="card-body">
            <div class="text-center mb-5">
                <img src="<?php echo WP_NGLOROK_PLUGIN_URL;?>public/assets/images/vdlogo.jpg" width="200" class="mx-auto" alt="logo" />
            </div>
            <?php
                $args = array(
                    'echo'            => true,
                    'redirect'        => get_permalink( get_the_ID() ),
                    'remember'        => true,
                    'value_remember'  => true,
                );
                echo wp_login_form( $args );      
                $form = ob_get_clean();
            
                $arr = array(
                    'class="button button-primary"' => 'class="btn btn-primary px-5 w-100"',
                    'class="input"'                 => 'class="input form-control"',
                );
                $form = strtr($form,$arr);                
                echo '<div style="max-width:20rem;">'.$form.'</div>';
            ?>
        </div>
    </div>
</div>