
function $id(id) {
	return document.getElementById(id);
}


if (window.File && window.FileList && window.FileReader) {
	Init();
}

function Init() {

	var fileselect = $id("fileselect"),
		filedrag = $id("filedrag"),
		submitbutton = $id("submitbutton");

	fileselect.addEventListener("change", FileSelectHandler, false);

	var xhr = new XMLHttpRequest();
	if (xhr.upload) {
	
		filedrag.addEventListener("dragover", FileDragHover, false);
		filedrag.addEventListener("dragleave", FileDragHover, false);
		filedrag.addEventListener("drop", FileSelectHandler, false);
		filedrag.style.display = "block";
		
	}

}

function FileDragHover(e) {
	e.stopPropagation();
	e.preventDefault();
	e.target.className = (e.type == "dragover" ? "hover" : "");
}

$('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
});



