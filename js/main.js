'use strict'

let commentForm = document.querySelector('#comments form');

if (commentForm != null)
	commentForm.addEventListener('submit', submitComment);

let upvotes = document.querySelectorAll('.upvote');

for (var i = 0; i < upvotes.length; i++)
	upvotes[i].addEventListener('click', upvoteOpinion);

let downvotes = document.querySelectorAll('.downvote');

for (var i = 0; i < downvotes.length; i++)
	downvotes[i].addEventListener('click', downvoteOpinion);

function encodeForAjax(data) {
	return Object.keys(data).map(function (k) {
		return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
	}).join('&')
}

function submitComment(event) {
	let parent_id = document.querySelector('#comments input[name=story_id]').value;
	let comment = document.querySelector('#comments textarea[name=comment]').value;

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

	if('error' in opinion)
		return;

	let section = document.querySelector('#comments');
	let comment = document.createElement('article');

	comment.classList.add('comment');
	comment.innerHTML = '<h3>' + opinion['comment'] + '</h3>' + '<h4>' + 'Posted by <a href="profile.php?username=' + opinion['username'] + '">' + opinion['username'] + '</a> just now</h4>';

	let firstComment = document.querySelector('#comments .comment');
	section.insertBefore(comment, firstComment);
}

function upvoteOpinion(event) {
	let opinion_id = this.parentElement.getAttribute('data-id');
	let value;

	switch(this.getAttribute('data-value'))
	{
		case '-1':
		case '0': value = 1;
		break;
		case '1': value = 0;
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
	let value;

	switch(this.getAttribute('data-value'))
	{
		case '1':
		case '0': value = -1;
		break;
		case '-1': value = 0;
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

function changeVote(){
	let vote = JSON.parse(this.responseText);

	if('error' in vote)
	{
		alert('Not logged in!');
		return;
	}
	
	let opinion_score = document.querySelector('[data-id="' + vote["opinion_id"] + '"] > h5');
	let opinion_up = document.querySelector('[data-id="' + vote["opinion_id"] + '"] > .upvote');
	let opinion_down = document.querySelector('[data-id="' + vote["opinion_id"] + '"] > .downvote');

	let old_vote = parseInt(opinion_up.getAttribute('data-value'));
	let old_score = parseInt(opinion_score.textContent.substr(7));
	let score = old_score + (vote['value'] - old_vote);
	
	opinion_score.outerHTML = '<h5>Score: ' + score + '</h5>';
	opinion_up.outerHTML = '<div class="upvote" role="button" data-value="'+ vote['value'] + '">&#8593;</div>';
	opinion_down.outerHTML = '<div class="downvote" role="button" data-value="'+ vote['value'] + '">&#8595;</div>';

	document.querySelector('[data-id="' + vote["opinion_id"] + '"] > .upvote').addEventListener('click', upvoteOpinion);
	document.querySelector('[data-id="' + vote["opinion_id"] + '"] > .downvote').addEventListener('click', downvoteOpinion);
}