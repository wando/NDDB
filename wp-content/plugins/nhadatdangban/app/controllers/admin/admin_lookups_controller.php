<?php
/*
 * Lookups Controller
 * Author: Quang Do (quangdh81@gmail.com)
*/
class AdminLookupsController extends MvcAdminController {

    //setup default colums for index action
    var $default_columns = array('id');
    //setup for search
    var $default_searchable_fields = array('name','value','keywords');

    /**
     * Index action
     */
    public function index() {
        if (strpos($this->params['q'], "%") !== false) {
            $this->params['q'] = '\\' . $this->params['q'];
        }
        $this->process_params_for_search();        
        $this->params['selects'] = array('*');
        if (!isset($this->params['orderby'])) $this->params['orderby'] = 'id';
        if (!isset($this->params['order'])) $this->params['order'] = 'desc';
        $this->params['per_page'] = COUNT_IN_PAGE;
        if (!empty($this->params['lookup']) && $this->params['lookup'] != -1)
            $this->params['conditions'] = array('lookup' => $this->params['lookup']);

        $collection = $this->model->paginate($this->params);
        $this->set('objects', $collection['objects']);
        $this->set('record_count', $collection['record_count']);
        $this->set_pagination($collection);

        $this->set('objects_lookup', $objects_lookup);
    }

    /**
     * Add action
     */
    public function add() {
        if (!empty($this->params['data']) && !empty($this->params['data']['Lookup'])) {
            if (empty($object['id'])) {
                if (!$this->validateForm())
                    return;

                //set default values
                $user = wp_get_current_user();
                $this->params['data']['Lookup']['author'] = $user->ID;
                $this->params['data']['Lookup']['create_date'] = getDateTime("Y-m-d H:i:s");
                $this->params['data']['Lookup']['modify_date'] = getDateTime("Y-m-d H:i:s");

                //insert object to database
                $this->Lookup->create($this->params['data']);

                //get link update for object
                if ($this->Lookup->insert_id) {
                    $url = MvcRouter::admin_url(array('controller'=>$this->name, 'id' => $this->Lookup->insert_id, 'action' => 'edit'));
                    $this->flash('notice', '<p>New lookup created. <a href="' . $url . '">Edit lookup</a></p>');
                    $url = MvcRouter::admin_url(array('controller'=>$this->name, 'action' => 'index'));
                    $this->redirect($url);
                }
            }
        }
    }

    /**
     * Edit action
     */
    public function edit() {
        if (!empty($this->params['data']) && !empty($this->params['data']['Lookup'])) {
            if (!$this->validateForm()) {
                $this->setObject();
                return;
            }
			
            $user = wp_get_current_user();
			$this->params['data']['Lookup']['author'] = $user->ID;
			$this->params['data']['Lookup']['modify_date'] = getDateTime("Y-m-d H:i:s");

            //insert object to database
            $this->Lookup->save($this->params['data']);

            //show message success
            $url = MvcRouter::admin_url(array('controller' => $this->name, 'action' => 'index'));
            $this->flash('notice', '<p><strong>Lookup updated.</strong></p><p><a href="' . $url . '">← Back to Lookups</a></p>');
        }
        $this->setObject();
    }

    /**
     * check object is empty before set
     */
    private function setObject() {
        $id = isset($this->params['data']['Lookup']['id']) ? $this->params['data']['Lookup']['id'] : $this->params['id'];
        $newsEvent = $this->model->find_by_id($id);
        if (!empty($newsEvent) && is_numeric($id)) {
            $this->set_object();
        } else {
            $this->flash('error', ERR_MSG_CANT_FIND_OBJ);
        }
    }

    /**
     * validate form
     */
    private function validateForm() {
        //get parameters
        $name = $this->params['data']['Lookup']['name'];
        $value = $this->params['data']['Lookup']['value'];
        $keywords = $this->params['data']['Lookup']['keywords'];

        //validate input values
        $validation = new Validation();

        $validation->setRules($name, "Name", "required|max_lenght[150]");
        $validation->setRules($value, "Value", "required|max_lenght[150]");
        $validation->setRules($keywords, "Keywords", "required|max_lenght[150]");
        
        $errMessage = '';

        if (!$validation->checkValidate()) {
            $errors = $validation->getErrorMessages();
            foreach ($errors as $error) {
                $errMessage .= "<BR />" . $error;
            }
            $this->flash('error', substr($errMessage, 6));
            return false;
        } else {
            //check unique lookup id
            /*if ($this->model->checkExists('lookup_id', $lookup_id, $this->params['data']['Lookup']['id'])) {
                $this->flash('error', 'Lookup ID must be unique!');
                return false;
            }*/
        }
        return true;
    }

}