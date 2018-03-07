<?php

namespace APITools;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class APITools extends PluginBase{

	public function onEnable(){
		$server = $this->getServer();
		$server_api = $server->getApiVersion();
		$server_name = $server->getName();
		$logger = $server->getLogger();
		$plugins = $server->getPluginPath();

		$phars = glob($plugins.'*.phar');
		foreach($phars as $plugin){
			if(is_file($plugin)){
				try{
					$phar = new \Phar($plugin);
					if(isset($phar['plugin.yml'])){
						$config = new Config($phar['plugin.yml'], Config::YAML);
						if($config->exists('api')){
							$plugin_api = $config->get('api');
							$plugin_name = $config->get('name', '名前が見つかりません');
							if(is_array($plugin_api)){
								if(array_search($server_api, $plugin_api) === false){
									$plugin_api[] = $server_api;
									$config->set('api', $plugin_api);
									$config->save();
									$logger->info("§e[APITools] {$plugin_name} を API {$server_api} に対応させました ※適用には{$server_name}の再起動が必要です");
								}
							}else{
								if($plugin_api != $server_api){
									$config->set('api', [$plugin_api, $server_api]);
									$config->save();
									$logger->info("§e[APITools] {$plugin_name} を API {$server_api} に対応させました ※適用には{$server_name}の再起動が必要です");
								}
							}
						}
					}
				}catch(\Exception $e){
					$logger->error("[APITools] ファイルが壊れている可能性があります '{$plugin}'");
				}
			}
		}
		
		$srcs = glob($plugins.'*\plugin.yml');
		foreach($srcs as $src){
			if(is_file($src)){
				$config = new Config($src, Config::YAML);
				if($config->exists('api')){
					$plugin_api = $config->get('api');
					$plugin_name = $config->get('name', '名前が見つかりません');
					if(is_array($plugin_api)){
						if(array_search($server_api, $plugin_api) === false){
							$plugin_api[] = $server_api;
							$config->set('api', $plugin_api);
							$config->save();
							$logger->info("§e[APITools] {$plugin_name} を API {$server_api} に対応させました");
						}
					}else{
						if($plugin_api != $server_api){
							$config->set('api', [$plugin_api, $server_api]);
							$config->save();
							$logger->info("§e[APITools] {$plugin_name} を API {$server_api} に対応させました");
						}
					}
				}
			}
		}
	}

}