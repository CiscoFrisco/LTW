'use strict'

let commentForm = document.querySelector('#comments form');
commentForm.addEventListener('submit', submitComment);

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
	let opinon = JSON.parse(this.responseText);
	let section = document.querySelector('#comments');
	let comment = document.createElement('article');

	comment.classList.add('comment');
	comment.innerHTML = '<h3>' + opinon['comment'] + '</h3>' + '<h4>' + 'Posted by <a href="profile.php?username=' + opinon['username'] + '">' + opinon['username'] + '</a> just now</h4>';
	
	let firstComment = document.querySelector('#comments .comment');
	section.insertBefore(comment, firstComment);
}