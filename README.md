**Description**

This Discord bot verifies users using a PHP backend. It uses a database to store user tokens and whether or not they have been verified. When a user enters a verification code, the bot checks the database to see if the code is valid and if the user has already been verified. If the code is valid and the user has not been verified, the bot updates the database to mark the user as verified and gives the user the appropriate role.

**Requirements**

* Python 3.7+
* PHP
* MySQL database (or a compatible database)

**Installation**

1. Clone this repository to your local machine:

```bash
git clone https://github.com/d3se/neverlose-discord-verification.git
```

2. Install the required Python packages:

```bash
pip install discord.py requests
```

3. Set up your Discord Bot on the Discord Developer Portal: https://discord.com/developers/applications and obtain a bot token. Replace `"YOUR_BOT_TOKEN"` in the `bot.py` file with your bot token.

4. Create a MySQL database and set up the tables using the provided SQL queries in `database.sql`.

5. Update the PHP files (`token_verify.php` and `token.php`) with your database credentials (`$host`, `$db`, `$user`, `$pass`) and adjust any other settings if needed.

6. Upload the PHP files to a web server or use a local server environment like XAMPP.

7. Start the bot:

```bash
python bot.py
```

**Usage**

To verify a user, the user must enter a verification code in the Discord channel specified in the `bot.py` file. The verification code can be obtained by running the `/token` command in the bot channel.


### Lua `network.post` Function of https://lua.neverlose.cc/

```lua
local username = "your_username"
local data = { username = username }
local headers = { ["Content-Type"] = "application/x-www-form-urlencoded" }
local url = "https://your-api-url/token.php"

local response = network.post(url, data, headers)
-- Parse the response as needed
```
**Example**


1. User: generate token in neverlose 
2. csgo cmd: Your verification code is 123456. Please send this code to the bot in the verification channel to verify your account.
3. User: (goes to the verification channel and sends the code 123456 to the bot)
4. Bot: Your account has been successfully verified!


**Troubleshooting**

If you are having trouble with the bot, please check the following:

* Make sure that the bot token in the `bot.py` file is correct.
* Make sure that the database credentials in the `token_verify.php` and `token.php` files are correct.
* Make sure that the PHP files are uploaded to a web server and are accessible to the bot.
* Make sure that the bot has the correct permissions in the Discord server.

If you are still having trouble, please feel free to create an issue on GitHub.

**Contributing**

If you would like to contribute to the bot, please fork this repository and create a pull request with your changes.
