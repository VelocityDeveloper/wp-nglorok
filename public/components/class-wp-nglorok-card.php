<?php
/**
 * Modal Component for Card Bootstrap 5.
 *
 * @package    Wp_Nglorok
 * @subpackage Wp_Nglorok/includes/components
 * @author     Velocity Developer <bantuanvelocity@gmail.com>
 */
class Wp_Nglorok_Card {

    private $args;

    public function __construct(array $args) {

        $defaults = array(
            'card-title'    => '',
            'card-body'     => 'Card Content',
            'before-card'   => '',
            'after-card'    => '',
        );
        $this->args = wp_parse_args( $args, $defaults );

    }

    public function render(){
        if($this->args['before-card']){
            echo $this->args['before-card'];
        }
        ?>
        <div class="card">
            <div class="card-body">
                <?php if($this->args['card-title']){ ?>
                    <h4 class="card-title">
                        <?php echo $this->args['card-title']; ?>
                    </h4>
                <?php } ?>
                <?php echo $this->args['card-body']; ?>
            </div>
        </div>
        <?php
        if($this->args['after-card']){
            echo $this->args['after-card'];
        }
    }

}