<?php 

namespace Models;

use Rain\Tpl;

class Page {

	private $tpl;
	private $options = [];
	private $defaults = [
		"header"=>true,
		"footer"=>true,
		"data"=>[
         "signin"=>0
      ]
	];

	public function __construct($opts = array(), $tpl_dir = "/views/"){
      
      if (   
         isset($_SESSION[SESSION_NAME]["_id"]) &&
         isset($_SESSION[SESSION_NAME]["uuid"]) &&
         isset($_SESSION[SESSION_NAME]["email"]) &&
         isset($_SESSION[SESSION_NAME]["username"])
      ){ 

         $this->defaults["data"] = [
            "signin"=>1
         ];

      }

		$this->options = array_merge($this->defaults, $opts);

		$config = array(
			"tpl_dir"	=> $_SERVER["DOCUMENT_ROOT"] . $tpl_dir,
			"cache_dir"	=> $_SERVER["DOCUMENT_ROOT"] . "/views-cache/",
			"debug" 	=> false
	    );

		Tpl::configure($config);

		// Add PathReplace plugin (necessary to load the CSS with path replace)
		Tpl::registerPlugin( new Tpl\Plugin\PathReplace());

		$this->tpl = new Tpl;

		$this->setData($this->options["data"]);

		if ($this->options["header"] === true) $this->tpl->draw("header");

	}

	private function setData($data = array())
	{

		foreach ($data as $key => $value) {
			$this->tpl->assign($key, $value);
		}

	}

	public function setTpl($name, $data = array(), $returnHTML = false)
	{

		$this->setData($data);

		return $this->tpl->draw($name, $returnHTML);

	}

	public function __destruct(){

		if ($this->options["footer"] === true) $this->tpl->draw("footer");

	}

}
