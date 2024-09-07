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

    public function __construct($id, $header,$body) {
        $this->id       = $id;
        $this->header   = $header;
        $this->body     = $body;
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
                        new DataTable('#<?php echo $this->id; ?>', {
                            responsive: true,
                            columnDefs: [
                                { responsivePriority: 1, targets: 0 },
                                { responsivePriority: 2, targets: -1 }
                            ]
                        });
                    });
                });
            </script>
            
        </div>
        <?php
    }

}