'use strict'

addAllEventListeners();

function addAllEventListeners() {
	let commentForm = document.querySelector('#comments > form');

	if (commentForm != null)
		commentForm.addEventListener('submit', submitComment);

	let commentCommentForms = document.querySelectorAll('#comments form');

	for (var i = 0; i < commentCommentForms.length; i++)
		commentCommentForms[i].addEventListener('submit', submitComment);

	let upvotes = document.querySelectorAll('.upvote');

	for (var i = 0; i < upvotes.length; i++)
		upvotes[i].addEventListener('click', upvoteOpinion);

	let downvotes = document.querySelectorAll('.downvote');

	for (var i = 0; i < downvotes.length; i++)
		downvotes[i].addEventListener('click', downvoteOpinion);

	let comments_comments = document.querySelectorAll('.comment_comment');

	for (var i = 0; i < comments_comments.length; i++)
		comments_comments[i].addEventListener('click', add_comment_comment_form);

	let subscribes = document.querySelectorAll('.subscribe');

	for (var i = 0; i < subscribes.length; i++)
		subscribes[i].addEventListener('click', subcribe_channel);

	let unsubscribes = document.querySelectorAll('.unsubscribe');

	for (var i = 0; i < unsubscribes.length; i++)
		unsubscribes[i].addEventListener('click', unsubcribe_channel);
}

function encodeForAjax(data) {
	return Object.keys(data).map(function (k) {
		return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
	}).join('&')
}

function submitComment(event) {
	let parent_id = this.parentElement.dataset.id;

	if (parent_id == null)
		parent_id = this.parentElement.parentElement.dataset.id;
	
	let comment = this.parentElement.querySelector('form > textarea').value;

	let request = new XMLHttpRequest();
	request.addEventListener('load', addComment);
	request.open('POST', '../api/api_add_comment.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send(encodeForAjax({
		parent_id: parent_id,
		comment: comment
	}));

	event.preventDefault();
}

function addComment() {
	let opinion = JSON.parse(this.responseText);

	if ('error' in opinion) {
		alert('Comment too long! Max is 10000 characters');
		return;
	}

	let commentForm = document.querySelector('.comment[data-id="' + opinion['parent_id'] + '"] > form');

	let regex_url = /\[([^\]]+)\]\((http[s]?:[\/]{2})?(www.)?([-a-zA-Z0-9@:%&_\+~#=]{2,256}\.[a-z]{2,6}\b[-a-zA-Z0-9@:%_\+.~#?&=/]*)\)/g;
	opinion['comment'] = opinion['comment'].replace(regex_url, '<a href=\"https://www.$4\">$1</a>');

	let regex_user = /\/u\/([-a-zA-Z0-9@:%_\+.~#?&=/]+)/g;
	opinion['comment'] = opinion['comment'].replace(regex_user, '<a href=\"profile.php?username=$1\">$&</a>');

	let regex_channel = /\/u\/([-a-zA-Z0-9@:%_\+.~#?&=/]+)/g;
	opinion['comment'] = opinion['comment'].replace(regex_channel, '<a href=\"profile.php?username=$1\">$&</a>');

	if (commentForm != null)
		commentForm.outerHTML = '<div class="comment_comment" role="button">&#128172;</div>';

	let list = document.createElement('li');
	let comment = document.createElement('article');

	comment.classList.add('comment');
	comment.dataset.id = opinion['comment_id'];
	comment.innerHTML = '<div class="upvote" role="button" data-value="' + opinion['vote'] + '">&#8593;</div> <h5>' + opinion['score'] + '</h5> <div class="downvote" role="button" data-value="' + opinion['vote'] + '">&#8595;</div>';
	comment.innerHTML += '<h3>' + opinion['comment'] + '</h3>' + '<h4>' + 'Posted by <a href="profile.php?username=' + opinion['username'] + '">' + opinion['username'] + '</a> just now</h4>';
	comment.innerHTML += '<h4>0 replies</h4>'
	comment.innerHTML += '<div class="comment_comment" role="button">&#128172;</div> <ol></ol>';

	list.innerHTML = comment.outerHTML;

	let parentList = document.querySelector('[data-id="' + opinion['parent_id'] + '"] > ol');

	if (parentList == null)
		parentList = document.querySelector('[data-id="' + opinion['parent_id'] + '"] > .container > ol');

	parentList.innerHTML = list.outerHTML + parentList.innerHTML;

	addAllEventListeners();
}

function upvoteOpinion(event) {
	let opinion_id = this.parentElement.getAttribute('data-id');

	if (opinion_id == null)
		opinion_id = this.parentElement.parentElement.getAttribute('data-id');

	if (opinion_id == null)
		opinion_id = this.parentElement.parentElement.parentElement.getAttribute('data-id');

	let value;

	switch (this.getAttribute('data-value')) {
		case '-1':
		case '0':
			value = 1;
			break;
		case '1':
			value = 0;
			break;
	}

	let request = new XMLHttpRequest();
	request.addEventListener('load', changeVote);
	request.open('POST', '../api/api_vote.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send(encodeForAjax({
		opinion_id: opinion_id,
		value: value
	}));
}

function downvoteOpinion(event) {
	let opinion_id = this.parentElement.getAttribute('data-id');

	if (opinion_id == null)
		opinion_id = this.parentElement.parentElement.getAttribute('data-id');

	if (opinion_id == null)
		opinion_id = this.parentElement.parentElement.parentElement.getAttribute('data-id');

	let value;

	switch (this.getAttribute('data-value')) {
		case '1':
		case '0':
			value = -1;
			break;
		case '-1':
			value = 0;
			break;
	}

	let request = new XMLHttpRequest();
	request.addEventListener('load', changeVote);
	request.open('POST', '../api/api_vote.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send(encodeForAjax({
		opinion_id: opinion_id,
		value: value
	}));
}

function changeVote() {
	let vote = JSON.parse(this.responseText);

	if ('error' in vote) {
		alert('Not logged in!');
		return;
	}

	let opinion_score = document.querySelector('[data-id="' + vote["opinion_id"] + '"] h5');
	let opinion_up = document.querySelector('[data-id="' + vote["opinion_id"] + '"] .upvote');
	let opinion_down = document.querySelector('[data-id="' + vote["opinion_id"] + '"] .downvote');

	let old_vote = parseInt(opinion_up.getAttribute('data-value'));
	let old_score = parseInt(opinion_score.textContent);
	let score = old_score + (vote['value'] - old_vote);

	opinion_score.outerHTML = '<h5>' + score + '</h5>';
	opinion_up.outerHTML = '<div class="upvote" role="button" data-value="' + vote['value'] + '"><i class="fas fa-arrow-circle-up"></i></div>';
	opinion_down.outerHTML = '<div class="downvote" role="button" data-value="' + vote['value'] + '"><i class="fas fa-arrow-circle-down"></i></div>';

	document.querySelector('[data-id="' + vote['opinion_id'] + '"] .upvote').addEventListener('click', upvoteOpinion);
	document.querySelector('[data-id="' + vote['opinion_id'] + '"] .downvote').addEventListener('click', downvoteOpinion);
}

function add_comment_comment_form() {
	if (this.parentElement.querySelector('form') != null)
		return;

	let parent_id = this.parentElement.dataset.id;

	let new_form = document.createElement('form');
	new_form.innerHTML = '<form> <input type="hidden" name="opinion_id" value="' + parent_id + '"> <textarea name="comment" placeholder="Have something to say about this story?" required></textarea> <input type="submit" value="Add Comment"> </form>';

	this.parentElement.insertBefore(new_form, this.parentElement.querySelector('ol'));

	document.querySelector('.comment[data-id="' + parent_id + '"] > .comment_comment').remove();

	addAllEventListeners();
}


function subcribe_channel() {
	let channel_id = this.dataset.id;

	let request = new XMLHttpRequest();
	request.addEventListener('load', changeSubscription);
	request.open('POST', '../api/api_subscription.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send(encodeForAjax({
		channel_id: channel_id,
		value: true
	}));
}

function unsubcribe_channel() {
	let channel_id = this.dataset.id;

	let request = new XMLHttpRequest();
	request.addEventListener('load', changeSubscription);
	request.open('POST', '../api/api_subscription.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send(encodeForAjax({
		channel_id: channel_id,
		value: false
	}));
}

function changeSubscription() {
	let subscription = JSON.parse(this.responseText);

	if (subscription["value"] == "true") {
		let div = document.querySelector('.subscribe[data-id="' + subscription["channel_id"] + '"]');
		div.innerHTML = '<i class="fas fa-bell-slash"></i>';
		div.classList.replace('subscribe', 'unsubscribe');
		div.removeEventListener('click', subcribe_channel);
		div.addEventListener('click', unsubcribe_channel);
	} else {
		let div = document.querySelector('.unsubscribe[data-id="' + subscription["channel_id"] + '"]');
		div.innerHTML = '<i class="fas fa-bell"></i>';
		div.classList.replace('unsubscribe', 'subscribe');
		div.removeEventListener('click', unsubcribe_channel);
		div.addEventListener('click', subcribe_channel);
	}
}