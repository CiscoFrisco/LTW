'use strict'

function passwordUpdate() {

	var passScoreHTML = document.getElementById("passScore").innerHTML;
	var passScore = parseInt(passScoreHTML.substr(0, passScoreHTML.length - 1));
	var passElem = document.getElementById("passScore");

	if(passElem.classList.length == 1)
		passElem.classList.remove(passElem.classList[0]);

	if (passScore < 20) {
		passElem.classList.add('lt20');
	}
	else if (passScore < 40) {
		passElem.classList.add('lt40');
	}
	else if (passScore < 60) {
		passElem.classList.add('lt60');
	}
	else if (passScore < 80) {
		passElem.classList.add('lt80');
	}
	else {
		passElem.classList.add('lte100');
	}
}

function submitSearch() {
	document.getElementById('.container .form-container').submit();
}

let entityMap = {
	"&": "&amp;",
	"<": "&lt;",
	">": "&gt;",
	'"': '&quot;',
	"'": '&#39;',
	"/": '&#x2F;'
};

function escapeHtml(string) {
	return String(string).replace(/[&<>"'\/]/g, function (s) {
		return entityMap[s];
	});
}

function encodeForAjax(data) {
	return Object.keys(data).map(function (k) {
		return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
	}).join('&')
}

addAllEventListeners();
startPage();

let password = document.querySelector('#signup form input[type="password"]');
if (password != null)
	password.addEventListener('keyup', passwordStrength)

//Password strenght algorithm based on http://www.passwordmeter.com/js/pwdmeter.js
function passwordStrength() {
	let pass = this.value;

	let lengthWeight = pass.length * 4;
	let uppercaseWeight = pass.replace(/[A-Z]/g, '').length * 2;
	let lowercaseWeight = pass.replace(/[a-z]/g, '').length * 2;
	let numbersWeight = pass.replace(/[^0-9]/g, '').length * 4;
	let symbolsWeight = pass.replace(/[A-Za-z0-9]/g, '').length * 6;

	let middleNumSymbWeight = pass.replace(/[^0-9]/g, '').length + pass.replace(/[A-Za-z0-9]/g, '').length;
	middleNumSymbWeight -= ((pass[0] < 'a' || pass[0] > 'z') && (pass[0] < 'A' || pass[0] > 'Z')) ? 1 : 0;
	if (pass.length != 1)
		middleNumSymbWeight -= ((pass[pass.length - 1] < 'a' || pass[pass.length - 1] > 'z') && (pass[pass.length - 1] < 'A' || pass[pass.length - 1] > 'Z')) ? 1 : 0;
	middleNumSymbWeight *= 2;

	let requirementsWeight = (pass.length < 8) ? 0 : 1;
	requirementsWeight += (pass.length != pass.replace(/[A-Z]/g, '').length) ? 1 : 0;
	requirementsWeight += (pass.length != pass.replace(/[a-z]/g, '').length) ? 1 : 0;
	requirementsWeight += (numbersWeight != 0) ? 1 : 0;
	requirementsWeight += (symbolsWeight != 0) ? 1 : 0;
	requirementsWeight *= (pass.length < 8 || requirementsWeight < 4) ? 0 : 2;

	let additions = lengthWeight + uppercaseWeight + lowercaseWeight + numbersWeight + symbolsWeight + middleNumSymbWeight + requirementsWeight;

	let lettersOnlyWeight = (pass.replace(/[a-zA-Z]/g, '').length == 0) ? pass.length : 0;
	let numbersOnlyWeight = (pass.replace(/[0-9]/g, '').length == 0) ? pass.length : 0;

	let repeatChar = 0;
	let repeatCharWeight = 0;
	let consecutiveUpperWeight = 0;
	let consecutiveLowerWeight = 0;
	let consecutiveNumWeight = 0;
	let sequentialLetterWeight = 0;
	let sequentialNumWeight = 0;

	for (let i = 0; i < pass.length; i++) {
		let repeat = false;
		for (let j = 0; j < pass.length; j++) {
			if (pass[i] == pass[j] && i != j) {
				repeat = true;
				repeatCharWeight += Math.abs(pass.length / (j - i));
			}
		}
		if (repeat) {
			repeatChar++;
			let uniqueChar = pass.length - repeatChar;
			repeatCharWeight = (uniqueChar) ? Math.ceil(repeatCharWeight / uniqueChar) : Math.ceil(repeatCharWeight);
		}
		if (i != pass.length - 1) {
			consecutiveUpperWeight += ((pass[i] >= 'A' && pass[i] <= 'Z') && (pass[i + 1] >= 'A' && pass[i + 1] <= 'Z')) ? 2 : 0;
			consecutiveLowerWeight += ((pass[i] >= 'a' && pass[i] <= 'z') && (pass[i + 1] >= 'a' && pass[i + 1] <= 'z')) ? 2 : 0;
			consecutiveNumWeight += ((pass[i] >= '1' && pass[i] <= '9') && (pass[i + 1] >= '1' && pass[i + 1] <= '9')) ? 2 : 0;
		}
		if (i < pass.length - 2) {
			sequentialLetterWeight += seqLetter(pass, i) ? 3 : 0;
			sequentialNumWeight += ((pass[i] >= '1' && pass[i] <= '9') && pass.charCodeAt(i + 1) == pass.charCodeAt(i) + 1 && pass.charCodeAt(i + 2) == pass.charCodeAt(i) + 2) ? 3 : 0;
		}
	}

	let deductions = lettersOnlyWeight + numbersOnlyWeight + repeatCharWeight + consecutiveUpperWeight + consecutiveLowerWeight + consecutiveNumWeight + sequentialLetterWeight + sequentialNumWeight;

	let score = additions - deductions;
	score = score > 100 ? 100 : score;
	score = score < 0 ? 0 : score;

	this.parentElement.querySelector('#passScore').innerHTML = score + "%";
}

let signupSubmit = document.querySelector('#signup form');
if (signupSubmit != null)
	signupSubmit.addEventListener('submit', checkPasswordStrength);

function checkPasswordStrength() {
	let score = this.parentElement.querySelector('#passScore').innerHTML;
	if (score.substring(0, score.length - 1) < 50) {
		alert('Password not strong enough\nShould be at least 50%!');
		event.preventDefault();
	}
}

function seqLetter(pass, i) {
	if ((pass[i] >= 'A' && pass[i] <= 'Z') &&
		(pass.charCodeAt(i + 1) == pass.charCodeAt(i) + 1 || pass.charCodeAt(i + 1) == pass.charCodeAt(i) + 33) &&
		(pass.charCodeAt(i + 2) == pass.charCodeAt(i) + 2 || pass.charCodeAt(i + 2) == pass.charCodeAt(i) + 34))
		return true;


	if ((pass[i] >= 'a' && pass[i] <= 'z') &&
		(pass.charCodeAt(i + 1) == pass.charCodeAt(i) + 1 || pass.charCodeAt(i + 1) == pass.charCodeAt(i) - 31) &&
		(pass.charCodeAt(i + 2) == pass.charCodeAt(i) + 2 || pass.charCodeAt(i + 2) == pass.charCodeAt(i) - 30))
		return true;

	return false;
}

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

	let dark_mode = document.querySelector('input[name="darkmode"]');
	dark_mode.addEventListener('change', darkmode);

	let subscribes = document.querySelectorAll('.subscribe');

	for (var i = 0; i < subscribes.length; i++)
		subscribes[i].addEventListener('click', subcribe_channel);

	let unsubscribes = document.querySelectorAll('.unsubscribe');

	for (var i = 0; i < unsubscribes.length; i++)
		unsubscribes[i].addEventListener('click', unsubcribe_channel);

}

function startPage() {
	/* Take care of theme */
	let currentMode = sessionStorage.getItem('mode');
	let body = document.getElementsByTagName("body")[0];

	if (currentMode == "dark") {
		let dark_mode = document.querySelector('input[name="darkmode"]');
		body.classList.remove("light");
		body.classList.add("dark");
		dark_mode.checked = true;
	}

	/* Update the depth of each comment */
	let article = document.querySelectorAll('article.comment');
	for (var i = 0; i < article.length; i++) {
		let counter = numberOfParentsUntilSectionComments(article[i]);
		if (counter % 2) {
			article[i].classList.add("light-comment");
		} else {
			article[i].classList.add("dark-comment");
		}

	}

}

function numberOfParentsUntilSectionComments(node) {
	let counter = 1;
	let newNode = node.parentElement;
	let name;
	let id;
	do {
		name = newNode.nodeName;
		id = newNode.id;
		newNode = newNode.parentElement;
		counter++;
	} while (name != "SECTION" || id != "comments");
	return counter;
}


function darkmode() {

	let body = document.getElementsByTagName("body")[0];

	if (this.checked) {
		sessionStorage.setItem('mode', 'dark');
		body.classList.remove("light")
		body.classList.add("dark")
	} else {
		sessionStorage.setItem('mode', 'light');
		body.classList.remove("dark")
		body.classList.add("light")
	}

}

function submitComment(event) {
	let parent_id = this.parentElement.dataset.id;

	if (parent_id == null)
		parent_id = this.parentElement.parentElement.dataset.id;

	let comment = this.parentElement.querySelector('form > textarea').value;
	let csrf = document.querySelector('[name="csrf"]').getAttribute('value');

	let request = new XMLHttpRequest();
	request.addEventListener('load', addComment);
	request.open('POST', '../api/api_add_comment.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send(encodeForAjax({
		parent_id: parent_id,
		comment: comment,
		csrf: csrf
	}));

	event.preventDefault();
}

function addComment() {
	let opinion = JSON.parse(this.responseText);

	if ("error" in opinion) {
		switch (opinion["error"]) {
			case 'not_logged_in':
				alert('Not logged in!');
				return;
			case 'no_vote_information':
				return;
			case 'csrf':
				window.location.replace("https://bit.ly/2Lf0oIo");
			default:
				return;
		}
	}

	let commentForm = document.querySelector('.comment[data-id="' + opinion['parent_id'] + '"] > form');

	if (commentForm != null)
		commentForm.outerHTML = '<div class="comment_comment" role="button">&#128172;</div>';

	else document.querySelector('[data-id="' + opinion['parent_id'] + '"] form textarea').value = "";

	opinion['comment'] = escapeHtml(opinion['comment']);

	let regex_url = /\[([^\]]+)\]\((http[s]?:&#x2F;&#x2F;)?(www.)?([-a-zA-Z0-9@:%&_\+~#=]{2,256}\.[a-z]{2,6}\b[-a-zA-Z0-9@:%_\+.~#?&={&#x2F;}]*)\)/g;
	opinion['comment'] = opinion['comment'].replace(regex_url, '<a href=\"https://www.$4\">$1</a>');

	let regex_user = /&#x2F;u&#x2F;([-a-zA-Z0-9]+)/g;
	opinion['comment'] = opinion['comment'].replace(regex_user, '<a href=\"profile.php?username=$1\">$&</a>');

	let regex_channel = /&#x2F;c&#x2F;([-a-zA-Z0-9]+)/g;
	opinion['comment'] = opinion['comment'].replace(regex_channel, '<a href=\"stories.php?channel=$1\">$&</a>');

	let list = document.createElement('li');
	let comment = document.createElement('article');

	comment.classList.add('comment');
	comment.dataset.id = opinion['comment_id'];
	comment.innerHTML = '<div class = "votes-container"> <div class="upvote" role="button" data-value="' + opinion['vote'] + '"><i class="fas fa-arrow-circle-up"></i></div> <h5>' + opinion['score'] + '</h5> <div class="downvote" role="button" data-value="' + opinion['vote'] + '"><i class="fas fa-arrow-circle-down"></i></div></div>';
	comment.innerHTML += '<div class = "comment-container"><h3>' + opinion['comment'] + '</h3>' + '<h4>' + 'Posted by <a href="profile.php?username=' + escapeHtml(opinion['username']) + '">' + escapeHtml(opinion['username']) + '</a> just now</h4><h4>0 replies</h4></div>';
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

	let csrf = document.querySelector('[name="csrf"]').getAttribute('value');

	let request = new XMLHttpRequest();
	request.addEventListener('load', changeVote);
	request.open('POST', '../api/api_vote.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send(encodeForAjax({
		opinion_id: opinion_id,
		value: value,
		csrf: csrf
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

	let csrf = document.querySelector('[name="csrf"]').getAttribute('value');

	let request = new XMLHttpRequest();
	request.addEventListener('load', changeVote);
	request.open('POST', '../api/api_vote.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send(encodeForAjax({
		opinion_id: opinion_id,
		value: value,
		csrf: csrf
	}));
}

function changeVote() {
	let vote = JSON.parse(this.responseText);

	if ("error" in vote) {
		switch (vote["error"]) {
			case 'not_logged_in':
				alert('Not logged in!');
				return;
			case 'no_vote_information':
				return;
			case 'csrf':
				window.location.replace("https://bit.ly/2Lf0oIo");
			default:
				return;
		}
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

	let csrf = document.querySelector('[name="csrf"]').getAttribute('value');

	let new_form = document.createElement('form');
	new_form.innerHTML = '<form> <input type="hidden" name="csrf" value="' + escapeHtml(csrf) + '"> <input type="hidden" name="opinion_id" value="' + escapeHtml(parent_id) + '"> <textarea name="comment" placeholder="Have something to say about this story?" required></textarea> <input type="submit" value="Add Comment"> </form>';

	this.parentElement.insertBefore(new_form, this.parentElement.querySelector('ol'));

	document.querySelector('.comment[data-id="' + parent_id + '"] > .comment_comment').remove();

	addAllEventListeners();
}

function subcribe_channel() {
	let channel_id = this.dataset.id;

	let csrf = document.querySelector('[name="csrf"]').getAttribute('value');

	let request = new XMLHttpRequest();
	request.addEventListener('load', changeSubscription);
	request.open('POST', '../api/api_subscription.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send(encodeForAjax({
		channel_id: channel_id,
		value: true,
		csrf: csrf
	}));
}

function unsubcribe_channel() {
	let channel_id = this.dataset.id;

	let csrf = document.querySelector('[name="csrf"]').getAttribute('value');

	let request = new XMLHttpRequest();
	request.addEventListener('load', changeSubscription);
	request.open('POST', '../api/api_subscription.php', true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send(encodeForAjax({
		channel_id: channel_id,
		value: false,
		csrf: csrf
	}));
}

function changeSubscription() {
	let subscription = JSON.parse(this.responseText);

	if ("error" in subscription) {
		switch (subscription["error"]) {
			case 'not_logged_in':
				alert('Not logged in!');
				return;
			case 'no_vote_information':
				return;
			case 'csrf':
				window.location.replace("https://bit.ly/2Lf0oIo");
			default:
				return;
		}
	}

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