<?php
/**
 * Table Component for Bootstrap 5.
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

    /**
     * Constructor to initialize the table component with arguments.
     *
     * @param array|null $args Arguments for customizing the table component.
     */
    public function __construct($args = null) {

        // Default values for the table component
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
        
        // Parse the provided arguments with the defaults
        $this->args = wp_parse_args($args, $defaults);

        $this->id       = esc_attr($this->args['id']);
        $this->header   = $this->args['header'];
        $this->body     = $this->args['body'];
    }

    /**
     * Render the table component.
     *
     * @return string The HTML output of the table component.
     */
    public function render() {
        ob_start();
        ?>
        <div class="wp-nglorok-table">
            <table id="<?php echo esc_attr($this->id); ?>" class="table table-striped nowrap">
                <?php if (!empty($this->header)): ?>
                    <thead>
                        <tr>
                            <?php foreach ($this->header as $th): ?>
                                <th><?php echo esc_html($th); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                <?php endif; ?>
                
                <?php if (!empty($this->body)): ?>
                    <tbody>
                        <?php foreach ($this->body as $tr): ?>
                            <tr>
                                <?php foreach ($tr as $td): ?>
                                    <td><?php echo esc_html($td); ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                <?php endif; ?>
            </table>
        </div>
        <script>
            jQuery(function($) {
                function initDataTable() {
                    return new DataTable('#<?php echo esc_js($this->id); ?>', {
                        autoWidth: false, // Disable automatic column width calculation
                        responsive: {
                            details: {
                                display: DataTable.Responsive.display.modal({
                                    header: function(row) {
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
                            if (!empty($this->args['datatables']['columnDefs'])) {
                                echo $this->args['datatables']['columnDefs'];
                            }
                            ?>
                        ],
                        ordering: <?php echo esc_js($this->args['datatables']['ordering']); ?>,
                        <?php if (!empty($this->args['datatables']['ajax_action'])): ?>
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: wpnglorok.ajaxUrl,
                            type: 'POST',
                            data: function(d) {
                                d.action = '<?php echo esc_js($this->args['datatables']['ajax_action']); ?>';
                                <?php
                                if (!empty($this->args['datatables']['ajax_data'])) {
                                    foreach ($this->args['datatables']['ajax_data'] as $id_data) {
                                        echo "d.$id_data = $('#" . esc_js($id_data) . "').val();";
                                    }
                                }
                                ?>
                            }
                        },
                        <?php endif; ?>
                        <?php
                        if (!empty($this->args['datatables']['params'])) {
                            echo $this->args['datatables']['params'];
                        }
                        ?>
                    });
                }

                var table = initDataTable();

                <?php if (!empty($this->args['datatables']['ajax_reload'])): ?>
                    $(document).on('click', '<?php echo esc_js($this->args['datatables']['ajax_reload']); ?>', function() {
                        table.state.clear();
                        table.destroy(); // Destroy the old instance
                        table = initDataTable(); // Reinitialize with new filters
                    });
                <?php endif; ?>
            });
        </script>
        <?php
        return ob_get_clean();
    }
}
