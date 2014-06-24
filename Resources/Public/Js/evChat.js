$(document).ready(function($) {

	var UITrackers = {};
	var currentPoll = null;

	// Long poll new or all messages
	function pollMessages() {

		if (currentPoll !== null) currentPoll.abort();

		currentPoll = $.ajax({
			type		: 'POST',
			data		: {
				'tx_evchat_evchatfe[controller]'	: 'Event',
				'tx_evchat_evchatfe[action]'		: 'list',
				'tx_evchat_evchatfe[tracker]'		: UITrackers,
				'type'								: '5121981'
			},
			url			: '/',
			success		:
				function(updates) {
					if (updates !== false) { dispatchUpdates(updates); }				
					setTimeout(pollMessages, 1);
				},
			error		:
				function(xhr, textStatus) {
					if(xhr.readyState == 0 || xhr.status == 0) 
						return;  // it's not really an error such as in page refresh
					console.log('Error in pollMessages: ' + textStatus);
				},
			timeout		: 30000
		});

	}

	// Distribute each message to it's parent conversation
	function dispatchUpdates(objectUpdates) {

		for (var objectKey in objectUpdates) {
			switch (objectKey.split('\\')[0]) {
			case 'Conversation' :
				// New conversations started
				for (var updateKey in objectUpdates[objectKey]) {
					var update = JSON.parse(objectUpdates[objectKey][updateKey]);
					$('<a href="#" class="tx-evchat-showConversationLink">' + update.conversationKey + '</a>').appendTo($('.tx-evchat-conversationList'));
				}
				UITrackers[objectKey] = parseInt(updateKey);
				$('.tx-evchat-showConversationLink').click(function (e) {
					e.preventDefault();
					$.get(
						'/?type=561978&tx_evchat_evchatfe[controller]=Conversation&tx_evchat_evchatfe[action]=show&tx_evchat_evchatfe[conversationKey]=' + $(this).text(),
						function (chatHTML) {
							$(chatHTML).appendTo('#typo3-docbody').initConversations();
							pollMessages(); // This will abort any current, out of date, request
						}
					);
					$(this).toggle();
				});
				break;
			case 'Message' :
				// Messages arrived
				var chat = $('div.tx-evchat[data-conversationkey="' + objectKey.split('\\')[1] + '"]');
				if (!chat.find('.tx-evchat-window').is(':visible')) chat.find('.tx-evchat-titleBar-toggleIcon').click();
				for (var updateKey in objectUpdates[objectKey]) {
					var update = JSON.parse(objectUpdates[objectKey][updateKey]);
					var messageClass = update.admin === null ? 'tx-evchat-messageByVisitor' : 'tx-evchat-messageByAdministrator'; 
					var lastMessage = $('<p class="' + messageClass + '">' + update.body + '</p>').appendTo($('.tx-evchat-conversation', chat));
					if (lastMessage.prev().hasClass('tx-evchat-messageByVisitor') 
						&& lastMessage.hasClass('tx-evchat-messageByVisitor') 
						|| lastMessage.prev().hasClass('tx-evchat-messageByAdministrator') 
						&& lastMessage.hasClass('tx-evchat-messageByAdministrator')) {

						lastMessage.prepend(lastMessage.prev().html() + '<br />'); lastMessage.prev().remove();
					} 
				}
				
				UITrackers[objectKey] = parseInt(updateKey);
				$('.tx-evchat-conversation', chat).scrollTop(99999999);
				

				break;
			}
		}

	}

	(function($) {

		$.fn.initConversations = function() {

			this.each(function() {

				var chat = this;

				// Expands the input textarea
				var body = $('.tx-evchat-body', this); 
				body.autogrow(); // Grows the input text area as the user is adding new lines
				
				// Setup textarea submit on enter
				body.data('initialHeight', body.height()); // After submit the height is reset back
				body.keydown(function (e) {

					// Enter without shit key submits the form
					// Enter with a shift key just adds a new line to the body
					var form = $('form[name=newMessage]', chat);
					if (e.keyCode == 13 && !e.shiftKey) {
						// Clear content and reset height back to one line
						var data = form.serialize();
						body.val('').height(body.data('initialHeight'));
						$.ajax({
							type		: 'POST',
							url			: '/' + form.attr('action'),
							data		: data,
							success		: 
								function () {
								
									// NOTE: New messages are added to the conversation via the poll mechanism
								},
							error		:
								function (xhr, ajaxOptions, thrownError) {
									$(this).html('error occured: ' + thrownError);
								}
						});
						// preventDefault() and stopPropagation() == return false in jQuery
						// http://stackoverflow.com/questions/1357118/event-preventdefault-vs-return-false
						return false;
					}

				});
				
				// Make draggable by the title bar
				$(this).draggable({
					handle:	'.tx-evchat-titleBar',
					start:	function () { $(this).css({ bottom: 'auto', right: 'auto' }); },
					cancel:	'.tx-evchat-titleBar-toggleIcon, .tx-evchat-titleBar-chatIcon'
				});

				// Setup the minimize/restore toggle
				$(this).find('.tx-evchat-titleBar-toggleIcon').click({chat: $(this)}, function (e) {
					$(chat).find('.tx-evchat-window').toggle();
					var icon = $(chat).find('.tx-evchat-titleBar-toggleIcon');
					icon.attr('src',
						icon.attr('src').match(/minimize.png$/) !== null ?
							icon.attr('src').replace(/minimize.png$/, 'restore.png') :
							icon.attr('src').replace(/restore.png$/, 'minimize.png'));
				});

				// Register to receive messages with the given conversation key
				UITrackers['Message\\' + $(this).data('conversationkey')] = 0;

			});
			
			return this;

		};

	})(jQuery);

	$('.tx-evchat').initConversations();
	if ($('.tx-evchat-conversationList').length) UITrackers['Conversation'] = 0;
	pollMessages();

});
