import discord
import os
import requests
from discord.ext import commands

client = commands.Bot(intents = discord.Intents.default(), command_prefix = "!")

@client.event
async def on_ready():
# debug
  print("Bot Online")

@client.hybrid_command()
async def verify(ctx, code: str):
  if ctx.channel.id == 1145336638877208596:
    request = requests.post("https://yoururl/token_verify.php", data = {"token": code})
    data = request.json()
    error = data["status"]
    if error == "success":
      username = data["username"]
      role = discord.utils.get(ctx.guild.roles, name='customer')
      await ctx.author.edit(nick=username)
      await ctx.author.add_roles(role)
      await ctx.reply('Successfully verified', ephemeral = True)
      
    elif data["message"] is not None and data["message"] == "Token already verified":
      await ctx.reply("Code is already used", ephemeral = True)
    else:
      await ctx.reply('Code is invalid', ephemeral = True)
  else:
    await ctx.reply("Wrong Channel Fucktard | Не тот канал, ублюдок", ephemeral = True)

client.run("ur bot token")