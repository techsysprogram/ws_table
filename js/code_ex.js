// $("#btn-group").click(function () {
//   var radios = document.getElementsByName("btnradio");

//   for (var i = 0; i < radios.length; i++) {
//     if (radios[i].checked) {
//       console.log(radios[i].value);
//       break;
//     }
//   }
// });

// aqui segun el nombre del objeto aqui le dare un accion al hacer click
// document.getElementById("carForm").onsubmit = store
// document.getElementById("clearButton").onclick = clearStorage
// document.getElementById("removeButton").onclick = removeItem
// document.getElementById("retrieveButton").onclick = retrieveRecords

// fetch(url)
//   .then(function (response) {
//     console.log(response.html);
//   })
//   .then(function (body) {
//     console.log(body);
//   });

// let response = fetch(url);

// console.log(response);

// if (response.ok) {
//   // if HTTP-status is 200-299
//   // get the response body (the method explained below)
//   console.log(response);
// } else {
//   alert("HTTP-Error: " + response.status);
// }

// $("#btnGerer").click(() => {
//   console.log("hizo click");
//   var cases = document.getElementsByClassName("form-check-input");
//   var resultat = "";
//   for (var i = 0; i < cases.length; i++) {
//     if (cases[i].checked) {
//       resultat += cases[i].value + ",";
//     } else {
//       //cases[i].checked = true;
//     }
//   }
//   //console.log(resultat);
//   $("#Gerer").html("vous allez activer les planches " + resultat);
// });

//var checkboxes2 = document.getElementsByClassName("table table-hover");

// for (i = 0; checkboxes2.length; i++) {
//   // boucle for //
//   var checkboxes = checkboxes2[i];
//   console.log(checkboxes);
//   //aqui le digo de poner en check el control
//   //checkboxes.checked = true;
// }

//console.log(checkboxes);
//aqui le digo de poner en check el control
//checkboxes.checked = true;

// for (var i = 0; i < checkboxes.length; i++) {
//   console.log(checkboxes);
//   //if (checkboxes[i].checked) {
//   console.log(checkboxes[i].checked);
//   //}
// }

//exemple// me recupera solo el primer valeur que es imput
// var elt = document.querySelector("input");
// console.log(elt);

// $("#flexCheckDefault").click(function () {
//   $("#answer2").html("te vi hiscistes click aqui ojito 55555");
//   console.log("hizo click en el checkk");
// });

// var selectValue =
//   document.getElementById("id_Select").options[
//     document.getElementById("id_Select").selectedIndex
//   ].value;
// select = document.getElementById("id_Select");
// choice = select.selectedIndex;
// valeur = select.options[choice].value;
// texte = select.options[choice].text;
// console.log(valeur);
//   $("#btnanswer").click(function () {
//     console.log("hizo click222");
//     var cases = document.getElementsByClassName("form-check-input");
//     var resultat = "";
//     for (var i = 0; i < cases.length; i++) {
//       if (cases[i].checked) {
//         resultat += cases[i].value + ",";
//       } else {
//         //cases[i].checked = true;
//       }
//     }
//     //console.log(resultat);
//     $("#answer").html("vous allez activer les planches " + resultat);
//   });

// $("#selectId>option").click(function () {
// $("select[name=watwiljedoen]").change(function () {
//   // console.log("selectiono");
//   window.location =
//     "https://www.ma-conciergerie.techsysprogram.com/page-test?idt=" +
//     this.value;
//   // alert(this.value);
// });

// Get the size of the entire webpage
// const pageWidth = document.documentElement.scrollWidth;
// const pageHeight = document.documentElement.scrollHeight;

// console.log(pageWidth);

//ensures the page is loaded before functions are executed.
// window.onload = function () {}

// window.addEventListener(
//   "load",
//   function () {
//     alert("hello!");
//   },
//   false
// );

// window.ready(
//   "load",
//   function () {
//     alert("hello!");
//   }
// );

// btn07.onclick = () => {
//   $("#Compra2").html("planches :" + tech_mostrar());
// };

// $("select[name=tech_form-select0]").change(function () {
//   console.log(this.value);
// });

// tech_selection.change(function () {
//   console.log(tech_selection);
// });
