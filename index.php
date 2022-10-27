<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="editor-incl/jquery-1.9.1.min.js"></script>
<script src="axios.min.js"></script>
<link rel="stylesheet" type="text/css" href="index.css">

<script src="sweetalert2.min.js"></script>
<link rel="stylesheet" href="sweetalert2.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  -webkit-animation: fadeEffect 1s;
  animation: fadeEffect 1s;
}

/* Fade in tabs */
@-webkit-keyframes fadeEffect {
  from {opacity: 0;}
  to {opacity: 1;}
}

@keyframes fadeEffect {
  from {opacity: 0;}
  to {opacity: 1;}
}
</style>
</head>
<body>
<div class="tab" id="tabs">
  <button class="tablinks" onclick="newProject(window.prompt('Enter project name','project'))" title="New project">📄</button>
  <button class="tablinks" onclick="  Swal.fire({
  title: 'Enter/select project name',
  input: 'select',
  inputOptions: projectsObj,
  inputLabel: 'Project',
  //inputValue: pname,
  showCancelButton: true
//Swal.fire('Any fool can use a computer!')
}).then(value=>{
    return new Promise((resolve) => {
      if(projects.indexOf(value.value)!== -1){
        openProj(value.value);
      }else{
         Swal.fire('Project not exists!');
      }
});
});
" title="Open project">📁</button>
  <button class="tablinks" onclick="save()" title="Save project">💾</button>
  <button class="tablinks" onclick="newTab(event,window.prompt('Enter filename','main.cpp'))">
  +</button>
    <button class="tablinks" onclick="newAsset()">➗</button>
  <button class="tablinks" onclick="rmTab(event,window.prompt('Enter filename of file, you want to remove(this file will be lost FOREVER!)','main.cpp'))">-</button>
  <button class="tablinks" onclick="compile()" title="Compile project">▶️</button>
  <button class="tablinks" onclick="downloadAllObjects();" title="Download all objects">⇓</button>
</div>
<div id="tabcontents">
</div>
<script>
  var projects = {};
  var assets = [];
  axios.get("getProjects.php").then(function (response) {
    projects = response.data;
    projectsObj = {}
for (let i = 0; i < projects.length; i++) {
    let proj = projects[i];
    let obj = {}
    obj[proj]= proj;
    Object.assign(projectsObj,obj)
}
  })
  .catch(function (error) {
    alert("Failed to get projects. Error: "+error)
  });
  var cproject = '';


  function newProject(proj){

  Swal.fire("Creating project. It might took 1-5 minutes. Please be patient and stay on this page.");
  axios.get("newProject.php?proj="+proj).then(function (response) {
    if(response.data.success == 1){
      Swal.fire("Success!");
      openProj(proj);
    }else{
      Swal.fire('Failed to create project, response: '+JSON.stringify(response.data));
    }
  })
  .catch(function (error) {
    alert("Failed to create project, error: "+error);
  });
  }
  //btoa
  function save(){
    saveFiles();
    Swal.fire('Success!');
  }

function newAsset(){
  Swal.fire({title:"Upload asset",html:'<iframe src="uploadAssetForm.php?proj='+cproject+'" class="iframeassetsform"></iframe>',showConfirmButton:false});
}
function addasset(fn,data){
  assets.push({filename:fn,data:data});
  return 0;
}
function openProj(project){
  tabs = [];
  assets = [];
  tabcontents = {};
  window.editorsArray = [];
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById('tabcontents').innerHTML ="";
  cproject = project;
  axios.get("getFiles.php?proj="+encodeURI(project))  .then(function (response) {
    //console.log(response.data);
    var keys = Object.keys(response.data);
    if(response.data !== {}){
      for (var i = 0; i < keys.length; i++) {
        console.log(response.data[keys[i]]);
        if (response.data[keys[i]]['isasset'] === 0) {
        //console.log(response.data[i]);
        response.data[keys[i]]['filename']
        response.data[keys[i]]['fileContents']
        //fileContents
        renderTab(response.data[keys[i]]['filename'],project);
      }else{
        addasset(response.data[keys[i]]['filename'],response.data[keys[i]]['fileContents']);     
      }
      }
    }
    renderTabs(tabs);
    Swal.fire("Success!");
  })
  .catch(function (error) {
    console.log(error);
    alert("Failed to open project files.")
  });

}
  window.editorsArray = [];
  var tabs = [];
  var tabcontents = {}
function openTab(evt, tabName) {
  console.log(tabName);
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}

function renderTabs(tabstorender){
  var tabs_contents = document.getElementById('tabcontents');
  $('#tabcontents').each(function () {
    if(tabs.indexOf(($(this)[0]).id) == -1){

    }
});
  var tabs_object = document.getElementById('tabs');
  tabs_object.innerHTML = '<button class="tablinks" onclick="newProject(window.prompt(\'Enter project name\',\'project\'))" title="New project">📄</button>\
<button class="tablinks" onclick="  Swal.fire({\
  title: \'Enter/select project name\',\
  input: \'select\',\
  inputOptions: projectsObj,\
  inputLabel: \'Project\',\
  showCancelButton: true\
}).then(value=>{\
    return new Promise((resolve) => {\
      if(projects.indexOf(value.value)!== -1){\
        openProj(value.value);\
      }else{\
         Swal.fire(\'Project not exists!\');\
      }\
});\
});\
" title="Open project">📁</button>  <button class="tablinks" onclick="save()" title="Save project">💾</button>\
  <button class="tablinks" onclick="newTab(event,window.prompt(\'Enter filename\',\'main.cpp\'))">+</button>\
  <button class="tablinks" onclick="newAsset()">➗</button>\
   <button class="tablinks" onclick="rmTab(event,window.prompt(\'Enter filename of file, you want to remove(this file will be lost FOREVER!)\',\'main.cpp\'))">-</button>\
  <button class="tablinks" onclick="compile()" title="Compile project">▶️</button>\
  <button class="tablinks" onclick="downloadAllObjects();" title="Download all objects">⇓</button>';
  for (var i = 0; i < tabstorender.length; i++) {
    tabs_object.innerHTML= tabs_object.innerHTML+'<button class="tablinks" onclick="openTab(event, \''+tabstorender[i]+'\')">'+tabstorender[i]+'</button>';
    let celem = document.createElement('div');
    celem.id = tabstorender[i];
    celem.classList.add('tabcontent');
    celem.innerHTML =tabcontents[tabstorender[i]];
    tabs_contents.appendChild(celem);
  }
}
function saveFilesOnce(){
  for (var i = 0; i < window.top.editorsArray.length; i++) {
    let data = window.top.editorsArray[i];
    let fetchedData = data[1]();
    let id = data[0];
    saveFile(fetchedData['filename'],fetchedData['code']);
  }
}
function saveFiles(){
  saveFilesOnce();
  saveFilesOnce();
}
function saveFile(fn,data){
  axios({
    headers: { 'Content-Type': 'application/x-www-form-urlencoded'},
    method: 'post',
    url: 'saveFile.php?proj='+cproject,
    data:{
      fileContents: data,
      filename: fn
    }
  })
  .then(function (response) {
    if(response.data.success >1 && response.data.success <0){
        alert("Failes to save file to the storage, server returned error code "+resp+".")
    }
  })
  .catch(function (error) {
    alert("Failed to save file to storage. Error: "+error)
  });
}
function downloadObject(fn,data){
  saveFile(fn,data);
  var a = document.createElement('a');
  var blob = new Blob([data], {'type':"text/plain"});
  a.href = window.URL.createObjectURL(blob);
  a.download = fn;
  a.click();
}

function dlFile(href){
  var a = document.createElement('a');
  a.href = "dlFile.php?path="+encodeURI(href);
  a.click();
}
function dlByURL(href){
  var a = document.createElement('a');
  a.href = (href);
  a.click();
}

function downloadAllObjects(){
  for (var i = 0; i < window.top.editorsArray.length; i++) {
    let data = window.top.editorsArray[i];
    let fetchedData = data[1]();
    let id = data[0];
    downloadObject(fetchedData['filename'],fetchedData['code'])
  }
  for (var i = 0; i < assets.length; i++) {
    dlByURL(encodeURI("dlAsset.php?fn="+assets[i]['filename']+"&proj="+cproject));
  }
}

function makeAssets(){
  //var toReturn = "def";
   let myaxios = axios.get("makeAssets.php?proj="+encodeURI(cproject));
return myaxios.then(function (response) {
    //console.log(response.data);
    if(response.data.success == 1){
        return response.data.folder
    }else{
      return false;
    }
  }).catch(function (error) {
    alert("Failed to open project files.")
    return false;
  });
}

function compileApp(assetsFolder) {
let   myaxios = axios.get("compileApp.php?proj="+encodeURI(cproject)+"&assets="+encodeURI(assetsFolder)) ;
   return myaxios .then(function (response) {
    //console.log(response.data);
    if(response.data.success == 1){
        return response.data.file;
    }else{
      return false;
    }
  }).catch(function (error) {
    alert("Failed to compile application.");
  });
  
}

function compile(){
  Swal.fire("Building assets.. DO NOT MAKE ANY ACTIONS WITH FILES, THAT MIGHT CORRUPT THE FINAL APPLICATION!");
  makeAssets().then(resp=>{
    let assetsFolder = resp;
  if(assetsFolder !== false){
    Swal.fire("Compiling.. Please be patient and stay on this page.");
    compileApp(assetsFolder).then(response=>{    
      let compiled =  response;
      if(compiled == false){
        Swal.fire("Failed to compile application!");
    }else{
        Swal.fire("Compilation successful.");
        dlFile(compiled);
    }});
  }else{
    Swal.fire("Failed to build assets!");
  }});   
}
function renderTab(newTab,proj) {
  //saveFile(newTab,"");
    tabs.push(newTab);
    let tab = {}
   // console.log(newTab)
   let edID = Math.round(Math.random(1,999999)*1000);
    tab[newTab] = '<iframe src="editor.php?id='+edID+'&fn='+encodeURI(newTab)+'&proj='+proj+'" class="iframe"></iframe>';
    //window.editorsArray.push(edID);
    Object.assign(tabcontents,tab);
}
function newTab(evt, newTab) {
   if (tabs.indexOf(newTab) == -1) {
    renderTab(newTab,cproject);
    renderTabs(tabs);
   }else{
    alert("File already exists!");
   }
}

function rmTab(evt, tab) {
   if (tabs.indexOf(tab) == -1) {
    alert("File doesn't exist!");
   }else{
    tabs.splice(tab, 1);
    axios.get("rmFile.php?proj="+encodeURI(cproject)+"&fn="+encodeURI(tab))  .then(function (response) {
    //console.log(response.data);
    if(response.data.success == 1){
      Swal.fire("Success!");
    }else{
      Swal.fire("Failed to remove file. Got response: "+JSON.stringify(response.data));
    }
  })
  .catch(function (error) {
    alert("Failed to remove file.")
  });
    renderTabs(tabs);
   }
}
window.top.setFilename = function(fn,id){
  window.top['filename'+id] = fn;
}
</script>
   
</body>
</html> 
