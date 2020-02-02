<?php

namespace DHafez;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class List_Table extends \WP_List_Table {

	/**
	 * Wordpress Database
	 *
	 * @var string
	 */
	protected $db;

	/**
	 * Limits per page
	 *
	 * @var int
	 */
	protected $limit;

	/**
	 * Count all Records 1 time
	 *
	 * @var int
	 */
	protected $count;

	/**
	 * Store Queries Data
	 *
	 * @var array
	 */
	var $data;

	public function __construct() {

	}

	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'id':
			case 'name':
			case 'text':
			case 'url':
				return $item[ $column_name ];
			case 'created':
				return sprintf( __( '%s <span class="time">Time: %s</span>', 'DHafez' ), date_i18n( 'Y-m-d', strtotime( $item[ $column_name ] ) ), date_i18n( 'H:i:s', strtotime( $item[ $column_name ] ) ) );
			default:
				return print_r( $item, true ); //Show the whole array for troubleshooting purposes
		}
	}

	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/*$1%s*/
			$this->_args['singular'],
			/*$2%s*/
			$item['id']
		);
	}

	public function get_columns() {
		$columns = array(
			'cb'      => '<input type="checkbox" />',
			'created' => __( 'Created', 'DHafez' ),
			'name'    => __( 'Name', 'DHafez' ),
			'text'    => __( 'Text', 'DHafez' ),
			'url'     => __( 'URL', 'DHafez' ),
		);

		return $columns;
	}

	public function get_sortable_columns() {
		$sortable_columns = array(
			'id'      => array( 'id', true ),
			'created' => array( 'created', false ),
			'name'    => array( 'name', false ),
			'text'    => array( 'text', false ),
			'url'     => array( 'url', false ),
		);

		return $sortable_columns;
	}

	public function get_bulk_actions() {
		$actions = array(
			'bulk_delete' => __( 'Delete', 'DHafez' )
		);

		return $actions;
	}

	public function process_bulk_action() {

		//Detect when a bulk action is being triggered...
		// Search action
		if ( isset( $_GET['s'] ) ) {
			$prepare     = $this->db->prepare( "SELECT * from `{$this->db->prefix}DHafez_table` WHERE name LIKE %s OR text LIKE %s", '%' . $this->db->esc_like( $_GET['s'] ) . '%', '%' . $this->db->esc_like( $_GET['s'] ) . '%' );
			$this->data  = $this->get_data( $prepare );
			$this->count = $this->get_total( $prepare );
		}

		// Bulk delete action
		if ( 'bulk_delete' == $this->current_action() ) {
			foreach ( $_GET['id'] as $id ) {
				$this->db->delete( $this->db->prefix . "DHafez_table", array( 'id' => $id ) );
			}
			$this->data  = $this->get_data();
			$this->count = $this->get_total();
			echo '<div class="notice notice-success is-dismissible"><p>' . __( 'Items removed.', 'DHafez' ) . '</p></div>';
		}

		// Single delete action
		if ( 'delete' == $this->current_action() ) {
			$this->db->delete( $this->db->prefix . "DHafez_table", array( 'id' => $_GET['id'] ) );
			$this->data  = $this->get_data();
			$this->count = $this->get_total();
			echo '<div class="notice notice-success is-dismissible"><p>' . __( 'Item removed.', 'DHafez' ) . '</p></div>';
		}
	}

	public function prepare_items() {
		/**
		 * First, lets decide how many records per page to show
		 */
		$per_page = $this->limit;

		/**
		 * REQUIRED. Now we need to define our column headers. This includes a complete
		 * array of columns to be displayed (slugs & titles), a list of columns
		 * to keep hidden, and a list of columns that are sortable. Each of these
		 * can be defined in another method (as we've done here) before being
		 * used to build the value for our _column_headers property.
		 */
		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = $this->get_sortable_columns();

		/**
		 * REQUIRED. Finally, we build an array to be used by the class for column
		 * headers. The $this->_column_headers property takes an array which contains
		 * 3 other arrays. One for all columns, one for hidden columns, and one
		 * for sortable columns.
		 */
		$this->_column_headers = array( $columns, $hidden, $sortable );

		/**
		 * Optional. You can handle your bulk actions however you see fit. In this
		 * case, we'll handle them within our package just to keep things clean.
		 */
		$this->process_bulk_action();

		/**
		 * Instead of querying a database, we're going to fetch the example data
		 * property we created for use in this plugin. This makes this example
		 * package slightly different than one you might build on your own. In
		 * this example, we'll be using array manipulation to sort and paginate
		 * our data. In a real-world implementation, you will probably want to
		 * use sort and pagination data to build a custom query instead, as you'll
		 * be able to use your precisely-queried data immediately.
		 */
		$data = $this->data;

		/**
		 * This checks for sorting input and sorts the data in our array accordingly.
		 *
		 * In a real-world situation involving a database, you would probably want
		 * to handle sorting by passing the 'orderby' and 'order' values directly
		 * to a custom query. The returned data will be pre-sorted, and this array
		 * sorting technique would be unnecessary.
		 */


		/**
		 * REQUIRED for pagination. Let's check how many items are in our data array.
		 * In real-world use, this would be the total number of items in your database,
		 * without filtering. We'll need this later, so you should always include it
		 * in your own package classes.
		 */
		$total_items = $this->count;

		/**
		 * REQUIRED. Now we can add our *sorted* data to the items property, where
		 * it can be used by the rest of the class.
		 */
		$this->items = $data;


	}

	/**
	 * Usort Function
	 *
	 * @param $a
	 * @param $b
	 *
	 * @return array
	 */
	public function usort_reorder( $a, $b ) {
		$orderby = ( ! empty( $_REQUEST['orderby'] ) ) ? $_REQUEST['orderby'] : 'id'; //If no sort, default to sender
		$order   = ( ! empty( $_REQUEST['order'] ) ) ? $_REQUEST['order'] : 'desc'; //If no order, default to asc
		$result  = strcmp( $a[ $orderby ], $b[ $orderby ] ); //Determine sort order

		return ( $order === 'asc' ) ? $result : - $result; //Send final sort direction to usort
	}

	//set $per_page item as int number
	public function get_data( $query = '' ) {
		$page_number = ( $this->get_pagenum() - 1 ) * $this->limit;
		if ( ! $query ) {
			$query = 'SELECT * FROM `' . $this->db->prefix . 'DHafez_table` LIMIT ' . $this->limit . ' OFFSET ' . $page_number;
		} else {
			$query .= ' LIMIT ' . $this->limit . ' OFFSET ' . $page_number;
		}
		$result = $this->db->get_results( $query, ARRAY_A );

		return $result;
	}

	//get total items on different Queries
	public function get_total( $query = '' ) {
		if ( ! $query ) {
			$query = 'SELECT * FROM `' . $this->db->prefix . 'DHafez_table`';
		}
		$result = $this->db->get_results( $query, ARRAY_A );
		$result = count( $result );

		return $result;
	}

}