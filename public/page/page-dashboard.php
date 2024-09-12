<?php
/**
 * Class Page_Dashboard
 * shortcode : [page_dashboard]
 */
class Page_Dashboard {

    public $user_id;

    /**
     * constructor.
    */
    public function __construct() {
        add_shortcode('page_dashboard', array($this, 'render_page'));
    }

    function sambutan(){
        ?>
        <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row align-items-center">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold m-0">Selamat Datang <?php echo get_user_meta($this->user_id,'first_name',true); ?></h3>
                </div>
                <div class="col-12 col-xl-4 text-end">
                    <div class="btn btn-sm btn-light bg-white">
                        <?php echo date( 'd F Y', current_time( 'timestamp', 0 ) ); ?>
                    </div>
                </div>
              </div>
            </div>
        </div>
        <?php
    }
    
    function cards(){
        ?>
        <div class="row">

            <div class="col-md-6 grid-margin stretch-card">
              <div class="card tale-bg">
                <div class="card-people mt-auto">
                  <img src="<?php echo WP_NGLOROK_PLUGIN_URL;?>public/assets/images/dashboard/people.svg" alt="people">
                </div>
              </div>
            </div>

            <div class="col-md-6 grid-margin transparent">

                <div class="row">
                    <?php
                    $cards = [
                        [
                            'color'     => 'tale',
                            'title'     => 'Projek Bulan ini',
                            'value'     => '120',
                            'caption'   => 'Projek Bulan ini',
                        ],
                        [
                            'color'     => 'dark-blue',
                            'title'     => 'Projek Bulan ini',
                            'value'     => '120',
                            'caption'   => 'Projek Bulan ini',
                        ],
                        [
                            'color'     => 'light-blue',
                            'title'     => 'Projek Bulan ini',
                            'value'     => '120',
                            'caption'   => 'Projek Bulan ini',
                        ],
                        [
                            'color'     => 'light-danger',
                            'title'     => 'Projek Bulan ini',
                            'value'     => '120',
                            'caption'   => 'Projek Bulan ini',
                        ]
                    ];
                    ?>
                    <?php foreach( $cards as $card): ?>
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card card-<?php echo $card['color']; ?>">
                                <div class="card-body">                                    
                                    <p class="mb-4"><?php echo $card['title']; ?></p>
                                    <p class="fs-30 mb-2"><?php echo $card['value']; ?></p>
                                    <p><?php echo $card['caption']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
          </div>
        <?php
    }

    function render_page(){
        ob_start();
        $this->user_id = get_current_user_id();
        $this->sambutan();
        $this->cards();
        return ob_get_clean();
    }

}

// Inisialisasi class Page_Karyawan
new Page_Dashboard();