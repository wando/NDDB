<?php
/* nhadatdangbanModel class
 * Overwrite model from wpmvc
 * Author: Quang Do (quangdh81@gmail.com)
*/
class nhadatdangbanModel extends MvcModel {

    /* Function paginate
     * Overwrite function paginate of wpmvc support for fix sort by ordering
     * Author: Quang Do (quangdh81@gmail.com)
    */
    public function paginate($options=array()) {
        $conditions = isset($options['conditions']) ? $options['conditions'] : "";
        $page       = isset($options['page'])       ? $options['page'] : 1;
        $per_page   = isset($options['per_page'])   ? $options['per_page'] : 10;
        $selects    = isset($options['selects'])    ? $options['selects'] : "";
        $orderby    = isset($options['orderby'])    ? $options['orderby'] : "";
        $ordertype  = isset($options['order'])      ? $options['order'] : "";
        $order = trim($orderby . ' ' . $ordertype);
        
        $object = $this->find_one(array(	
                                        'selects'       => array("id, count(id) as countrc"),
                                        'conditions'    => $conditions
                                    ));

        $count = (isset($object->countrc)) ? $object->countrc : 0;
        
        $limit      = ($page-1) * $per_page  . "," . $per_page;
        $page_total = ceil($count / $per_page);

        $objects = $this->find(array(	
                                        'selects'       => $selects,
                                        'limit'         => $limit, 
                                        'conditions'    => $conditions,
                                        'order'         => $order
                                    )
                                );

		$response = array(
			'objects'       => $objects,
			'total_pages'   => $page_total,
			'page'          => $page,
            'record_count'  => $count
		);
		return $response;
	}
    
    public function checkExists($field, $value, $primary_id) {      
        $conditions = array($field => $value, 'id !=' => $primary_id);
        $object = $this->find_one(array(	
                                        'selects'       => array("id, count(id) as countrc"),
                                        'conditions'    => $conditions
                                    ));

        $count = (isset($object->countrc)) ? $object->countrc : 0;
        
        return $count > 0;
    }
}