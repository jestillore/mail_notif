(function() {
	rcmail.addEventListener('plugin.mail_notif', rcmail_mail_notif);
	function rcmail_mail_notif(mail) {
		var dn = window.webkitNotifications;
	    if (dn && !dn.checkPermission()) {
	        var popup = window.webkitNotifications.createNotification('plugins/newmail_notifier/mail.png',
	            mail.subject, mail.from);
	        popup.onclick = function() {
	            open('http://mailbox.zoogtech.com/?_task=mail&_action=show&_uid=' + mail.uid);
	        }
	        popup.show();
	        setTimeout(function() { popup.cancel(); }, 10000);
	        return true;
	    }

	    return false;
	}
	$(document).on('click', function() {
		window.webkitNotifications.requestPermission();
	});
})();