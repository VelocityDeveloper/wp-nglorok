<?php
/**
 * Modal Component for dataTable Bootstrap 5.
 *
 * @package    Wp_Nglorok
 * @subpackage Wp_Nglorok/includes/components
 * @author     Velocity Developer <bantuanvelocity@gmail.com>
 */
class Wp_Nglorok_Table {

    private $id;
    private $header;
    private $body;
    private $args;

    public function __construct($id, $header,$body,$args=null) {
        $this->id       = $id;
        $this->header   = $header;
        $this->body     = $body;
     
        $defaults = array(
            'id'            => '',
            'header'        => '',
            'body'          => '',
            'datatables'    => [
                'ajax_action'   => '',
                'ordering'      => 'true',
            ],
        );
        $this->args = wp_parse_args( $args, $defaults );

    }

    public function render(){        
        ?>
        <div class="wp-nglorok-table">
            
            <table id="<?php echo $this->id; ?>" class="table table-striped nowrap">
                <?php if($this->header): ?>
                    <thead>
                        <tr>
                        <?php foreach( $this->header as $th){ ?>
                            <th>
                                <?php echo $th; ?>
                            </th>
                        <?php } ?>
                        </tr>
                    </thead>
                <?php endif; ?>
                <?php if($this->body): ?>
                <tbody>
                    <?php foreach( $this->body as $tr){ ?>
                        <tr>
                            <?php foreach( $tr as $td){ ?>
                                <td>
                                    <?php echo $td; ?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
                <?php endif; ?>
            </table>

            <script>
                jQuery(function($){
                    $( document ).ready(function() {
                        new DataTable('#<?php echo $this->id; ?>', {
                            responsive: true,
                            select: true,
                            stateSave: true,
                            columnDefs: [
                                { responsivePriority: 1, targets: 0 },
                                { responsivePriority: 2, targets: -1 }
                            ],
                            ordering: <?php echo $this->args['datatables']['ordering'] ?>,
                            <?php if(!empty($this->args['datatables']['ajax_action'])): ?>
                                'processing': true,
                                'serverSide': true,
                                'ajax' : {
                                    url: wpnglorok.ajaxUrl,
                                    'type': 'POST',
                                    data : {action: '<?php echo $this->args['datatables']['ajax_action'] ?>'}
                                },
                            <?php endif; ?>
                        });
                    });
                });
            </script>
            
        </div>
        <?php
    }

}