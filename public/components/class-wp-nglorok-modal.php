<?php

/**
 * Modal Component for Bootstrap 5.
 *
 * @package    Wp_Nglorok
 * @subpackage Wp_Nglorok/includes/components
 * @author     Velocity Developer <bantuanvelocity@gmail.com>
 */
class Wp_Nglorok_Modal {

    private $id;
    private $title;
    private $body;
    private $footer;

    public function __construct($args=null) {
        
        $defaults = array(
            'id'            => '',
            'title'         => 'Modal title',
            'body'          => '',
            'footer'        => '',
            'button-text'   => 'Launch Modal',
        );
        $this->args = wp_parse_args( $args, $defaults );

        $this->id       = $this->args['id'];
        $this->title    = $this->args['title'];
        $this->body     = $this->args['body'];
        $this->footer   = $this->args['footer'];
    }

    /**
     * Method untuk merender tombol dan modal.
     *
     * @return string
     */
    public function render() {
        ob_start(); ?>
        
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?php echo $this->id; ?>">
            <?php echo $this->args['button-text']; ?>
        </button>

        <!-- Modal -->
        <div class="modal fade" id="<?php echo $this->id; ?>" aria-labelledby="<?php echo $this->id; ?>Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="<?php echo $this->id; ?>Label"><?php echo $this->title; ?></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php echo $this->body; ?>
                    </div>
                    <?php if($this->footer): ?>
                        <div class="modal-footer">
                            
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php
        return ob_get_clean();
    }
}

// echo (new Wp_Nglorok_Modal('myModal', 'Confirmation', 'Are you sure you want to proceed?', 'Yes', 'No'))->render();
