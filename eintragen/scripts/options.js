// var option = document.getElementByName('audioType');


// for (var i = 0, length = option.length; i < length; i++) {
//   if (option[i].checked) {
//     // do whatever you want with the checked radio
//     alert(option[i].value);

//     // only one radio can be logically checked, don't check the rest
//     break;
//   }
// }

$("#upload").change(function(){
	console.log($(this).val());
	$("#ytLinkBox").hide();
	$("#uploadBox").show();
	$("#ytLink").val('');
});

$("#stream").change(function(){
  console.log($(this).val());
	$("#ytLinkBox").show();
	$("#uploadBox").hide();
	$("#file").val('');
    
});





function veri(){
	console.log("hi");
	let input = document.getElementById("mountpoint");
	let form = document.getElementById("correct");
	let verifyBtn = document.getElementById("verifyBtn");

	let inputVal = input.value;
	if(inputVal in mountpoints){
		form.style.display = "initial";
		verifyBtn.style.backgroundColor = "green";
		verifyBtn.style.color = "white";
		verifyBtn.innerHTML = "verified";
	} else {
		verifyBtn.style.color = "white";
		verifyBtn.style.backgroundColor = "red";
		verifyBtn.innerHTML = "incorrect";
	}
}