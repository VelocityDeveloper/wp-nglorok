<nav class="navbar col-lg-12 col-12 p-0 sticky-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <a class="navbar-brand brand-logo me-5" href="<?php echo get_site_url(); ?>"><img src="<?php echo WP_NGLOROK_PLUGIN_URL;?>public/assets/images/vdlogo.jpg" class="me-2" alt="logo" /></a>
    <a class="navbar-brand brand-logo-mini" href="<?php echo get_site_url(); ?>"><img src="<?php echo WP_NGLOROK_PLUGIN_URL;?>public/assets/images/vdfav.png" alt="logo" /></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="icon-menu"></span>
    </button>

    <ul class="navbar-nav navbar-nav-right">      
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">          
          <?php
          $profil = new Wp_Nglorok_Profile();
          ?>
          <img src="<?php echo $profil->avatar();?>" alt="profile" />
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" style="margin-top:-1rem !important;" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="<?php echo get_site_url(); ?>/akun">
            <i class="ti-settings text-primary"></i> Settings
          </a>
          <a class="dropdown-item" href="<?php echo wp_logout_url( get_site_url() ); ?>">
            <i class="ti-power-off text-primary"></i> Logout
          </a>
        </div>
      </li>
    </ul>
    
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="icon-menu"></span>
    </button>
  </div>
</nav>