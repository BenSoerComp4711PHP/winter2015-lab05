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
        //present a quotation for adding/editing
        $this->data['fid'] = makeTextfield('ID#', 'id', $quote->id);
        $this->data['fwho'] = makeTextField('Author', 'who', $quote->who);
        $this->data['fmug'] = makeTextfield('Picture', 'mug', $quote->mug);
        $this->data['fwhat'] = makeTextArea('The Quote', 'what', $quote->what);
        $this->data['fsubmit'] = makeSubmitButton('Process Quote', "Click here to validate th quotation data", 'btn-success');

        $this->data['pagebody'] = 'quote_edit';
        $this->render();
    }

}