const { Client, GatewayIntentBits, ActivityType } = require('discord.js');
const fetch = require('node-fetch');
const client = new Client({ intents: [GatewayIntentBits.Guilds] });

client.on('ready', () => {
	console.log(`Logged in as ${client.user.tag}!`);
	client.user.setPresence({
	    status: 'dnd',
	});
});

client.on('interactionCreate', async (interaction) => {
	if (!interaction.isChatInputCommand()) return;

	if (interaction.commandName === 'bigcat') {
		try {
			fetch('https://randombig.cat/roar.json')
			.then(res => res.json())
			.then((json) => {
				return interaction.reply(json.url);
			});
		} catch(err) {
			return interaction.reply('God damn it, we\'re out of big cats');
		}

	}
});

client.login(TOKEN);
