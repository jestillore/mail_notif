<?php

/**
 * Mail Notifier plugin
 * @author Jillberth Estillore <jestillore@zoogtech.com>
 */

include 'config.php';

class mail_notif extends rcube_plugin
{
	public $task = 'mail';
	public $rc;

	public function init()
	{
		$this->rc = rcmail::get_instance();
		$this->add_hook('new_messages', array($this, 'notify'));
		$this->include_script('mail_notif.js');
		if(file_exists('./plugins/mail_notif/config.inc.php'))
		{
			$this->load_config('config.inc.php');
		}
	}

	public function notify($mailbox)
	{
		if($mailbox['mailbox'] == 'INBOX') {
			$this->rc->storage->set_mailbox($mailbox['mailbox']);
			$this->rc->storage->search($mailbox['mailbox'], "RECENT", null);
			$msgs = (array) $this->rc->storage->list_headers($mailbox['mailbox']);
			foreach ($msgs as $msg) {
			    $from = $msg->from;
				$subject = $msg->subject;
	            if(strtolower($_SESSION['username']) == strtolower($this->rc->user->data['username']))
	            {
	            	$data = array(
	                    'subject' => $subject,
	                    'from' => $from,
	                    'uid' => $msg->uid.'&_mbox='.$mailbox['mailbox'],
	                );
	                $this->rc->output->command("plugin.mail_notif", $data);
	            }
	        }
			$this->rc->storage->search($mailbox['mailbox'], "ALL", null);
		}
		return $mailbox;
	}
}
