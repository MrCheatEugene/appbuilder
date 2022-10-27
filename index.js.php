<?php 
header("Content-Type: application/json");
if (isset($_GET['id'])){
	$id = $_GET['id'];
}
if (isset($_GET['fn'])){
	$fn = $_GET['fn'];
}
if (isset($_GET['proj'])) {
	$proj = htmlspecialchars(strval($_GET['proj']));
}
?>
//'use strict';

require.config({
    baseUrl: 'min/'
    });

var editor = null, diffEditor = null;
window.top.filename<?php echo $id;?> = '<?php echo $fn;?>';

/// <reference path="../../release/monaco.d.ts" />
var prevText = "";
"use strict";

var editor = null, diffEditor = null;
$(document).ready(function() {
	require(['vs/editor/editor.main'], function () {
		var MODES = (function() {
			var modesIds = monaco.languages.getLanguages().map(function(lang) { return lang.id; });
			modesIds.sort();

			return modesIds.map(function(modeId) {
				return {
					modeId: modeId,
					sampleURL: 'samples/sample.' + modeId + '.txt'
				};
			});
		})();

		var startModeIndex = 0;
		MODES = [{'modeId':"C","sampleURL":"samples/sample.c.txt","modeRealId":"c"},{'modeId':"C++","sampleURL":"samples/sample.cpp.txt","modeRealId":"cpp"},{'modeId':"CSS","sampleURL":"samples/sample.css.txt","modeRealId":"css"},{'modeId':"HTML","sampleURL":"samples/sample.html.txt","modeRealId":"html"},{'modeId':"JS","sampleURL":"samples/sample.js.txt","modeRealId":"javascript"},{'modeId':"JSON","sampleURL":"samples/sample.json.txt","modeRealId":"json"},{'modeId':"Text","sampleURL":"samples/sample.plaintext.txt","modeRealId":"plaintext"}];
	    loadSample(MODES[0]);
		for (var i = 0; i < MODES.length; i++) {
			var o = document.createElement('option');
			o.textContent = MODES[i].modeId;
			if (MODES[i].modeId === 'c') {
				startModeIndex = i;
			}
			$(".language-picker").append(o);
		}
		$(".language-picker")[0].selectedIndex = startModeIndex;
		$(".language-picker").change(function() {
		//	loadSample(MODES[this.selectedIndex]);
		//	loadText();
		//	$('#editor').empty();
//		})
		var newModel = monaco.editor.createModel(editor.getValue(), MODES[this.selectedIndex].modeRealId);
		editor.setModel(newModel);
		});

		$(".theme-picker").change(function() {
			changeTheme(this.selectedIndex);
		});

//		loadDiffSample();

		$('#inline-diff-checkbox').change(function () {
			diffEditor.updateOptions({
				renderSideBySide: !$(this).is(':checked')
			});
		});
	});

	window.onresize = function () {
		if (editor) {
			editor.layout();
		}
		if (diffEditor) {
			diffEditor.layout();
		}
	};
});

var preloaded = {};
(function() {
	var elements = Array.prototype.slice.call(document.querySelectorAll('pre[data-preload]'), 0);

	elements.forEach(function(el) {
		var path = el.getAttribute('data-preload');
		preloaded[path] = el.innerText || el.textContent;
		el.parentNode.removeChild(el);
	});
})();

function xhr(url, cb) {
	if (preloaded[url]) {
		return cb(null, preloaded[url]);
	}
	$.ajax({
		type: 'GET',
		url: url,
		dataType: 'text',
		error: function () {
			cb(this, null);
		}
	}).done(function(data) {
		cb(null, data);
	});
}
function loadSample(mode) {
	
	$('.loading.editor').show();
	xhr(mode.sampleURL, function(err, data) {
		if (err) {
			if (editor) {
				if (editor.getModel()) {
					editor.getModel().dispose();
				}
				editor.dispose();
				editor = null;
			}
			$('.loading.editor').fadeOut({ duration: 200 });
			$('#editor').empty();
			$('#editor').append('<p class="alert alert-error">Failed to load ' + mode.modeId + ' sample</p>');
			return;
		}

		if (!editor) {
			$('#editor').empty();
			editor = monaco.editor.create(document.getElementById('editor'), {
				model: null,
			});
		}
  			$('.loading.editor').fadeOut({ duration: 300 });
		fetch("projectHasFile.php?proj="+'<?php echo $proj;?>'+"&fn=<?php echo $fn; ?>")
  			.then((response) => response.json())
  			.then((data) => {
  				if(data.success = 1){
  						//editor.setValue(data[i].fileContents);
		var oldModel = editor.getModel();
		var newModel = monaco.editor.createModel(data['code'], mode.modeRealId);
		editor.setModel(newModel);
		if (oldModel) {
			oldModel.dispose();
		}
window.top.getEditor<?php echo $id;?>Contents = function(){

		if (!editor) {
			$('#editor').empty();
			editor = monaco.editor.create(document.getElementById('editor'), {
				model: null,
			});
			window.top.console.log("new editor!");
//					var newModel = monaco.editor.createModel(edit, mode.modeRealId);
//		editor.setModel(newModel);
		}
		return {"code":editor.getValue(),"filename":window.top.filename<?php echo $id;?>};
		};
				window.top.editorsArray.push([<?php echo $id; ?>,window.top.getEditor<?php echo $id;?>Contents]);
		$('.loading.editor').fadeOut({ duration: 300 });
	}else{
		alert("Failed to process one of the files, response: "+JSON.stringify(data))
	}
	});
  				
  			});
	}
//}

function loadDiffSample() {

	var onError = function() {
		$('.loading.diff-editor').fadeOut({ duration: 200 });
		$('#diff-editor').append('<p class="alert alert-error">Failed to load diff editor sample</p>');
	};

	$('.loading.diff-editor').show();

	var lhsData = null, rhsData = null, jsMode = null;

	xhr('samples/diff.lhs.txt', function(err, data) {
		if (err) {
			return onError();
		}
		lhsData = data;
		onProgress();
	})
	xhr('samples/diff.rhs.txt', function(err, data) {
		if (err) {
			return onError();
		}
		rhsData = data;
		onProgress();
	})

	function onProgress() {
		if (lhsData && rhsData) {
			diffEditor = monaco.editor.createDiffEditor(document.getElementById('diff-editor'), {
				enableSplitViewResizing: false
			});

			var lhsModel = monaco.editor.createModel(lhsData, 'text/javascript');
			var rhsModel = monaco.editor.createModel(rhsData, 'text/javascript');

			diffEditor.setModel({
				original: lhsModel,
				modified: rhsModel
			});

			$('.loading.diff-editor').fadeOut({ duration: 300 });
		}
	}
}

function changeTheme(theme) {
	var newTheme = (theme === 1 ? 'vs-dark' : ( theme === 0 ? 'vs' : 'hc-black' ));
	monaco.editor.setTheme(newTheme);
}