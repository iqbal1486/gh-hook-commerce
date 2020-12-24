<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class GH_CF7_Insightly_Mapping extends WP_List_Table {

	/** Class constructor */
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'Mapping', 'gh-cf7-insightly' ), //singular name of the listed records
			'plural'   => __( 'Mappings', 'gh-cf7-insightly' ), //plural name of the listed records
			'ajax'     => false //does this table support ajax?
		] );

	}


	/**
	 * Retrieve mappings data from the database
	 *
	 * @param int $per_page
	 * @param int $page_number
	 *
	 * @return mixed
	 */
	public static function get_mappings( $per_page = 5, $page_number = 1 ) {

		global $wpdb;

		$sql = "SELECT * FROM ".GH_CF7_INSIGHTLY_TABLE_MAPPING;

		if ( ! empty( $_REQUEST['orderby'] ) ) {
			$sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
			$sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
		}

		$sql .= " LIMIT $per_page";
		$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;


		$result = $wpdb->get_results( $sql, 'ARRAY_A' );

		return $result;
	}


	/**
	 * Delete a Mappings record.
	 *
	 * @param int $id Mappings id
	 */
	public static function delete_mappings( $id ) {
		global $wpdb;

		$wpdb->delete(
			"".GH_CF7_INSIGHTLY_TABLE_MAPPING,
			[ 'id' => $id ],
			[ '%d' ]
		);
	}


	/**
	 * Returns the count of records in the database.
	 *
	 * @return null|string
	 */
	public static function record_count() {
		global $wpdb;

		$sql = "SELECT COUNT(*) FROM ".GH_CF7_INSIGHTLY_TABLE_MAPPING;

		return $wpdb->get_var( $sql );
	}


	/** Text displayed when no mappings data is available */
	public function no_items() {
		_e( 'No mappings avaliable.', 'gh-cf7-insightly' );
	}


	/**
	 * Render a column when no column specific method exist.
	 *
	 * @param array $item
	 * @param string $column_name
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'form_ID':
			case 'module_name':
				return $item[ $column_name ];
			case 'mapping':
				if($item[ $column_name ]){
					$mapping_data = unserialize($item[ $column_name ]);
					$mapping_loop = "";
					foreach ($mapping_data as $key => $value) {
						if( !empty($value) ){
							$mapping_loop .= '<tr>
							    <td>'.$key.'</td>
							    <td>'.$value.'</td>
							</tr>';	
						}
					}
				}
				$html = '<style>
					table.inner-table {
					  font-family: arial, sans-serif;
					  border-collapse: collapse;
					  width: 100%;
					}

					table.inner-table td, table.inner-table th {
					  border: 1px solid #dddddd;
					  text-align: left;
					  padding: 8px;
					}

					table.inner-table tr:nth-child(even) {
					  background-color: #dddddd;
					}
				</style>
				<table class="inner-table">
				  <tr>
				    <th><b>Insightly Fields</b></th>
				    <th><b>Contact Fields</b></th>
				  </tr>
				  '.$mapping_loop.'
				</table>';
				return $html;
			default:
				return print_r( $item, true ); //Show the whole array for troubleshooting purposes
		}
	}

	/**
	 * Render the bulk edit checkbox
	 *
	 * @param array $item
	 *
	 * @return string
	 */
	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id']
		);
	}


	/**
	 * Method for name column
	 *
	 * @param array $item an array of DB data
	 *
	 * @return string
	 */
	function column_form_ID( $item ) {

		$delete_nonce = wp_create_nonce( 'sp_delete_mappings' );
		$edit_nonce = wp_create_nonce( 'gh_cf7_insightly_add_new_mapping_nonce' );

		$title = '<strong>' . $item['form_ID'] . '</strong>';

		$actions = [
			'delete' => sprintf( '<a href="?page=%s&tab=mapping&action=%s&mapping_id=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce ),
			'edit' => sprintf( '<a href="?page=%s&tab=mapping&action=%s&module_name=%s&form_id=%s&gh_cf7_insightly_add_new_mapping_nonce_field=%s">Edit</a>', esc_attr( $_REQUEST['page'] ), 'edit', $item['module_name'] , absint( $item['form_ID'] ), $edit_nonce )
		];

		return $title . $this->row_actions( $actions );
	}


	/**
	 *  Associative array of columns
	 *
	 * @return array
	 */
	function get_columns() {
		$columns = [
			'cb'      		=> '<input type="checkbox" />',
			'form_ID'    	=> __( 'CF7 Form ID', 'gh-cf7-insightly' ),
			'module_name'   => __( 'Module Name', 'gh-cf7-insightly' ),
			'mapping' 		=> __( 'Mapping', 'gh-cf7-insightly' ),
			
		];

		return $columns;
	}


	/**
	 * Columns to make sortable.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'form_ID' => array( 'form_ID', true ),
			'module_name' => array( 'module_name', false )
		);

		return $sortable_columns;
	}

	/**
	 * Returns an associative array containing the bulk action
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions = [
			'bulk-delete' => 'Delete'
		];

		return $actions;
	}


	/**
	 * Handles data query and filter, sorting, and pagination.
	 */
	public function prepare_items() {

		$this->_column_headers = $this->get_column_info();

		/** Process bulk action */
		$this->process_bulk_action();

		$per_page     = $this->get_items_per_page( 'mappings_per_page', 10 );
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count();

		$this->set_pagination_args( [
			'total_items' => $total_items, //WE have to calculate the total number of items
			'per_page'    => $per_page //WE have to determine how many items to show on a page
		] );

		$this->items = self::get_mappings( $per_page, $current_page );
	}

	public function process_bulk_action() {

		//Detect when a bulk action is being triggered...
		if ( 'delete' === $this->current_action() ) {

			// In our file that handles the request, verify the nonce.
			$nonce = esc_attr( $_REQUEST['_wpnonce'] );

			if ( ! wp_verify_nonce( $nonce, 'sp_delete_mappings' ) ) {
				die( 'Go get a life script kiddies' );
			}
			else {
				self::delete_mappings( absint( $_GET['mapping_id'] ) );

		                wp_redirect( GH_CF7_INSIGHTLY_MAPPING_URL );
				exit;
			}

		}

		// If the delete bulk action is triggered
		if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
		     || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
		) {

			$delete_ids = esc_sql( $_POST['bulk-delete'] );

			// loop over the array of record IDs and delete them
			foreach ( $delete_ids as $id ) {
				self::delete_mappings( $id );

			}

	        wp_redirect( GH_CF7_INSIGHTLY_MAPPING_URL );
			exit;
		}
	}

}
?>