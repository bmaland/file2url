<?php
require_once 'Zend/Controller/Action.php';

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        //      //Filter tags from the name field
        //      $filters = array(
        //     'name' => 'StripTags'
        //     );
        //     //Validate name is not less than 1 character and not more than 64
        //     $validation = array(
        //     'name' => array (
        //     array('StringLength', 1, 64)
        //     )
        //     );
        //     //Initialize Zend_Filter_Input (ZFI) passing it the entire getPost() array
        //     $zfi = new Zend_Filter_Input($filters, $validation, $request->getPost());
        //     //If the validators passed this will be true
        //     if ($zfi->isValid()) {
        //       //Fetch the data from zfi directly and create an array for Zend_Db
            //       $clean = array();
            //       $clean['name'] = $zfi->name;
            //       //Create an instance of the customers table and insert the $clean row
            //       $customers = new Customers();
            //       $customers->insert($clean);
            //       //Redirect to the display page after adding
            //       $this->getHelper('redirector')->goto('index');
            //     } else {
            //       //The form didn't validate, get the messages from ZFI
            //       foreach($zfi->getMessages() as $field=>$messages) {
            //         //Put each ZFI message into the FlashMessenger so it shows on the form
                //         foreach($messages as $message) {
                //           $this->getHelper('FlashMessenger')
                    //           ->addMessage($field . ' : '. $message);
                    //         }
                    //       }
                    //       //Redirect back to the input form, but with messages
                    //       $this->getHelper('redirector')->goto('add');
                    //     }
                    //    }
                    //    //Not a post request, check for flash messages and expose to the view
                    //    if($this->getHelper('FlashMessenger')->hasMessages()) {
                    //      $this->view->messages = $this->getHelper('FlashMessenger')->getMessages();
                        //    }
                        //  }
        }
    }
