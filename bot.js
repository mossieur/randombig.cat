const { Client, Events, GatewayIntentBits, ActivityType } = require('discord.js');
const { createAudioPlayer, createAudioResource , StreamType, demuxProbe, joinVoiceChannel, NoSubscriberBehavior, AudioPlayerStatus, VoiceConnectionStatus, getVoiceConnection } = require('@discordjs/voice')
const fetch = require('node-fetch');
const https = require('https');
const fs = require('fs');
const client = new Client({
	intents: [GatewayIntentBits.Guilds, GatewayIntentBits.GuildMessages, GatewayIntentBits.GuildMessageReactions,   GatewayIntentBits.GuildVoiceStates],
});

client.on('ready', () => {
	function avatar () {
		try {
			fetch('https://randombig.cat/roar.json?include=jpg')
			.then(res => res.json())
			.then((json) => {
				const file = fs.createWriteStream('./avatar.jpg', { flags: 'w' });
				const request = https.get(json.url, function(response) {
					response.pipe(file);
					file.on('finish', () => {
						file.close();
						client.user.setAvatar('./avatar.jpg');
					});
				});
			});
		} catch(err) {
			console.log(err);
		}

	}

	function presence () {
		client.user.setPresence({ status: 'dnd' });
		client.user.setActivity(`${client.guilds.cache.size} servers | randombig.cat`, { type: ActivityType.Watching });
	}

	function radiostream () {
		const guild = client.guilds.cache.get('664826892867862548');
		const voiceChannel = guild.channels.cache.get('1015192386013507614');

		const connection = joinVoiceChannel({
			channelId: voiceChannel.id,
			guildId: voiceChannel.guild.id,
			adapterCreator: voiceChannel.guild.voiceAdapterCreator,
		})

		const resource = createAudioResource('https://streams.radio.co/s1df61e0af/listen')

		const player = createAudioPlayer()

		player.play(resource)

		player.on('error', error => {
			radiostream();
		});

		player.on(AudioPlayerStatus.Idle, () => {
			radiostream();
		});

		connection.subscribe(player)

		connection.on('stateChange', (old_state, new_state) => {
			if (old_state.status === VoiceConnectionStatus.Ready && new_state.status === VoiceConnectionStatus.Connecting) {
				connection.configureNetworking();
			}
		})
	}

	radiostream();

	avatar();
	setInterval(() => {
		avatar();
	}, 600000);

	presence();
	setInterval(() => {
		presence();
	}, 60000);

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

client.on('messageCreate', async (message) => {
	const { channel } = message

	if (message.guild && message.guild.id === '1081152759929245726') {
		if (message.channel.id === '1082606297507168277') {
			message.crosspost()
		}
	}
});

client.login(TOKEN);
