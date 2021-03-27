var i=0;
    function openCloseForm() {
      if(!(i%2==0))
        document.getElementById("myForm").style.display = "none";
      else
        document.getElementById("myForm").style.display = "block";
      i=i+1;
  }
  function citat(){
    var citate = ["I’ve always enjoyed mathematics. It is the most precise and concise way of expressing an idea.","There should be no such thing as boring mathematics.","Mathematics is the music of reason.","Matematician nu este cel ce știe matematică, ci cel ce creează matematică.","Matematica este muzica raţiunii.","Lumea este condusă de numere.","Pure mathematics is, in its way, the poetry of logical ideas.","Without mathematics, there’s nothing you can do. Everything around you is mathematics. Everything around you is numbers."];
    document.getElementById("citat").innerHTML = citate[Math.floor(Math.random() * (citate.length - 1))];
  }
