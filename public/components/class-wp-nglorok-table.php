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
            'datatables'    => '',
            'js'            => '',
        );
        $this->args = wp_parse_args( $args, $defaults );

    }

    public function render(){        
        ?>
        <div class="wp-nglorok-table">
            
            <table id="<?php echo $this->id; ?>" class="table table-striped nowrap">
                <thead>
                    <tr>
                    <?php foreach( $this->header as $th){ ?>
                        <th>
                            <?php echo $th; ?>
                        </th>
                    <?php } ?>
                    </tr>
                </thead>
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
            </table>

            <script>
                jQuery(function($){
                    $( document ).ready(function() {
                        <?php if(!empty($this->args['datatables'])): ?>
                            <?php
                            $dt = $this->args['datatables'];
                            ?>
                            new DataTable('#<?php echo $this->id; ?>', {
                                'processing': true,
                                'serverSide': true,
                                'ajax' : {
                                    url: wpnglorok.ajaxUrl,
                                    // 'type': 'POST',
                                    data : {action: '<?php echo $dt['ajax_action']; ?>'}
                                },
                                columns: [
                { data: 'RecordID' },
                { data: 'Name' },
                { data: 'Email' },
                { data: 'Company' },
                { data: 'CreditCardNumber' },
                { data: 'Datetime' },
                { data: null },
            ],
                            });

                            jQuery.ajax({
                                type: "POST",
                                url: wpnglorok.ajaxUrl,
                                data: { action: '<?php echo $dt['ajax_action']; ?>' },
                                success: function (respon) {
                                    console.log(respon);
                                },
                            });

                        <?php else: ?>
                            new DataTable('#<?php echo $this->id; ?>', {
                                responsive: true,
                                columnDefs: [
                                    { responsivePriority: 1, targets: 0 },
                                    { responsivePriority: 2, targets: -1 }
                                ]
                            });
                        <?php endif; ?>
                    });
                });
            </script>
            
        </div>
        <?php
    }

}