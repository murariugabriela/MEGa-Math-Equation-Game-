var i = 0;
function openCloseForm() {
  if (!(i % 2 == 0))
    document.getElementById("myForm").style.display = "none";
  else
    document.getElementById("myForm").style.display = "block";
  i = i + 1;
}
function citat() {
  var citate = ["I’ve always enjoyed mathematics. It is the most precise and concise way of expressing an idea.", "There should be no such thing as boring mathematics.", "Mathematics is the music of reason.", "Matematician nu este cel ce știe matematică, ci cel ce creează matematică.", "Matematica este muzica raţiunii.", "Lumea este condusă de numere.", "Pure mathematics is, in its way, the poetry of logical ideas.", "Without mathematics, there’s nothing you can do. Everything around you is mathematics. Everything around you is numbers."];
  document.getElementById("citat").innerHTML = citate[Math.floor(Math.random() * (citate.length - 1))];
}
function Xsi0show(id) {
  var idCurent = id;
  var number = idCurent.substring(idCurent.length - 1);
  var idNecurent = "x-elem";
  document.getElementById(idCurent).style.innerHTML = idNecurent.concat(number);
  for (i = 1; i < 10; i++) {
    if (i != parseInt(number)) {
      document.getElementById(idNecurent.concat(i.toString())).style.display = "none";
    }
    else {
      document.getElementById(id).style.display = "block";
    }
  }
}
function displayCenterContentItem(id) {
  document.getElementById('teorie').style.display = "none";
  document.getElementById('probRezolvate').style.display = "none";
  document.getElementById('probNerezolvate').style.display = "none";
  document.getElementById('test').style.display = "none";
  document.getElementById(id).style.display = "flex";
  document.getElementById(id).style.flexDirection = "column";
}
function verifyAnswer(prefix) {
  document.getElementById(prefix + 'input1').textContent = '';
  document.getElementById(prefix + 'input2').textContent = '';
  document.getElementById(prefix + 'input3').textContent = '';
  document.getElementById(prefix + 'input4').textContent = '';
  document.getElementById(prefix + 'b').style.border = '1px solid gray';
  document.getElementById(prefix + 'd').style.border = '1px solid gray';
  document.getElementById(prefix + 'a').style.border = '1px solid gray';
  document.getElementById(prefix + 'c').style.border = '1px solid gray';
  if (document.getElementById(prefix + 'var1').checked) {
    if (document.getElementById(prefix + 'var1').value == 'true')
      document.getElementById(prefix + 'a').style.border = '3px solid limegreen';
    else
      document.getElementById(prefix + 'a').style.border = '3px solid red';
  }
  else if (!document.getElementById(prefix + 'var1').checked && document.getElementById(prefix + 'var1').value == 'true')
    document.getElementById(prefix + 'input1').textContent = 'Trebuia bifat';
  if (document.getElementById(prefix + 'var2').checked) {
    if (document.getElementById(prefix + 'var2').value == 'true')
      document.getElementById(prefix + 'b').style.border = '3px solid limegreen';
    else
      document.getElementById(prefix + 'b').style.border = '3px solid red';
  }
  else if (!document.getElementById(prefix + 'var2').checked && document.getElementById(prefix + 'var2').value == 'true')
    document.getElementById(prefix + 'input2').textContent = 'Trebuia bifat';
  if (document.getElementById(prefix + 'var3').checked) {
    if (document.getElementById(prefix + 'var3').value == 'true')
      document.getElementById(prefix + 'c').style.border = '3px solid limegreen';
    else
      document.getElementById(prefix + 'c').style.border = '3px solid red';
  }
  else if (!document.getElementById(prefix + 'var3').checked && document.getElementById(prefix + 'var3').value == 'true')
    document.getElementById(prefix + 'input3').textContent = 'Trebuia bifat';
  if (document.getElementById(prefix + 'var4').checked) {
    if (document.getElementById(prefix + 'var4').value == 'true')
      document.getElementById(prefix + 'd').style.border = '3px solid limegreen';
    else
      document.getElementById(prefix + 'd').style.border = '3px solid red';
  }
  else if (!document.getElementById(prefix + 'var4').checked && document.getElementById(prefix + 'var4').value == 'true')
    document.getElementById(prefix + 'input4').textContent = 'Trebuia bifat';

}
var seconds = 150;
var sufixCurent;
function displayTimer(sufix) {
  var id = 'timer';
  sufixCurent = sufix;
  var sufixNou;
  document.getElementById(id + sufixCurent).innerHTML = seconds.toString();
  document.getElementById('divtimer' + sufixCurent).style.background = 'yellow';
  seconds--;
  if(seconds == -1)
  {
    document.getElementById(id + sufixCurent).innerHTML = '';
    document.getElementById('divtimer' + sufixCurent).style.background = 'red';
    sufixNou = parseInt(sufix) + 1;
    sufixCurent =  sufixNou.toString();
    seconds = 150;
  }
}
var interval = setInterval(function() { displayTimer(sufixCurent); }, 1000);
