<?php
class FacebooksController extends AppController{

	public $Users;

	/**
	 * Facebook Authentification
	 */
	public function facebook(){
		require Configure::read('Plugin.Facebook.facebook.facebookSDK');
		$this->Users = ClassRegistry::init('User');
		$this->Session->read();

		$appId = Configure::read('Plugin.Facebook.facebook.appID');
		$secret= Configure::read('Plugin.Facebook.facebook.secretKey');

		$FB = new Facebook(array("appId"=>$appId,"secret"=>$secret));
		$user =  $FB->getUser();
		
		//if an user want to connect
		if($user){
			//If he send an Username
			if($this->request->is('post')){
				$infos = $FB->api("/me");
				$data = $this->request->data;

				$d = array(
					'username'=>$data['username'],
					'facebook_id'=>$infos['id'],
					"role"=>"users",
					'email'=>$infos['email'],
					"activate"=>1
				);
				if( $this->Users->save($d) ){
					$this->Session->SetFlash('Merci de vous être enregistré. Vous êtes maintenant connecté.');
					$us = $this->Users->read();
					$this->Auth->login($us['User']);
					$this->redirect('/');
				}
			}else{
				//Check if an user exist in the db
				$u = $this->Users->find('first',array(
					'recursive'=> -1,
					'conditions'=>array('facebook_id'=>$user)
				));
				if(!empty($u)){
					$this->Auth->login($u['User']);
					$this->redirect('/');
				}
			}
		}else{
			$this->Session->SetFlash('Il y a un problème d\'identification.');
			$this->redirect("/");
		}

		
	}


}