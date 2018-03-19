<?php

namespace APITools;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class APITools extends PluginBase{

	public function onEnable(){
		$folder = $this->getDataFolder();
		if(!file_exists($folder)) mkdir($folder);
		$server = $this->getServer();
		$this->api = $server->getApiVersion();
		$this->logger = $server->getLogger();
		$glob = glob($folder.'{*.phar,*/plugin.yml}', GLOB_BRACE);
		foreach($glob as $value){
			if(is_file($value)){
				$pathinfo = pathinfo($value);
				if($pathinfo['extension'] == 'phar'){
					try{
						$phar = new \Phar($value);
						if(isset($phar['plugin.yml'], $phar['src']))
							$this->change($phar['plugin.yml'], $phar['src']);
					}catch(\Exception $e){
						$this->logger->error("[APITools] ファイルが読み込めませんでした '{$pathinfo['basename']}'");
					}
				}elseif($pathinfo['extension'] == 'yml'){
					if(file_exists($value) and file_exists($pathinfo['dirname'].'\src'))
						$this->change($value, $pathinfo['dirname'].'\src');
				}
			}
		}
	}

	public function change($dir_yml, $dir_src){
		$config = new Config($dir_yml, Config::YAML);
		if($config->exists('api') and $config->exists('name') and $config->exists('main') and $config->exists('version')){
			$this->changeApi($config);
			$this->changeType($config, $dir_src);
		}
	}

	public function changeApi($config){
		$api = $config->get('api');
		$name = $config->get('name');
		if(is_array($api)){
			if(!in_array($this->api, $api)){
				$api[] = $this->api;
				$config->set('api', $api);
				$config->save();
				$this->logger->info("§a[APITools] '$name'を'API[$this->api]'に対応させました");
			}
		}else{
			if($api != $this->api){
				$config->set('api', [$api, $this->api]);
				$config->save();
				$this->logger->info("§e[APITools] '$name'を'API[$this->api]'に対応させました");
			}
		}
	}

	public function changeType($config, $dir_src){
		$main = $config->get('main');
		$dir_main = "{$dir_src}/{$main}.php";
		if(file_exists($dir_main) and is_file($dir_main)){
			$name = $config->get('name');
			$this->changeOnCommand($dir_main, $name);
			$this->changeOnRun($dir_main, $name);
		}
	}

	public function changeOnCommand($dir_main, $name){
		$source = file_get_contents($dir_main);
		$strlen = strlen($source);
		for($a = 0; $a < $strlen; ++$a){
			if($source[$a] == 'f' or $source[$a] == 'F'){
			if($source[$a + 1] == 'u' or $source[$a + 1] == 'U'){
			if($source[$a + 2] == 'n' or $source[$a + 2] == 'N'){
			if($source[$a + 3] == 'c' or $source[$a + 3] == 'C'){
			if($source[$a + 4] == 't' or $source[$a + 4] == 'T'){
			if($source[$a + 5] == 'i' or $source[$a + 5] == 'I'){
			if($source[$a + 6] == 'o' or $source[$a + 6] == 'O'){
			if($source[$a + 7] == 'n' or $source[$a + 7] == 'N'){
			if($source[$a + 8]== ' '){
			for($b = $a + 9; $b < $strlen; ++$b){
				if($source[$b] != ' '){
				if($source[$b] == 'o'){
				if($source[$b + 1] == 'n'){
				if($source[$b + 2] == 'C'){
				if($source[$b + 3] == 'o'){
				if($source[$b + 4] == 'm'){
				if($source[$b + 5] == 'm'){
				if($source[$b + 6] == 'a'){
				if($source[$b + 7] == 'n'){
				if($source[$b + 8] == 'd'){
				for($c = $b + 9; $c < $strlen; ++$c){
					if($source[$c] != ' '){
					if($source[$c] == '('){
					for($d = $c + 1; $d < $strlen; ++$d){
						if($source[$d] == ')'){
						for($e = $d + 1; $e < $strlen; ++$e){
							if($source[$e] != ' '){
							if($source[$e] == '{'){
								$function[] = [$a, $e];
								break 4;
							}else break 4;
							}
						}
						}
					}
					}else break 2;
					}
				}
				}else break;
				}else break;
				}else break;
				}else break;
				}else break;
				}else break;
				}else break;
				}else break;
				}else break;
				}
			}
			}
			}
			}
			}
			}
			}
			}
			}
			}
		}
		if(isset($function)){
			foreach($function as $value){
				$strlen = ($value[1] - $value[0]) + 1;
				if($strlen >= 32 and $strlen <= 130){
					$string = [];
					for($a = $value[0]; $a <= $value[1]; ++$a) 
						$string[] = $source[$a];
					$implode[] = implode('', $string);
				}
			}
			if(isset($implode)){
				$replace_function = str_replace('{', ' : bool{', $implode);
				$replace_source = str_replace($implode, $replace_function, $source);
				file_put_contents($dir_main, $replace_source);
				$this->logger->info("§e[APITools] '$name'の'onCommand'を古い型から新しい型にしました");
			}
		}
	}

	public function changeOnRun($dir_main, $name){
		$source = file_get_contents($dir_main);
		$strlen = strlen($source);
		for($a = 0; $a < $strlen; ++$a){
			if($source[$a] == 'f' or $source[$a] == 'F'){
			if($source[$a + 1] == 'u' or $source[$a + 1] == 'U'){
			if($source[$a + 2] == 'n' or $source[$a + 2] == 'N'){
			if($source[$a + 3] == 'c' or $source[$a + 3] == 'C'){
			if($source[$a + 4] == 't' or $source[$a + 4] == 'T'){
			if($source[$a + 5] == 'i' or $source[$a + 5] == 'I'){
			if($source[$a + 6] == 'o' or $source[$a + 6] == 'O'){
			if($source[$a + 7] == 'n' or $source[$a + 7] == 'N'){
			if($source[$a + 8]== ' '){
			for($b = $a + 9; $b < $strlen; ++$b){
				if($source[$b] != ' '){
				if($source[$b] == 'o'){
				if($source[$b + 1] == 'n'){
				if($source[$b + 2] == 'R'){
				if($source[$b + 3] == 'u'){
				if($source[$b + 4] == 'n'){
				for($c = $b + 5; $c < $strlen; ++$c){
					if($source[$c] != ' '){
					if($source[$c] == '('){
					for($d = $c + 1; $d < $strlen; ++$d){
						if($source[$d] != ' '){
						if($source[$d] != 'i'){
						if($source[$d + 1] != 'n'){
						if($source[$d + 2] != 't'){
						for($e = $d + 3; $e < $strlen; ++$e){
							if($source[$e] == ')'){
							for($f = $e + 1; $f < $strlen; ++$f){
								if($source[$f] == '{'){
									$function[] = [$a, $f];
									break 5;
								}
							}
							}
						}
						}else break 3;
						}else break 3;
						}else break 3;
						}
					}
					}else break 2;
					}
				}
				}else break;
				}else break;
				}else break;
				}else break;
				}else break;
				}
			}
			}
			}
			}
			}
			}
			}
			}
			}
			}
		}
		if(isset($function)){
			foreach($function as $value){
				$strlen = ($value[1] - $value[0]) + 1;
				if($strlen >= 22 and $strlen <= 80){
					$string = [];
					for($a = $value[0]; $a <= $value[1]; ++$a) 
						$string[] = $source[$a];
					$implode[] = implode('', $string);
				}
			}
			if(isset($implode)){
				$replace_function = str_replace('(', '(int ', $implode);
				$replace_source = str_replace($implode, $replace_function, $source);
				file_put_contents($dir_main, $replace_source);
				$this->logger->info("§e[APITools] '$name'の'onRun'を古い型から新しい型にしました");
			}
		}
	}

}