<?php
/**
 * Created by PhpStorm.
 * User: ben
 * Date: 18/02/15
 * Time: 10:29 AM
 */

class Admin extends Application{

    function __construct()
    {
        parent::__construct();
    }

    function index(){
        $this->data['title'] = 'Quotations Maintenance';
        $this->data['quotes'] = $this->quotes->all();
        $this->data['pagebody'] = 'admin_list';
        $this->render();
    }

    function add(){
        $quote = $this->quotes->create();
        $this->present($quote);
    }

    function present($quote){
        $message = '';
        if(count($this->errors)  > 0){
            foreach($this->errors as $booboo){
                $message .= $booboo . BR;
            }
        }
        $this->data['message'] = $message;

        //present a quotation for adding/editing
        $this->data['fid'] = makeTextfield('ID#', 'id', $quote->id, "Unique quote identifier, system-assigned", 10, 10, true);
        $this->data['fwho'] = makeTextField('Author', 'who', $quote->who);
        $this->data['fmug'] = makeTextfield('Picture', 'mug', $quote->mug);
        $this->data['fwhat'] = makeTextArea('The Quote', 'what', $quote->what, "", 200);
        $this->data['fsubmit'] = makeSubmitButton('Process Quote', "Click here to validate th quotation data", 'btn-success');

        $this->data['pagebody'] = 'quote_edit';
        $this->render();
    }

    function confirm(){

        $record = $this->quotes->create();

        $record->id = $this->input->post('id');
        $record->who = $this->input->post('who');
        $record->mug = $this->input->post('mug');
        $record->what = $this->input->post('what');

        //validation
        if(empty($record->who)){
            $this->errors[] = 'You must specify an author';
        }
        if(strlen($record->what) < 20){
            $this->errors[] = "A quotation must be at least 20 characters long.";
        }

        //redisplay if errors
        if(count($this->errors) > 0){
            $this->present($record);
            return; // don't save
        }

        //save / update content
        if(empty($record->id)){
            $this->quotes->add($record);
        }else{
            $this->quotes->update($record);
        }

        redirect('/admin');
    }

}