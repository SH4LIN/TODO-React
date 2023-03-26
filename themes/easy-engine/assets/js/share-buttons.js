/**
 * This file contains the code for print butotn and email button.
 */
(function () {
	window.addEventListener('DOMContentLoaded', function () {
		const { __ } = wp.i18n;
		const printButton = document.getElementById('print');
		const emailButton = document.getElementById('email');
		const cancelEmail = document.getElementById('cancel-email');
		const likeIcon = document.getElementById('like-icon');
		const likeButton = document.getElementById('like');
		const emailDialog = document.querySelector('.email-dialog');
		const sendEmailButton = document.getElementById('send-email');
		const emailForm = document.querySelector('.email-form');
		const emailSuccessMessage = document.querySelector(
			'.email-success-message'
		);
		const closeSuccessMessage = document.getElementById(
			'close-success-message'
		);
		const sendEmail = document.getElementById('destination-email');
		const yourEmail = document.getElementById('your-email');
		const name = document.getElementById('name');
		const emailError = document.querySelector('.email-error-message');
		const emailSuccess = document.querySelector('.email-success');
		let emailDialogOpen = false;

		printButton?.addEventListener('click', function () {
			window.print();
		});

		function toggleEmailDialog() {
			if (emailDialog !== null) {
				if (emailDialogOpen) {
					emailDialog.style.display = 'none';
					emailDialogOpen = false;
				} else {
					emailDialog.style.display = 'block';
					emailDialogOpen = true;
				}
			}
		}

		cancelEmail?.addEventListener('click', toggleEmailDialog);
		emailButton?.addEventListener('click', toggleEmailDialog);

		sendEmailButton?.addEventListener('click', function (e) {
			e.preventDefault();

			const emailValue = sendEmail?.value;
			const yourEmailValue = yourEmail?.value;
			const nameValue = name?.value;

			const emailRegEx =
				/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

			const emailIsValid = emailRegEx.test(
				String(emailValue).toLowerCase()
			);
			const yourEmailIsValid = emailRegEx.test(
				String(yourEmailValue).toLowerCase()
			);
			const nameIsValid = nameValue.length > 0;

			if (emailIsValid && yourEmailIsValid && nameIsValid) {
				emailError.style.display = 'none';
				emailSuccess.style.display = 'flex';
				emailForm.style.display = 'none';
				const message =
					__(
						'This post has been shared! You have shared this post with ',
						'easy-engine'
					) + sendEmail.value;
				emailSuccessMessage.innerHTML = message;
			} else {
				emailError.style.display = 'block';
				emailError.innerHTML = __(
					'Please enter valid details',
					'easy-engine'
				);
			}
		});

		closeSuccessMessage?.addEventListener('click', function () {
			if (emailForm !== null && emailSuccess !== null) {
				emailForm.style.display = 'flex';
				emailSuccess.style.display = 'none';
				toggleEmailDialog();
			}
		});

		likeButton?.addEventListener('click', function () {
			if (likeIcon !== null) {
				likeIcon.classList.toggle('fa-regular');
				likeIcon.classList.toggle('fa-solid');
			}
		});
	});
})();
