// Let's render an screenshot with PhantomJS

// Get the url of the repo
var system = require('system');
var url = system.args[1];
var filePath = system.args[2];
var extension = system.args[3];

var page = require('webpage').create();

// For logging errors
page.onResourceError = function(resourceError) {
    page.reason = resourceError.errorString;
    page.reason_url = resourceError.url;
};

page.open(url, function (status) {
    if (status !== 'success') {
        console.log(
            "Error opening url \"" + page.reason_url
            + "\": " + page.reason
        );
        phantom.exit(1);
    } else {
        window.setTimeout(function () {

            var bb = page.evaluate(function () {
                return document.getElementsByClassName("js-calendar-graph")[0].getBoundingClientRect();
            });

            page.clipRect = {
                top:    bb.top,
                left:   bb.left,
                width:  bb.width,
                height: bb.height
            };

            page.render(filePath, { format: extension }); // Phantom creates the images much faster in jpg but avconv creates corrupted video if JPG inputs
            phantom.exit();

        }, 5000);
    }
});