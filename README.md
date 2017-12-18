# StaffChatPE

StaffChatPE plugin for PocketMine-MP

## Category

PocketMine-MP plugins

## Requirements

PocketMine-MP Alpha_1.5 API: ALPHA9-ALPHA10

## Overview

**StaffChatPE** allows you to chat with staff members on the server.

***This Plugin uses the New API. You can't install it on old versions of PocketMine.***

**Commands:**

<dd><i><b>/staffchatpe</b> - StaffChatPE commands</i></dd>
<br>
**To-Do:**
<br><br>
*- Bug fix (if bugs will be found)*

## Documentation

**Colors:**

Black ("&0");<br>
Dark Blue ("&1");<br>
Dark Green ("&2");<br>
Dark Aqua ("&3");<br>
Dark Red ("&4");<br>
Dark Purple ("&5");<br>
Gold ("&6");<br>
Gray ("&7");<br>
Dark Gray ("&8");<br>
Blue ("&9");<br>
Green ("&a");<br>
Aqua ("&b");<br>
Red ("&c");<br>
Light Purple ("&d");<br>
Yellow ("&e");<br>
White ("&f");<br>

**Special:**

Obfuscated ("&k");<br>
Bold ("&l");<br>
Strikethrough ("&m");<br>
Underline ("&n");<br>
Italic ("&o");<br>
Reset ("&r");<br>

**Add and configure a channel:**

*Remember that you must have the "serverchannels.channels.<channel>" permission set to true to join the channel*

1. Run the command "/sc new <channel>"<br>
2. Go to "StaffChatPE/channels" directory and open the channel config file<br>
This is a channel config file:
```yaml
---
#Channel Prefix
prefix: "&7[&bExampleChannel&7]"
#Channel Suffix
suffix: ""
#Channel format
#Available Tags:
# - {MESSAGE}: Show message
# - {PLAYER}: Show player name
# - {PREFIX}: Show prefix
# - {SUFFIX}: Show suffix
# - {TIME}: Show current time
# - {WORLD}: Show world name
format: "{PREFIX} &7{PLAYER}: &f{MESSAGE}"
#If you set this to false, only players joined in this channel can display messages
public: true
...
```

**Configuration (config.yml):**

```yaml
---
#Date\Time format (replaced in {TIME}). For format codes read http://php.net/manual/en/datetime.formats.php
datetime-format: "H:i:s"
#Log channel messages on console
log-on-console: true
...
```

**Commands:**

***/staffchatpe*** *- ServerChannels commands (aliases: [sc])*<br>
***/sc info*** *- Show info about this plugin*<br>
***/sc help*** *- Show help about this plugin*<br>
***/sc reload*** *- Reload the config*<br>
***/sc list*** *- Show the list of all channels*<br>
***/sc join &lt;channel&gt;*** *- Join a channel*<br>
***/sc leave*** *- Leave the current channel*<br>
***/sc new &lt;channel&gt;*** *- Create new channel*<br>
<br>
**Permissions:**
<br>
- <dd><i><b>staffchat.*</b>
- <dd><i><b>staffchat.*</b> 
- <dd><i><b>staffchat.*</b>
- <dd><i><b>staffchat..help</b>  
- <dd><i><b>staffchat.info</b>  
- <dd><i><b>staffchat.reload</b> 
- <dd><i><b>staffchat.list</b>  
- <dd><i><b>staffchat.join</b>  
- <dd><i><b>staffchat.leave</b> 
- <dd><i><b>staffchat.new</b>
