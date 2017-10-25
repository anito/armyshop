#--------- Hem setup options

defaultHem =
	baseAppRoute: "/"
	tests:
		runner: "browser"

proxyHem =
	baseAppRoute: "/"
	tests:
		runner: "browser"
	proxy:
		"/proxy":
			"host": "armyshop.webpremiere.de"
			"path": "/proxy"

#--------- main configuration setup

config =

	# main hem configuration
	hem: defaultHem

	# appliation configuration

	application:
		defaults: "spine"
		js:
			libs: [
				"lib/jquery.js",
                                "lib/jade_runtime.js",
                                "lib/jquery/jquery-latest.min.js",
                                "lib/jquery/jquery.tmpl.js",
                                "lib/jquery/jquery-ui-1.10.3.custom.js",
                                "lib/bootstrap/bootstrap.bundle.min.js",
                                "lib/html5sortable/jquery.sortable.js",
                                "lib/blueimp/load-image.min.js",
                                "lib/blueimp/locale.js",
                                "lib/blueimp/tmpl.js",
                                "lib/blueimp/canvas-to-blob.js",
                                "lib/blueimp/jquery.iframe-transport.js",
                                "lib/blueimp/jquery.fileupload.js",
                                "lib/blueimp/jquery.fileupload-process.js",
                                "lib/blueimp/jquery.fileupload-image.js",
                                "lib/blueimp/jquery.fileupload-audio.js",
                                "lib/blueimp/jquery.fileupload-video.js",
                                "lib/blueimp/jquery.fileupload-validate.js",
                                "lib/blueimp/jquery.fileupload-ui.js",
                                "lib/swiper/swiper.min.js",
                                "lib/swiper/swipe.js"
                                "lib/swiper/script.js",
			]
			modules: [
				"spine",
                                "spine/lib/ajax",
                                "spine/lib/route",
                                "spine/lib/manager",
                                "spine/lib/local",
                                "spine/lib/list"
                                "jquery.tmpl",
                                "es5-shimify", 
                                "json2ify",
			]
		test:
			after: "require('lib/setup')"

#--------- export the configuration map for hem

module.exports.config = config

#--------- customize hem

module.exports.customize = (hem) ->
	# provide hook to customize the hem instance,
	# called after config is parsed/processed.
	return
