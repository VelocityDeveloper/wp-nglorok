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

    public function __construct($args=null) {
     
        $defaults = array(
            'id'            => '',
            'header'        => '',
            'body'          => '',
            'datatables'    => [
                'params'        => '',
                'ordering'      => 'true',
                'columnDefs'    => '',
                'ajax_action'   => '',
                'ajax_data'     => '',
                'ajax_reload'   => '',
            ],
        );
        $this->args = wp_parse_args( $args, $defaults );
        
        $this->id       = $this->args['id'];
        $this->header   = $this->args['header'];
        $this->body     = $this->args['body'];

    }

    public function render(){   
        ob_start();     
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

                    function data_ajax(){
                        var result = 

                        return result;
                    }

                    $( document ).ready(function() {

                        var table = new DataTable('#<?php echo $this->id; ?>', {
                            // responsive: true,
                            responsive: {
                                details: {
                                    display: DataTable.Responsive.display.modal({
                                        header: function (row) {
                                            var data = row.data();
                                            return 'Details for ' + data[0];
                                        }
                                    }),
                                    renderer: DataTable.Responsive.renderer.tableAll({
                                        tableClass: 'tablex'
                                    })
                                }
                            },
                            fixedHeader: true,
                            select: true,
                            stateSave: true,
                            columnDefs: [
                                { responsivePriority: 1, targets: 0 },
                                { responsivePriority: 2, targets: -1 },                                
                                <?php
                                if(!empty($this->args['datatables']['columnDefs'])):
                                    echo $this->args['datatables']['columnDefs'];
                                endif;
                                ?>
                            ],
                            ordering: <?php echo $this->args['datatables']['ordering'] ?>,
                            <?php if(!empty($this->args['datatables']['ajax_action'])): ?>
                                'processing': true,
                                'serverSide': true,
                                'ajax' : {
                                    url: wpnglorok.ajaxUrl,
                                    'type': 'POST',
                                    data : {
                                        action: '<?php echo $this->args['datatables']['ajax_action'] ?>',
                                        <?php
                                        if(!empty($this->args['datatables']['ajax_data'])):
                                            foreach ($this->args['datatables']['ajax_data'] as $id_data) {
                                                echo $id_data.": $('#".$id_data."').val(),";
                                            }
                                        endif;
                                        ?>
                                    },
                                },
                            <?php endif; ?>
                            <?php
                            if(!empty($this->args['datatables']['params'])):
                                echo $this->args['datatables']['params'];
                            endif;
                            ?>
                        });

                        <?php if(!empty($this->args['datatables']['ajax_reload'])): ?>
                            $(document).on('click','<?php echo $this->args['datatables']['ajax_reload']; ?>', function(){
                                table.ajax.reload(null, true);
                                <?php
                                if(!empty($this->args['datatables']['ajax_data'])):
                                    foreach ($this->args['datatables']['ajax_data'] as $id_data) {
                                        // echo $id_data.": $('#".$id_data."').val(),";
                                        echo "console.log($('#".$id_data."').val());";
                                    }
                                endif;
                                ?>
                            });
                        <?php endif; ?>

                    });
                });
            </script>
            
        </div>
        <?php
        return ob_get_clean();
    }

}