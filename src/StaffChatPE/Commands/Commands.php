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

  const permChat = 'staffchat.chat';
  const permRead = 'staffchat.read';
  const errPerm = TextFormat::RED.'You do not have Permissions';
  private $console = true;
  private $prefix = '.';
  private $format = '';
  private $pluginFormat;
  private $consolePrefix;
  private $chatting = [];

  private $joinMsg = '';
  private $leaveMsg = '';
	public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool{
    	$fcmd = strtolower($cmd->getName());
    	switch($fcmd){
		case "staffchat":
        if(!$sender->hasPermission('staffchat.*')) {
    			if(isset($args[0])){
    				$args[0] = strtolower($args[0]);
    				if($args[0]=="help"){
    					if($sender->hasPermission("staffchat.help")){
    						$sender->sendMessage($this->plugin->translateColors("&", "&b>> &aAvailable &6Staff&eChat&cPE &dCommands &b<<"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&2/sc info &b>>&e Show info about this plugin"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&2/sc help &b>>&e Show help about this plugin"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&2/sc reload &b>>&e Reload the config &4(ADMIN+ ONLY)"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&2/sc list &b>>&e Show the list of all staff in the staffchat."));
    						$sender->sendMessage($this->plugin->translateColors("&", "&2/sc join staff &b>>&e Join StaffChat"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&2/sc leave &b>>&e Leave the StaffChat"));
    						break;
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    						break;
    					}
    				}elseif($args[0]=="info"){
    				       if(!$sender->hasPermission('staffchat.info')) {
                                         $sender->sendMessage(self::errPerm);
                                         return true;
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&eStaffChatPE &bv" . Main::VERSION . " &edeveloped by&b " . Main::PRODUCER));
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&eWebsite &b" . Main::MAIN_WEBSITE));
    				        break;
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    						break;
    					}
    				}elseif($args[0]=="reload"){
    					if($sender->hasPermission("staffchat.reload")){
    						$this->plugin->reloadConfig();
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&aConfiguration Reloaded."));
    				        break;
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    						break;
    					}
				}elseif($args[0]=="list"){
        if(!$sender->hasPermission('staffchat.list')) {
          $sender->sendMessage(self::errPerm);
          return true;
        }
        $canChatAndRead = [];
        $canChat = [];
        $canRead = [];
        foreach($this->getServer()->getOnlinePlayers() as $onlinePlayer){
          if($onlinePlayer->hasPermission(self::permChat) AND $onlinePlayer->hasPermission(self::permRead)) {
            $canChatAndRead[] = $onlinePlayer->getName();
          } else {
            if($onlinePlayer->hasPermission(self::permChat)) $canChat[] = $onlinePlayer->getName();
            if($onlinePlayer->hasPermission(self::permRead)) $canRead[] = $onlinePlayer->getName();
    						break;
    					}
    		
    				}
    				}elseif($args[0]=="join"){
    					//Check if Sender is a player
    					if($sender instanceof Player){
					      if(!$sender->hasPermission('staffchat.join')) {
    						$sender->sendMessage(self::errPerm);
                                                return true;
    							if(isset($args[1])){
    								//Check channel permission
    								if($sender->hasPermission(strtolower("staffchat.channels." . $args[1]))){
    									$status = $this->plugin->joinChannel($sender, $args[1]);
    									if($status == false){
    										$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&cChannel not found."));
    									}else{
    										$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&aYou joined &b" . strtolower($args[1]) . "&aStaffChat."));
    									}
    								}else{
    									$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&cYou don't have permissions to join in this channel"));
    								}
    							}else{
    								$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&cUsage: /sc join staff"));
    							}
    							break;
    						}else{
    							$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    							break;
    						}
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&cYou can only perform this command as a player"));
    						break;
    					}
    				}elseif($args[0]=="leave"){
    				//Check if Sender is a player
    					if($sender instanceof Player){
    						if(!$sender->hasPermission('staffchat.leave')) {
                                                  $sender->sendMessage(self::errPerm);
                                                  return true;
    							$channel = $this->plugin->getPlayerChannel($sender);
    							$status = $this->plugin->leaveChannel($sender);
    							if($status == false){
    								$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&cYou haven't joined on a channel"));
    							}else{
    								$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX  . "&aYou left &b" . $channel . "&a channel"));
    							}
    						}else{
    							$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    							break;
    						}
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&cYou can only perform this command as a player"));
    						break;
    					}
    				}else{
    					if($sender->hasPermission("staffchat.*")){
    						$sender->sendMessage($this->plugin->translateColors("&",  Main::PREFIX . "&cSubcommand &a" . $args[0] . " &cnot found. Use &a/sc help &cto show available commands"));
    						break;
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    						break;
    					}
    				}
    				}else{
    					if($sender->hasPermission("staffchat.help")){
    						$sender->sendMessage($this->plugin->translateColors("&", "&b>> &aAvailable &6Staff&eChat&cPE &dCommands &b<<"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&2/sc info &b>>&e Show info about this plugin"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&2/sc help &b>>&e Show help about this plugin"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&2/sc reload &b>>&e Reload the config"));
    						$sender->sendMessage($this->plugin->translateColors("&", "&2/sc list &b>>&e Show the list of all staff in the staffchat."));
    						$sender->sendMessage($this->plugin->translateColors("&", "&2/sc join staff &b>>>&e Join the staffchat."));
    						$sender->sendMessage($this->plugin->translateColors("&", "&2/sc leave &b>>&e Leave the StaffChat"));
    						break;
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    						break;
    					}
    				}
    			}
            }
}
