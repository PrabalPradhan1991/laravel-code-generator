<?php

class SystemController extends Controller
{
	public function removeGlobal()
	{
		if(Session::has('global'))
			Session::forget('global');
	}

	
	public function home()
	{
		return View::make($this->view.'home');
	}
	
	public function validateInput($modelName, $data, $update = false)
	{
		if($update)
		{
			$validator = Validator::make($data, $modelName::$updateRule);	
			//make($input, $condition)
		}
		else
		{
			$validator = Validator::make($data, $modelName::$createRule);
		}
		

		if($validator->fails())
		{
			$arr = array('status' => 'error', 'message' => $validator->messages());
		}
		else
		{
			$arr = array('status' => 'success');
		}

		return $arr;
	}

	public function storeInDatabase($modelName, $dataToStore) //dataToStore must be associative array
	{

		if(isset($dataToStore["_token"]))
		{
			unset($dataToStore['_token']);
		}

		if(isset($dataToStore['addNew']))
		{
			unset($dataToStore['addNew']);
		}

		
		try
		{
			$result = $modelName::create($dataToStore)->id;
		}
		catch(PDOException $e)
		{
			$arr = array('status' => 'error', 'message' => $e->getMessage());
			return $arr;
		}
		
		$arr = array('status' => 'success', 'message' => 'Successfully stored in database', 'data' => $result);
		return $arr;
	}

	protected function updateInDatabase($modelName, $data)
	{
		if(isset($data['_token']))
		{
			unset($data['_token']);
		}

		try
		{
			$result = $modelName::where('id', $data['id'])
								->update($data);
		}
		catch(PDOException $e)
		{
			$arr = array('status' => 'error', 'message' => $e->getMessage());
			return $arr;
		}

		$arr = array('status' => 'success', 'message' => 'Successfully updated', 'data' => $data);
		return $arr;
	}

	public function sendMailFunction($view, $parameters, $mailDetails, $subject)
	{
			try{

                Mail::queue($view, $parameters, function($message) use ($mailDetails, $subject){
    			$message->to($mailDetails['email'], $mailDetails['firstname'])
    					->subject($subject);
    			});
            }catch(Exception $e)
            {
                return $e->getMessage();
            }
		
        return 'success';
			/*return 'OK';
		else
			return Mail::failures();*/
	}

		/*if ( ! Mail::send(array('text' => 'view'), $data, $callback) )
{
   return View::make('errors.sendMail');
}
You will know when it was sent or not, but it could be better, because SwiftMailer knows to wich recipients it failed, but Laravel is not exposing the related parameter to help us get that information:
*/
/**
 * Send the given Message like it would be sent in a mail client.
 *
 * All recipients (with the exception of Bcc) will be able to see the other
 * recipients this message was sent to.
 *
 * Recipient/sender data will be retrieved from the Message object.
 *
 * The return value is the number of recipients who were accepted for
 * delivery.
 *
 * @param Swift_Mime_Message $message
 * @param array              $failedRecipients An array of failures by-reference
 *
 * @return integer
 */
/*
public function send(Swift_Mime_Message $message, &$failedRecipients = null)
{
    $failedRecipients = (array) $failedRecipients;

    if (!$this->_transport->isStarted()) {
        $this->_transport->start();
    }

    $sent = 0;

    try {
        $sent = $this->_transport->send($message, $failedRecipients);
    } catch (Swift_RfcComplianceException $e) {
        foreach ($message->getTo() as $address => $name) {
            $failedRecipients[] = $address;
        }
    }

    return $sent;
}
But you can extend Laravel's Mailer and add that functionality ($failedRecipients) to the method send of your new class.

EDIT

In 4.1 you can now have access to failed recipients using

Mail::failures();
	}
*/	

	private function getTableHeaders($controller_name)
	{
		//find controller_id from controller_name
		$data = ListHeaderTable::join(Module::getTableName().' as M', 'M.id', '=', 'controller_id')
								->select(ListHeaderTable::getTableName().'.*')
								->where('M.is_active', 1)
								->where(ListHeaderTable::getTableName().'.is_active', 1)
								->where('M.module_name', $controller_name)
								->get();

		$count = count($data);

		return array('count' => $count, 'data' => $data);

		//getHeaders


	}

	private function checkForUniqueContstraint($column_name)
	{
		
	} 

}

?>