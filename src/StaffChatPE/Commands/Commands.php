<?php

namespace StaffChatPE\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\permission\Permission;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

use StaffChatPE\Main;

class Commands extends PluginBase implements CommandExecutor{

	public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool{
    	$fcmd = strtolower($cmd->getName());
    	switch($fcmd){
    		case "staffchat":
    			if(isset($args[0])){
    				$args[0] = strtolower($args[0]);
    				if($args[0]=="help"){
    					if($sender->hasPermission("staffchat.help")){
    						$sender->sendMessage($this->plugin->translateColors("&", "&b>> &aAvailable Commands &b<<"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sc info &b>>&e Show info about this plugin"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sc help &b>>&e Show help about this plugin"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sc reload &b>>&e Reload the config"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sc join staff &b>>&e Join the StaffChat."));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sc leave &b>>&e Leave the StaffChat."));
						return true;
    						break;
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
						return true;
    						break;
    					}
    				}elseif($args[0]=="info"){
    					if($sender->hasPermission("staffchat.info")){
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&eStaffChatPE &bv" . Main::VERSION . " &edeveloped by&b " . Main::PRODUCER));
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&eWebsite &b" . Main::MAIN_WEBSITE));
					return true;
    				        break;
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", "&5You don't have permissions to use this command"));
						return true;
    						break;
    					}
    				}elseif($args[0]=="reload"){
    					if($sender->hasPermission("staffchat.reload")){
    						$this->plugin->reloadConfig();
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&aConfiguration Reloaded."));
					return true;
    				        break;
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
						return true;
    						break;
    					}
    				}elseif($args[0]=="new"){
    					if($sender->hasPermission("staffchat.new")){
    						if(isset($args[1])){
    							$this->plugin->initializeChannelPermissions();
    							$this->plugin->createChannel($args[1]);
    							$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&aChannel &b" . strtolower($args[1]) . "&a created!"));
    						}else{
    							$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&cUsage: /sch new <channel>"));
    						}
						return true;
    						break;
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
						return true;
    						break;
    					}
    				}elseif($args[0]=="list"){
    					if($sender->hasPermission("staffchat.list")){
    						$this->plugin->initializeChannelPermissions();
    						$list = $this->plugin->getAllChannels();
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&b>> &aAvailable Channels &b<<"));
    						for($i = 0; $i < count($list); $i++){
    							if($sender->hasPermission(strtolower("staffchat." . $list[$i]))){
    								$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&b- &a" . $list[$i]));
    							}
    						}
						return true;
    						break;
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
						return true;
    						break;
    					}
    				}elseif($args[0]=="join"){
    					//Check if Sender is a player
    					if($sender instanceof Player){
    						if($sender->hasPermission("staffchat.join")){
    							if(isset($args[1])){
    								//Check channel permission
    								if($sender->hasPermission(strtolower("staffchat.channels." . $args[1]))){
    									$status = $this->plugin->joinChannel($sender, $args[1]);
    									if($status == false){
    										$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&cChannel not found."));
    									}else{
    										$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&aYou joined &b" . strtolower($args[1]) . "&a channel"));
    									}
    								}else{
    									$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&cYou don't have permissions to join in this channel"));
    								}
    							}else{
    								$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&cUsage: /sc join <channel>"));
    							}
							return true;
    							break;
    						}else{
    							$sender->sendMessage($this->plugin->translateColors("&", "&5You don't have permissions to use this command"));
							return true;
    							break;
    						}
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&cYou can only perform this command as a player"));
						return true;
    						break;
    					}
    				}elseif($args[0]=="leave"){
    				//Check if Sender is a player
    					if($sender instanceof Player){
    						if($sender->hasPermission("staffchat.leave")){
    							$channel = $this->plugin->getPlayerChannel($sender);
    							$status = $this->plugin->leaveChannel($sender);
    							if($status == false){
    								$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&cYou haven't joined on a channel"));
    							}else{
    								$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&aYou left &b" . $channel . "&a channel"));
    							}
    						}else{
    							$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
							return true;
    							break;
    						}
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&cYou can only perform this command as a player"));
						return true;
    						break;
    					}
    				}else{
    					if($sender->hasPermission("staffchat.*")){
    						$sender->sendMessage($this->plugin->translateColors("&",  Main::PREFIX . "&cSubcommand &a" . $args[0] . " &cnot found. Use &a/sc help &cto show available commands"));
						return true;
    						break;
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
						return true;
    						break;
    					}
    				}
    				}else{
    					if($sender->hasPermission("staffchat.help")){
    						$sender->sendMessage($this->plugin->translateColors("&", "&b>> &aAvailable Commands &b<<"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sc info &b>>&e Show info about this plugin"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sc help &b>>&e Show help about this plugin"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sc reload &b>>&e Reload the config"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sc join staff &b>>&e Join the StaffChat"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&a/sc leave &b>>&e Leave the StaffChat."));
    						return true;
    						break;
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
						return true;
    						break;
    					}
    				}
    			}
            }
}
