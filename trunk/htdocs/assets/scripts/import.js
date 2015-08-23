//var path = "/web-admin/assets/scripts";
var path = "./assets/scripts";

//for legacy browser
if(jQuery.browser.msie && parseInt(jQuery.browser.version) < 9){
	document.write('<script type="text/javascript" src="' + path + '/legacy/html5shiv.js"></script>');
	document.write('<script type="text/javascript" src="' + path + '/legacy/selectivizr-min.js"></script>');
}

//libraries
document.write('<script type="text/javascript" src="' + path + '/lib/jquery-ui-1.8.23.custom.min.js"></script>');

//plugins
document.write('<script type="text/javascript" src="' + path + '/plugin/jquery.cookie.js"></script>');
document.write('<script type="text/javascript" src="' + path + '/plugin/jquery.easing.1.3.js"></script>');
document.write('<script type="text/javascript" src="' + path + '/plugin/jquery.autogrow-textarea.js"></script>');
document.write('<script type="text/javascript" src="' + path + '/plugin/jquery.tablesorter.min.js"></script>');
document.write('<script type="text/javascript" src="' + path + '/plugin/jquery.uniform.js"></script>');
document.write('<script type="text/javascript" src="' + path + '/plugin/jquery.colorbox-min.js"></script>');
document.write('<script type="text/javascript" src="' + path + '/plugin/smartspinner.js"></script>');
document.write('<script type="text/javascript" src="' + path + '/plugin/jquery.powertip-1.1.0.min.js"></script>');
document.write('<script type="text/javascript" src="' + path + '/plugin/zip2address.js"></script>');

//main script
document.write('<script type="text/javascript" src="' + path + '/main.js"></script>');