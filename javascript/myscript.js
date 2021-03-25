var i=0;
    function openCloseForm() {
      if(!(i%2==0))
        document.getElementById("myForm").style.display = "none";
      else
        document.getElementById("myForm").style.display = "block";
      i=i+1;
  
  }