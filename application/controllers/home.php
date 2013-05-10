<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//home page when user first views
class Home extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->load->model('core/category_model');
		$this->load->model('core/user_model');
		$data['base'] = '/home';
		$data['pageIndex'] = 1;
		$data['category'] = '';
		$data['showNextPage'] = 'false';
		$data['username'] = $this->session->userdata('name');
		$data['isAdmin'] = ((isset($this->user_model->get_by_name($this->session->userdata('name'))->isAdmin) && $this->user_model->get_by_name($this->session->userdata('name'))->isAdmin == 1) ? 'true' : 'false');
		$data['navigationSelectedHot'] = true;		
		$data['categoriesResult'] = $this->category_model->get();
		
		$nextLinkCount = count($this->category_model->getLinks('', 2));
		if($nextLinkCount > 0){
			$data['showNextPage'] = 'true';
		}		
		
		$this->load->view('template/header', $data);
			$this->load->view('template/navigation', $data);
			$this->load->view('template/navigation_2', $data);
			$this->load->view('core/home');
		$this->load->view('template/footer');
	}
	
	public function page(){	
		$this->load->model('core/category_model');
		$this->load->model('core/user_model');
		$pageIndex = $this->uri->segment(3);
		if($pageIndex == ''){$pageIndex = 1;}

		$data['base'] = '/home';
		$data['pageIndex'] = $pageIndex;
		$data['category'] = '';
		$data['showNextPage'] = 'false';
		$data['username'] = $this->session->userdata('name');
		$data['isAdmin'] = ((isset($this->user_model->get_by_name($this->session->userdata('name'))->isAdmin) && $this->user_model->get_by_name($this->session->userdata('name'))->isAdmin == 1) ? 'true' : 'false');
		$data['navigationSelectedHot'] = true;
		$data['categoriesResult'] = $this->category_model->get();

		$nextLinkCount = count($this->category_model->getLinks('', ++$pageIndex));
		if($nextLinkCount > 0){
			$data['showNextPage'] = 'true';
		}

		$this->load->view('template/header', $data);
			$this->load->view('template/navigation', $data);
			$this->load->view('template/navigation_2', $data);
			$this->load->view('core/home');
		$this->load->view('template/footer');
	}

	public function latest(){
		$this->load->model('core/category_model');
		$this->load->model('core/user_model');

		$pageIndex = $this->uri->segment(3);
		if($pageIndex == ''){$pageIndex = 1;}
		$data['base'] = '/home';
		$data['latest'] = 'true';
		$data['category'] = '';
		$data['showNextPage'] = 'false';
		$data['pageIndex'] = $pageIndex;
		$data['username'] = $this->session->userdata('name');
		$data['isAdmin'] = ((isset($this->user_model->get_by_name($this->session->userdata('name'))->isAdmin) && $this->user_model->get_by_name($this->session->userdata('name'))->isAdmin == 1) ? 'true' : 'false');
		$data['navigationSelectedLatest'] = true;
		$data['categoriesResult'] = $this->category_model->get();
		
		$nextLinkCount = count($this->category_model->getLinksLatest('', ++$pageIndex));

		if($nextLinkCount > 0){
			$data['showNextPage'] = 'true';
		}

		$this->load->view('template/header', $data);			
			$this->load->view('template/navigation', $data);
			$this->load->view('template/navigation_2', $data);
			$this->load->view('core/home');
		$this->load->view('template/footer');
	}

	//this is returning the ajax call.
	public function load(){
		$this->load->model('core/category_model');
		$pageIndex = $this->uri->segment(3);
		if($pageIndex == ''){$pageIndex = 1;}
		
		$links = $this->category_model->getLinks('', $pageIndex);
		echo json_encode($links);
	}

	//this is returning the ajax call.
	public function load_latest(){
		$this->load->model('core/category_model');
		$pageIndex = $this->uri->segment(3);
		if($pageIndex == ''){$pageIndex = 1;}
		
		$links = $this->category_model->getLinksLatest('', $pageIndex);
		echo json_encode($links);
	}
}

?>